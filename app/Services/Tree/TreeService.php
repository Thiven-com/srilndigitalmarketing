<?php

namespace App\Services\Tree;

use Illuminate\Support\Facades\DB;

class TreeService
{
    /**
     * Find placement node.
     *
     * Three-way  = maximum 3 children
     * Five-way   = maximum 5 children
     */
    public function findPlacement(
        string $rootUserId,
        string $sponsorUserId,
        string $treeModel,
        int $maxChildren
    ): array {

        /*
        |--------------------------------------------------------------------------
        | Sponsor fallback
        |--------------------------------------------------------------------------
        */

        if (empty($sponsorUserId)) {
            $sponsorUserId = $rootUserId;
        }

        /*
        |--------------------------------------------------------------------------
        | Check sponsor exists in this tree
        |--------------------------------------------------------------------------
        */

        $sponsor = $treeModel::where(
            'userId',
            $sponsorUserId
        )->first();

        /*
        |--------------------------------------------------------------------------
        | Sponsor does not exist in this tree
        |--------------------------------------------------------------------------
        |
        | Use ROOT user as placement starting point.
        |
        */

        if (!$sponsor) {

            $rootNode = $treeModel::where(
                'userId',
                $rootUserId
            )->first();

            if ($rootNode) {

                $placement = $this->findAvailableNode(
                    $treeModel,
                    $rootNode->userId,
                    $maxChildren
                );

                return [
                    'sponsor_id' => $sponsorUserId,
                    'placedunder_id' => $placement['userId'],
                ];
            }

            /*
            |--------------------------------------------------------------------------
            | No root exists yet
            |--------------------------------------------------------------------------
            */

            return [
                'sponsor_id' => $sponsorUserId,
                'placedunder_id' => null,
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Find first available node under sponsor
        |--------------------------------------------------------------------------
        */

        $placement = $this->findAvailableNode(
            $treeModel,
            $sponsor->userId,
            $maxChildren
        );

        return [
            'sponsor_id' => $sponsorUserId,
            'placedunder_id' => $placement['userId'],
        ];
    }


    /**
     * Find first node which has capacity.
     *
     * Example three-way:
     *
     * A
     * ├── B
     * ├── C
     * └── D
     *
     * A is full.
     * Continue searching B, C, D.
     *
     * Example five-way:
     *
     * A
     * ├── B
     * ├── C
     * ├── D
     * ├── E
     * └── F
     */
    public function findAvailableNode(
        string $treeModel,
        string $startUserId,
        int $maxChildren
    ): array {

        $queue = [$startUserId];

        $visited = [];

        while (!empty($queue)) {

            $currentUserId = array_shift($queue);

            /*
            |--------------------------------------------------------------------------
            | Prevent duplicate traversal
            |--------------------------------------------------------------------------
            */

            if (in_array($currentUserId, $visited, true)) {
                continue;
            }

            $visited[] = $currentUserId;

            /*
            |--------------------------------------------------------------------------
            | Get current node
            |--------------------------------------------------------------------------
            */

            $node = $treeModel::where(
                'userId',
                $currentUserId
            )->first();

            if (!$node) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Number of children
            |--------------------------------------------------------------------------
            |
            | Do NOT use position.
            |
            */

            $childCount = $treeModel::where(
                'placedunder_id',
                $node->userId
            )->count();

            /*
            |--------------------------------------------------------------------------
            | Node has available slot
            |--------------------------------------------------------------------------
            */

            if ($childCount < $maxChildren) {

                return [
                    'userId' => $node->userId,
                ];
            }

            /*
            |--------------------------------------------------------------------------
            | Node is full
            |--------------------------------------------------------------------------
            |
            | Continue down the tree.
            |
            */

            $children = $treeModel::where(
                'placedunder_id',
                $node->userId
            )
                ->orderBy('id')
                ->get();

            foreach ($children as $child) {

                if (!in_array($child->userId, $visited, true)) {

                    $queue[] = $child->userId;
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Fallback
        |--------------------------------------------------------------------------
        */

        return [
            'userId' => $startUserId,
        ];
    }


    /**
     * Generate tree user ID.
     */
    public function generateTreeUserId(
        string $customerUserId,
        string $treeModel
    ): string {

        $count = $treeModel::where(
            'g_reff',
            $customerUserId
        )->count();

        if ($count === 0) {
            return $customerUserId;
        }

        return $customerUserId . '-' . ($count + 1);
    }


    /**
     * Generate root map.
     */
    public function generateRootMap(
        string $treeModel,
        string $placedUnder
    ): string {

        $parent = $treeModel::where(
            'userId',
            $placedUnder
        )->first();

        if ($parent && !empty($parent->rootmap)) {

            return $parent->rootmap .
                $placedUnder .
                ',';
        }

        return ',' . $placedUnder . ',';
    }


    /**
     * Update parent counters.
     *
     * There is NO position column.
     */
    public function updateParentCounters(
        string $treeModel,
        string $placedUnder
    ): void {

        $parent = $treeModel::where(
            'userId',
            $placedUnder
        )->first();

        if (!$parent) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Child count
        |--------------------------------------------------------------------------
        */

        $childCount = $treeModel::where(
            'placedunder_id',
            $placedUnder
        )->count();

        $parent->placedunderid_cnt = $childCount;

        /*
        |--------------------------------------------------------------------------
        | Total generation count
        |--------------------------------------------------------------------------
        */

        $parent->g_count =
            ((int) $parent->g_count) + 1;

        /*
        |--------------------------------------------------------------------------
        | Points
        |--------------------------------------------------------------------------
        */

        $parent->points =
            ((float) $parent->points) + 1;

        $parent->save();
    }


    /**
     * Update all ancestors.
     *
     * This is useful when you want the complete upline
     * to have their counters updated.
     */
    public function updateAncestors(
        string $treeModel,
        string $placedUnder
    ): void {

        $current = $treeModel::where(
            'userId',
            $placedUnder
        )->first();

        while ($current) {

            $current->placedunderid_cnt =
                $treeModel::where(
                    'placedunder_id',
                    $current->userId
                )->count();

            $current->g_count =
                ((int) $current->g_count) + 1;

            $current->save();

            $parentId = $current->placedunder_id;

            if (empty($parentId)) {
                break;
            }

            $current = $treeModel::where(
                'userId',
                $parentId
            )->first();
        }
    }
}