<?php

namespace App\Services\Tree;

use App\Models\Customer;
use App\Models\ThreeWayReferral;
use Illuminate\Support\Facades\DB;

class ThreeWayTreeService
{
    protected TreeService $treeService;

    public function __construct(
        TreeService $treeService
    ) {
        $this->treeService = $treeService;
    }


    /**
     * Activate customer in a specific package tree.
     *
     * Same customer can exist in multiple package trees:
     *
     * Package 1 + SLM00000025
     * Package 2 + SLM00000025
     * Package 3 + SLM00000025
     *
     * But only one record for:
     *
     * package_id + userId
     */
    public function activate(
        Customer $customer,
        int|string $packageId
    ): ?ThreeWayReferral {

        return DB::transaction(function () use (
            $customer,
            $packageId
        ) {

            $packageId = (int) $packageId;

            $userId = $customer->userid;


            /*
            |--------------------------------------------------------------------------
            | Validate User ID
            |--------------------------------------------------------------------------
            */

            if (!$userId) {

                throw new \Exception(
                    'Customer User ID not found.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | CHECK EXISTING RECORD
            |--------------------------------------------------------------------------
            |
            | IMPORTANT:
            |
            | Do NOT check only customer_id.
            |
            | Unique tree member is:
            |
            | package_id + userId
            |
            */

            $existing = ThreeWayReferral::where(
                'package_id',
                $packageId
            )
                ->where(
                    'userId',
                    $userId
                )
                ->first();


            if ($existing) {

                return $existing;
            }


            /*
            |--------------------------------------------------------------------------
            | ROOT USER
            |--------------------------------------------------------------------------
            */

            $rootUserId = config(
                'mlm.root_user_id',
                'SLM00000001'
            );


            /*
            |--------------------------------------------------------------------------
            | FIND ROOT FOR THIS PACKAGE
            |--------------------------------------------------------------------------
            |
            | Every package has its own root record.
            |
            */

            $root = ThreeWayReferral::where(
                'package_id',
                $packageId
            )
                ->where(
                    'userId',
                    $rootUserId
                )
                ->first();


            /*
            |--------------------------------------------------------------------------
            | CUSTOMER IS ROOT
            |--------------------------------------------------------------------------
            */

            if ($userId === $rootUserId) {

                /*
                |--------------------------------------------------------------------------
                | Root already exists for this package
                |--------------------------------------------------------------------------
                */

                if ($root) {

                    return $root;
                }


                /*
                |--------------------------------------------------------------------------
                | Create package root
                |--------------------------------------------------------------------------
                */

                return $this->createRootNode(
                    $customer,
                    $packageId
                );
            }


            /*
            |--------------------------------------------------------------------------
            | ROOT MUST EXIST
            |--------------------------------------------------------------------------
            */

            if (!$root) {

                throw new \Exception(
                    'Three-way root node not found for Package ID '
                    . $packageId
                    . '. Please initialize the package root first.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | CUSTOMER SPONSOR
            |--------------------------------------------------------------------------
            */

            $sponsorId =
                $customer->sponsor_id
                ?: $rootUserId;


            /*
            |--------------------------------------------------------------------------
            | CHECK SPONSOR IN SAME PACKAGE TREE
            |--------------------------------------------------------------------------
            */

            $sponsorNode = ThreeWayReferral::where(
                'package_id',
                $packageId
            )
                ->where(
                    'userId',
                    $sponsorId
                )
                ->first();


            /*
            |--------------------------------------------------------------------------
            | Sponsor Does Not Exist In This Package
            |--------------------------------------------------------------------------
            |
            | Example:
            |
            | Customer A has Package 1
            | Sponsor has only Package 2
            |
            | Sponsor cannot be used from Package 2.
            |
            | Start from Package 1 root.
            |
            */

            if (!$sponsorNode) {

                $sponsorId =
                    $rootUserId;
            }


            /*
            |--------------------------------------------------------------------------
            | FIND PLACEMENT
            |--------------------------------------------------------------------------
            */

            $placedUnder =
                $this->findPackagePlacement(
                    $rootUserId,
                    $sponsorId,
                    $packageId
                );


            if (!$placedUnder) {

                throw new \Exception(
                    'Unable to find placement in Three-Way tree for Package ID '
                    . $packageId
                );
            }


            /*
            |--------------------------------------------------------------------------
            | ROOT MAP
            |--------------------------------------------------------------------------
            */

            $rootMap =
                $this->generatePackageRootMap(
                    $placedUnder,
                    $packageId
                );


            /*
            |--------------------------------------------------------------------------
            | CREATE TREE NODE
            |--------------------------------------------------------------------------
            */

            $tree =
                new ThreeWayReferral();


            $tree->customer_id =
                $customer->id;


            /*
            |--------------------------------------------------------------------------
            | PACKAGE ID
            |--------------------------------------------------------------------------
            */

            $tree->package_id =
                $packageId;


            /*
            |--------------------------------------------------------------------------
            | USER ID
            |--------------------------------------------------------------------------
            */

            $tree->userId =
                $userId;


            /*
            |--------------------------------------------------------------------------
            | SPONSOR
            |--------------------------------------------------------------------------
            */

            $tree->sponser_id =
                $sponsorId;


            /*
            |--------------------------------------------------------------------------
            | PLACEMENT
            |--------------------------------------------------------------------------
            */

            $tree->placedunder_id =
                $placedUnder;


            /*
            |--------------------------------------------------------------------------
            | POINTS
            |--------------------------------------------------------------------------
            */

            $tree->left_points =
                0;

            $tree->right_points =
                0;

            $tree->total_income =
                0;


            /*
            |--------------------------------------------------------------------------
            | SETTLEMENT
            |--------------------------------------------------------------------------
            */

            $tree->last_settled_at =
                null;


            /*
            |--------------------------------------------------------------------------
            | ROOT MAP
            |--------------------------------------------------------------------------
            */

            $tree->rootmap =
                $rootMap;


            /*
            |--------------------------------------------------------------------------
            | OTHER VALUES
            |--------------------------------------------------------------------------
            */

            $tree->points =
                0;

            $tree->edate =
                now();

            $tree->g_count =
                0;

            $tree->g_reff =
                $userId;

            $tree->placedunderid_cnt =
                0;

            $tree->cron_start =
                null;

            $tree->cron_end =
                null;


            /*
            |--------------------------------------------------------------------------
            | SAVE
            |--------------------------------------------------------------------------
            */

            $tree->save();


            /*
            |--------------------------------------------------------------------------
            | UPDATE PARENT COUNTERS
            |--------------------------------------------------------------------------
            */

            $this->updatePackageParentCounters(
                $placedUnder,
                $packageId
            );


            return $tree;
        });
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE ROOT NODE
    |--------------------------------------------------------------------------
    */

    protected function createRootNode(
        Customer $customer,
        int $packageId
    ): ThreeWayReferral {

        /*
        |--------------------------------------------------------------------------
        | Double Check Root
        |--------------------------------------------------------------------------
        */

        $existing = ThreeWayReferral::where(
            'package_id',
            $packageId
        )
            ->where(
                'userId',
                $customer->userid
            )
            ->first();


        if ($existing) {

            return $existing;
        }


        /*
        |--------------------------------------------------------------------------
        | Create Root
        |--------------------------------------------------------------------------
        */

        $tree =
            new ThreeWayReferral();


        $tree->customer_id =
            $customer->id;


        /*
        |--------------------------------------------------------------------------
        | PACKAGE ID
        |--------------------------------------------------------------------------
        */

        $tree->package_id =
            $packageId;


        /*
        |--------------------------------------------------------------------------
        | ROOT USER ID
        |--------------------------------------------------------------------------
        */

        $tree->userId =
            $customer->userid;


        /*
        |--------------------------------------------------------------------------
        | ROOT HAS NO SPONSOR
        |--------------------------------------------------------------------------
        */

        $tree->sponser_id =
            null;


        /*
        |--------------------------------------------------------------------------
        | ROOT HAS NO PARENT
        |--------------------------------------------------------------------------
        */

        $tree->placedunder_id =
            null;


        /*
        |--------------------------------------------------------------------------
        | POINTS
        |--------------------------------------------------------------------------
        */

        $tree->left_points =
            0;

        $tree->right_points =
            0;

        $tree->total_income =
            0;


        /*
        |--------------------------------------------------------------------------
        | SETTLEMENT
        |--------------------------------------------------------------------------
        */

        $tree->last_settled_at =
            null;


        /*
        |--------------------------------------------------------------------------
        | ROOT MAP
        |--------------------------------------------------------------------------
        */

        $tree->rootmap =
            ',' .
            $customer->userid .
            ',';


        /*
        |--------------------------------------------------------------------------
        | OTHER VALUES
        |--------------------------------------------------------------------------
        */

        $tree->points =
            0;

        $tree->edate =
            now();

        $tree->g_count =
            0;

        $tree->g_reff =
            $customer->userid;

        $tree->placedunderid_cnt =
            0;

        $tree->cron_start =
            null;

        $tree->cron_end =
            null;


        $tree->save();


        return $tree;
    }


    /*
    |--------------------------------------------------------------------------
    | FIND PACKAGE PLACEMENT
    |--------------------------------------------------------------------------
    |
    | Three-Way Tree:
    |
    | Maximum 3 direct children per parent.
    |
    | IMPORTANT:
    | Every query is restricted to package_id.
    |
    */

    protected function findPackagePlacement(
        string $rootUserId,
        string $sponsorId,
        int $packageId
    ): ?string {

        /*
        |--------------------------------------------------------------------------
        | Start From Sponsor
        |--------------------------------------------------------------------------
        */

        $startNode =
            ThreeWayReferral::where(
                'package_id',
                $packageId
            )
                ->where(
                    'userId',
                    $sponsorId
                )
                ->first();


        /*
        |--------------------------------------------------------------------------
        | If Sponsor Not Found, Start From Package Root
        |--------------------------------------------------------------------------
        */

        if (!$startNode) {

            $startNode =
                ThreeWayReferral::where(
                    'package_id',
                    $packageId
                )
                    ->where(
                        'userId',
                        $rootUserId
                    )
                    ->first();
        }


        if (!$startNode) {

            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | BFS QUEUE
        |--------------------------------------------------------------------------
        */

        $queue = [
            $startNode->userId
        ];


        $visited = [];


        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        while (!empty($queue)) {

            $currentUserId =
                array_shift($queue);


            /*
            |--------------------------------------------------------------------------
            | Prevent Duplicate Search
            |--------------------------------------------------------------------------
            */

            if (
                isset(
                    $visited[$currentUserId]
                )
            ) {

                continue;
            }


            $visited[$currentUserId] =
                true;


            /*
            |--------------------------------------------------------------------------
            | Get Children From SAME PACKAGE
            |--------------------------------------------------------------------------
            */

            $children =
                ThreeWayReferral::where(
                    'package_id',
                    $packageId
                )
                    ->where(
                        'placedunder_id',
                        $currentUserId
                    )
                    ->orderBy(
                        'id',
                        'asc'
                    )
                    ->get();


            /*
            |--------------------------------------------------------------------------
            | Parent Has Available Position
            |--------------------------------------------------------------------------
            */

            if (
                $children->count() < 3
            ) {

                return $currentUserId;
            }


            /*
            |--------------------------------------------------------------------------
            | Add Children To Queue
            |--------------------------------------------------------------------------
            */

            foreach (
                $children
                as $child
            ) {

                $queue[] =
                    $child->userId;
            }
        }


        return null;
    }


    /*
    |--------------------------------------------------------------------------
    | GENERATE ROOT MAP
    |--------------------------------------------------------------------------
    */

    protected function generatePackageRootMap(
        string $placedUnder,
        int $packageId
    ): string {

        $path = [];


        /*
        |--------------------------------------------------------------------------
        | Start From Parent
        |--------------------------------------------------------------------------
        */

        $current =
            ThreeWayReferral::where(
                'package_id',
                $packageId
            )
                ->where(
                    'userId',
                    $placedUnder
                )
                ->first();


        /*
        |--------------------------------------------------------------------------
        | Build Parent Path
        |--------------------------------------------------------------------------
        */

        while ($current) {

            array_unshift(
                $path,
                $current->userId
            );


            /*
            |--------------------------------------------------------------------------
            | Root Reached
            |--------------------------------------------------------------------------
            */

            if (!$current->placedunder_id) {

                break;
            }


            /*
            |--------------------------------------------------------------------------
            | Find Parent In SAME PACKAGE
            |--------------------------------------------------------------------------
            */

            $current =
                ThreeWayReferral::where(
                    'package_id',
                    $packageId
                )
                    ->where(
                        'userId',
                        $current->placedunder_id
                    )
                    ->first();
        }


        return ',' .
            implode(',', $path) .
            ',';
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE PARENT CHILD COUNT
    |--------------------------------------------------------------------------
    */

    protected function updatePackageParentCounters(
        string $placedUnder,
        int $packageId
    ): void {

        /*
        |--------------------------------------------------------------------------
        | Find Parent In SAME PACKAGE
        |--------------------------------------------------------------------------
        */

        $parent =
            ThreeWayReferral::where(
                'package_id',
                $packageId
            )
                ->where(
                    'userId',
                    $placedUnder
                )
                ->first();


        if (!$parent) {

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Count Children In SAME PACKAGE
        |--------------------------------------------------------------------------
        */

        $count =
            ThreeWayReferral::where(
                'package_id',
                $packageId
            )
                ->where(
                    'placedunder_id',
                    $placedUnder
                )
                ->count();


        $parent->placedunderid_cnt =
            $count;


        $parent->save();
    }
}