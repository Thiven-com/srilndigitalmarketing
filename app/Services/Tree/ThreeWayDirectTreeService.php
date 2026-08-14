<?php

namespace App\Services\Tree;

use App\Models\Customer;
use App\Models\ThreeWayDirectReferral;
use Illuminate\Support\Facades\DB;

class ThreeWayDirectTreeService
{
    protected TreeService $treeService;

    public function __construct(TreeService $treeService)
    {
        $this->treeService = $treeService;
    }

    public function activate(Customer $customer): ?ThreeWayDirectReferral
    {
        return DB::transaction(function () use ($customer) {

            $existing = ThreeWayDirectReferral::where(
                'customer_id',
                $customer->id
            )->first();

            if ($existing) {
                return $existing;
            }

            $customerUserId = $customer->userid;

            if (!$customerUserId) {
                return null;
            }

            $rootUserId = config(
                'mlm.root_user_id',
                'SLM00000001'
            );

            $sponsorId = $customer->sponsor_id ?: $rootUserId;

            $rootExists = ThreeWayDirectReferral::where(
                'userId',
                $rootUserId
            )->exists();

            if (!$rootExists && $customerUserId === $rootUserId) {

                return $this->createRootNode($customer);
            }

            $treeUserId =
                $this->treeService->generateTreeUserId(
                    $customerUserId,
                    ThreeWayDirectReferral::class
                );

            $placement =
                $this->treeService->findPlacement(
                    $rootUserId,
                    $sponsorId,
                    ThreeWayDirectReferral::class,
                    3
                );

            $placedUnder =
                $placement['placedunder_id'];

            if (!$placedUnder) {
                throw new \Exception(
                    'Three-way direct root node not found.'
                );
            }

            $rootMap =
                $this->treeService->generateRootMap(
                    ThreeWayDirectReferral::class,
                    $placedUnder
                );

            $tree = new ThreeWayDirectReferral();

            $tree->customer_id = $customer->id;
            $tree->userId = $treeUserId;
            $tree->sponser_id = $sponsorId;
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

            $this->treeService->updateParentCounters(
                ThreeWayDirectReferral::class,
                $placedUnder
            );

            return $tree;
        });
    }


    protected function createRootNode(
        Customer $customer
    ): ThreeWayDirectReferral {

        $tree = new ThreeWayDirectReferral();

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