<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerPackage;
use App\Services\Tree\ThreeWayTreeService;
use App\Services\Tree\ThreeWayDirectTreeService;
use App\Services\Tree\FiveWayTreeService;
use App\Services\Tree\FiveWayDirectTreeService;
use App\Services\Tree\BonusService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerPackageController extends Controller
{
    protected ThreeWayTreeService $threeWayTree;

    protected ThreeWayDirectTreeService $threeWayDirectTree;

    protected FiveWayTreeService $fiveWayTree;

    protected FiveWayDirectTreeService $fiveWayDirectTree;

    protected BonusService $bonusService;


    public function __construct(
        ThreeWayTreeService $threeWayTree,
        ThreeWayDirectTreeService $threeWayDirectTree,
        FiveWayTreeService $fiveWayTree,
        FiveWayDirectTreeService $fiveWayDirectTree,
        BonusService $bonusService
    ) {

        $this->threeWayTree =
            $threeWayTree;

        $this->threeWayDirectTree =
            $threeWayDirectTree;

        $this->fiveWayTree =
            $fiveWayTree;

        $this->fiveWayDirectTree =
            $fiveWayDirectTree;

        $this->bonusService =
            $bonusService;
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

            $search =
                $request->search;

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


        $customerPackages =
            $query->paginate(20);


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
        $customerPackage =
            CustomerPackage::with([
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

        $customerPackage =
            CustomerPackage::with([
                'customer',
                'package'
            ])->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Already approved
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


        if (!$customerPackage->customer) {

            return back()->with(
                'error',
                'Customer not found.'
            );
        }


        if (!$customerPackage->package) {

            return back()->with(
                'error',
                'Package not found.'
            );
        }


        try {

            DB::transaction(function () use ($customerPackage) {

                /*
                |--------------------------------------------------------------------------
                | Approve payment
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
                | Add customer to package tree
                |--------------------------------------------------------------------------
                */

                $treeType =
                    $this->getTreeType(
                        $customerPackage->package
                    );


                $this->activateTree(
                    $customerPackage,
                    $treeType
                );


                /*
                |--------------------------------------------------------------------------
                | Six Level Bonus
                |--------------------------------------------------------------------------
                */

                $this->distributeBonus(
                    $customerPackage,
                    $treeType
                );
            });


            return back()->with(
                'success',
                'Package approved, customer added to tree and six-level bonus distributed successfully.'
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
    | DETERMINE TREE
    |--------------------------------------------------------------------------
    */

    protected function getTreeType($package): string
    {
        /*
        |--------------------------------------------------------------------------
        | Recommended:
        |
        | Package tree_type should be:
        |
        | three
        | three_direct
        | five
        | five_direct
        |--------------------------------------------------------------------------
        */

        if (!empty($package->tree_type)) {

            return $package->tree_type;
        }


        /*
        |--------------------------------------------------------------------------
        | Fallback based on package ID
        |--------------------------------------------------------------------------
        |
        | You currently have:
        |
        | Package 1
        | Package 2
        | Package 3
        | Package 4
        |
        */

        return match ((int) $package->id) {

            1 => 'three',

            2 => 'five',

            3 => 'three_direct',

            4 => 'five_direct',

            default => 'three',
        };
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


        switch ($treeType) {

            case 'three':

                $this->threeWayTree
                    ->activate($customer);

                break;


            case 'three_direct':

                $this->threeWayDirectTree
                    ->activate($customer);

                break;


            case 'five':

                $this->fiveWayTree
                    ->activate($customer);

                break;


            case 'five_direct':

                $this->fiveWayDirectTree
                    ->activate($customer);

                break;


            default:

                throw new \Exception(
                    "Invalid package tree type: {$treeType}"
                );
        }
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

        $customer = Customer::find($customerPackage->customer_id);

        if (!$customer) {
            throw new \Exception('Customer not found.');
        }

        /*
        |--------------------------------------------------------------------------
        | Select Tree Model Based On Package Tree Type
        |--------------------------------------------------------------------------
        */

        $treeModel = match ($treeType) {

            'three' =>
            \App\Models\ThreeWayReferral::class,

            'three_direct' =>
            \App\Models\ThreeWayDirectReferral::class,

            'five' =>
            \App\Models\FiveWayReferral::class,

            'five_direct' =>
            \App\Models\FiveWayDirectReferral::class,

            default =>
            throw new \Exception(
                'Invalid tree type: ' . $treeType
            ),
        };

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


        if (
            $customerPackage->payment_status ===
            'approved'
        ) {

            return back()->with(
                'error',
                'Approved package cannot be rejected.'
            );
        }


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