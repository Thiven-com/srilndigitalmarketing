<?php

namespace App\Services\Tree;

use App\Models\Customer;
use App\Models\ThreeWayReferral;
use Illuminate\Support\Facades\DB;

class ThreeWayTreeService
{
    protected TreeService $treeService;

    public function __construct(TreeService $treeService)
    {
        $this->treeService = $treeService;
    }

    public function activate(Customer $customer, string $packageId): ?ThreeWayReferral
    {
        return DB::transaction(function () use ($customer, $packageId) {

            $existing = ThreeWayReferral::where('customer_id', $customer->id)
                ->where('package_id', $packageId)
                ->first();

            if ($existing) {
                return $existing;
            }

            $customerUserId = $customer->userid;

            if (!$customerUserId) {
                return null;
            }

            /*
            |--------------------------------------------------------------------------
            | Root User
            |--------------------------------------------------------------------------
            |
            | Change this to your actual root user ID.
            |
            */

            $rootUserId = config(
                'mlm.root_user_id',
                'SLM00000001'
            );

            /*
            |--------------------------------------------------------------------------
            | Sponsor
            |--------------------------------------------------------------------------
            */

            $sponsorId = $customer->sponsor_id ?: $rootUserId;

            /*
            |--------------------------------------------------------------------------
            | First Root Node
            |--------------------------------------------------------------------------
            */

            $rootExists = ThreeWayReferral::where(
                'userId',
                $rootUserId
            )
                ->where(
                    'package_id',
                    $packageId
                )->exists();

            /*
            |--------------------------------------------------------------------------
            | If this customer itself is the root
            |--------------------------------------------------------------------------
            */

            if (!$rootExists && $customerUserId === $rootUserId) {

                return $this->createRootNode($customer);
            }

            /*
            |--------------------------------------------------------------------------
            | Generate tree user ID
            |--------------------------------------------------------------------------
            */

            $treeUserId =
                $this->treeService->generateTreeUserId(
                    $customerUserId,
                    ThreeWayReferral::class
                );

            /*
            |--------------------------------------------------------------------------
            | Find placement
            |--------------------------------------------------------------------------
            */

            $placement =
                $this->treeService->findPlacement(
                    $rootUserId,
                    $sponsorId,
                    ThreeWayReferral::class,
                    3
                );

            $placedUnder =
                $placement['placedunder_id'];

            if (!$placedUnder) {
                throw new \Exception(
                    'Three-way root node not found.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Root Map
            |--------------------------------------------------------------------------
            */

            $rootMap =
                $this->treeService->generateRootMap(
                    ThreeWayReferral::class,
                    $placedUnder
                );

            /*
            |--------------------------------------------------------------------------
            | Insert
            |--------------------------------------------------------------------------
            */

            $tree = new ThreeWayReferral();

            $tree->customer_id = $customer->id;
            $tree->userId = $treeUserId;
            $tree->sponser_id = $sponsorId;
            $tree->package_id = $packageId;
            $tree->placedunder_id = $placedUnder;

            $tree->left_points = 0;
            $tree->right_points = 0;
            $tree->total_income = 0;

            $tree->rootmap = $rootMap;
            $tree->presenttime = now();
            $tree->points = 0;
            $tree->edate = now();

            $tree->g_count = 0;
            $tree->g_reff = $customerUserId;
            $tree->placedunderid_cnt = 0;

            $tree->cron_start = null;
            $tree->cron_end = null;

            $tree->save();

            /*
            |--------------------------------------------------------------------------
            | Update parent
            |--------------------------------------------------------------------------
            */

            $this->treeService->updateParentCounters(
                ThreeWayReferral::class,
                $placedUnder
            );

            /*
            |--------------------------------------------------------------------------
            | Customer
            |--------------------------------------------------------------------------
            */

            $customer->placedunder_id = $placedUnder;
            $customer->rootmap = $rootMap;
            $customer->save();

            return $tree;
        });
    }


    protected function createRootNode(
        Customer $customer
    ): ThreeWayReferral {

        $tree = new ThreeWayReferral();

        $tree->customer_id = $customer->id;
        $tree->userId = $customer->userid;
        $tree->sponser_id = $customer->userid;
        $tree->placedunder_id = null;

        $tree->left_points = 0;
        $tree->right_points = 0;
        $tree->total_income = 0;

        $tree->rootmap = ',' . $customer->userid . ',';

        $tree->presenttime = now();
        $tree->points = 0;
        $tree->edate = now();

        $tree->g_count = 0;
        $tree->g_reff = $customer->userid;
        $tree->placedunderid_cnt = 0;

        $tree->cron_start = null;
        $tree->cron_end = null;

        $tree->save();

        return $tree;
    }
}