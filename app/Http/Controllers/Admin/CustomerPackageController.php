<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerPackage;
use App\Models\ThreeWayReferral;
use App\Services\Tree\ThreeWayTreeService;
use App\Services\Tree\BonusService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerPackageController extends Controller
{
    protected ThreeWayTreeService $threeWayTree;

    protected BonusService $bonusService;


    public function __construct(
        ThreeWayTreeService $threeWayTree,
        BonusService $bonusService
    ) {
        $this->threeWayTree = $threeWayTree;

        $this->bonusService = $bonusService;
    }


    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = CustomerPackage::with([
            'customer',
            'package'
        ])->latest();


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where(
                    'order_number',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'payment_reference',
                    'like',
                    "%{$search}%"
                )

                ->orWhereHas(
                    'customer',
                    function ($customerQuery) use ($search) {

                        $customerQuery
                            ->where(
                                'name',
                                'like',
                                "%{$search}%"
                            )

                            ->orWhere(
                                'mobile',
                                'like',
                                "%{$search}%"
                            )

                            ->orWhere(
                                'email',
                                'like',
                                "%{$search}%"
                            )

                            ->orWhere(
                                'userid',
                                'like',
                                "%{$search}%"
                            );
                    }
                );
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Payment Status
        |--------------------------------------------------------------------------
        */

        if ($request->filled('payment_status')) {

            $query->where(
                'payment_status',
                $request->payment_status
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Package Status
        |--------------------------------------------------------------------------
        */

        if ($request->filled('package_status')) {

            $query->where(
                'package_status',
                $request->package_status
            );
        }
        if($request->payment_status == 'pending'){
            $query->where(
                'payment_status',
                'pending'
            );
        }


        $customerPackages = $query->paginate(20);


        return view(
            'admin.customer-packages.index',
            compact('customerPackages')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        $customerPackage = CustomerPackage::with([
            'customer',
            'package'
        ])->findOrFail($id);


        return view(
            'admin.customer-packages.show',
            compact('customerPackage')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | APPROVE
    |--------------------------------------------------------------------------
    */

    public function approve(
        Request $request,
        $id
    ) {

        $customerPackage = CustomerPackage::with([
            'customer',
            'package'
        ])->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Already Approved
        |--------------------------------------------------------------------------
        */

        if (
            $customerPackage->payment_status ===
            'approved'
        ) {

            return back()->with(
                'error',
                'This package payment is already approved.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Customer Check
        |--------------------------------------------------------------------------
        */

        if (!$customerPackage->customer) {

            return back()->with(
                'error',
                'Customer not found.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Package Check
        |--------------------------------------------------------------------------
        */

        if (!$customerPackage->package) {

            return back()->with(
                'error',
                'Package not found.'
            );
        }


        try {

            DB::transaction(function () use (
                $customerPackage
            ) {

                /*
                |--------------------------------------------------------------------------
                | Approve Payment
                |--------------------------------------------------------------------------
                */

                $customerPackage->payment_status =
                    'approved';

                $customerPackage->package_status =
                    'active';

                $customerPackage->approved_by =
                    auth()->id();

                $customerPackage->approved_at =
                    now();

                $customerPackage->activated_at =
                    now();

                $customerPackage->admin_remark =
                    null;

                $customerPackage->save();


                /*
                |--------------------------------------------------------------------------
                | Tree Type
                |--------------------------------------------------------------------------
                |
                | All current packages use Three-Way Tree.
                |
                */

                $treeType =
                    $this->getTreeType(
                        $customerPackage->package
                    );


                /*
                |--------------------------------------------------------------------------
                | Activate Customer In Package Tree
                |--------------------------------------------------------------------------
                */

                $this->activateTree(
                    $customerPackage,
                    $treeType
                );


                /*
                |--------------------------------------------------------------------------
                | Distribute Six Level Bonus
                |--------------------------------------------------------------------------
                */

                $this->distributeBonus(
                    $customerPackage,
                    $treeType
                );
            });


            return back()->with(
                'success',
                'Package approved, customer added to the package tree and six-level bonus distributed successfully.'
            );

        } catch (\Throwable $e) {

            report($e);

            return back()->with(
                'error',
                'Package approval failed: ' .
                $e->getMessage()
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | DETERMINE TREE TYPE
    |--------------------------------------------------------------------------
    */

    protected function getTreeType($package): string
    {
        /*
        |--------------------------------------------------------------------------
        | All Current Packages Are Three-Way
        |--------------------------------------------------------------------------
        */

        if (
            !empty($package->tree_type) &&
            $package->tree_type === 'three'
        ) {
            return 'three';
        }


        /*
        |--------------------------------------------------------------------------
        | Default
        |--------------------------------------------------------------------------
        */

        return 'three';
    }


    /*
    |--------------------------------------------------------------------------
    | ACTIVATE TREE
    |--------------------------------------------------------------------------
    */

    protected function activateTree(
        CustomerPackage $customerPackage,
        string $treeType
    ): void {

        $customer =
            $customerPackage->customer;


        if (!$customer) {

            throw new \Exception(
                'Customer not found.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Package ID
        |--------------------------------------------------------------------------
        |
        | Every package has its own Three-Way tree.
        |
        */

        $packageId =
            (int) $customerPackage->package_id;


        /*
        |--------------------------------------------------------------------------
        | Three-Way Tree
        |--------------------------------------------------------------------------
        */

        if ($treeType === 'three') {

            $this->threeWayTree->activate(
                $customer,
                $packageId
            );

            return;
        }


        throw new \Exception(
            "Invalid package tree type: {$treeType}"
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DISTRIBUTE BONUS
    |--------------------------------------------------------------------------
    */

    protected function distributeBonus(
        CustomerPackage $customerPackage,
        string $treeType
    ): void {

        $customer =
            Customer::find(
                $customerPackage->customer_id
            );


        if (!$customer) {

            throw new \Exception(
                'Customer not found.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Current System
        |--------------------------------------------------------------------------
        |
        | All packages use the same Three-Way tree model.
        |
        */

        $treeModel =
            ThreeWayReferral::class;


        /*
        |--------------------------------------------------------------------------
        | Distribute Package Bonus
        |--------------------------------------------------------------------------
        */

        $this->bonusService->distribute(
            $customerPackage,
            $treeModel
        );
    }


    /*
    |--------------------------------------------------------------------------
    | REJECT
    |--------------------------------------------------------------------------
    */

    public function reject(
        Request $request,
        $id
    ) {

        $request->validate([

            'admin_remark' =>
                'required|string|max:1000',

        ]);


        $customerPackage =
            CustomerPackage::findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Approved Package Cannot Be Rejected
        |--------------------------------------------------------------------------
        */

        if (
            $customerPackage->payment_status ===
            'approved'
        ) {

            return back()->with(
                'error',
                'Approved package cannot be rejected.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Reject Package
        |--------------------------------------------------------------------------
        */

        $customerPackage->payment_status =
            'rejected';

        $customerPackage->package_status =
            'rejected';

        $customerPackage->rejected_at =
            now();

        $customerPackage->admin_remark =
            $request->admin_remark;

        $customerPackage->save();


        return back()->with(
            'success',
            'Package purchase rejected successfully.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $customerPackage =
            CustomerPackage::findOrFail($id);


        $customerPackage->delete();


        return redirect()
            ->route(
                'admin.customer-packages.index'
            )
            ->with(
                'success',
                'Customer package deleted successfully.'
            );
    }
}