<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ThreeWayReferral;
use App\Models\ThreeWayDirectReferral;
use App\Models\FiveWayReferral;
use App\Models\FiveWayDirectReferral;
use Illuminate\Http\Request;

class TreeController extends Controller
{
    /**
     * Display selected tree.
     */
    public function index(Request $request)
    {
        $treeType = $request->get('tree', 'three');

        $packageId = $request->get('package_id');

        $selectedUserId = $request->get('user');

        /*
        |--------------------------------------------------------------------------
        | Tree Model
        |--------------------------------------------------------------------------
        */

        $treeModel = match ($treeType) {

            'three' =>
                ThreeWayReferral::class,

            'three_direct' =>
                ThreeWayDirectReferral::class,

            'five' =>
                FiveWayReferral::class,

            'five_direct' =>
                FiveWayDirectReferral::class,

            default =>
                ThreeWayReferral::class,
        };

        /*
        |--------------------------------------------------------------------------
        | Title
        |--------------------------------------------------------------------------
        */

        $title = match ($treeType) {

            'three' =>
                'Three Way Tree',

            'three_direct' =>
                'Three Way Direct Tree',

            'five' =>
                'Five Way Tree',

            'five_direct' =>
                'Five Way Direct Tree',

            default =>
                'Three Way Tree',
        };

        /*
        |--------------------------------------------------------------------------
        | Find Starting User
        |--------------------------------------------------------------------------
        */

        if ($selectedUserId) {

            $query = $treeModel::where(
                'userId',
                $selectedUserId
            );

            if ($packageId) {
                $query->where(
                    'package_id',
                    $packageId
                );
            }

            $rootNode = $query->first();

        } else {

            /*
            |--------------------------------------------------------------------------
            | Default Root
            |--------------------------------------------------------------------------
            */

            $query = $treeModel::orderBy(
                'id',
                'asc'
            );

            if ($packageId) {
                $query->where(
                    'package_id',
                    $packageId
                );
            }

            $rootNode = $query->first();
        }

        /*
        |--------------------------------------------------------------------------
        | Build Tree
        |--------------------------------------------------------------------------
        */

        $trees = [];

        if ($rootNode) {

            $tree = $this->buildTree(
                $treeModel,
                $rootNode->userId,
                $packageId
            );

            if ($tree) {
                $trees[] = $tree;
            }
        }

        return view(
            'admin.trees.index',
            compact(
                'trees',
                'treeType',
                'title',
                'packageId',
                'selectedUserId'
            )
        );
    }

    /**
     * Build tree recursively.
     */
    protected function buildTree(
        string $treeModel,
        string $userId,
        string $packageId,
        int $level = 0,
        int $maxLevel = 6
    ): ?array {

        /*
        |--------------------------------------------------------------------------
        | Maximum Level
        |--------------------------------------------------------------------------
        */

        if ($level >= $maxLevel) {
            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | Find Current Node
        |--------------------------------------------------------------------------
        */

        $query = $treeModel::where(
            'userId',
            $userId
        );

        if ($packageId) {
            $query->where(
                'package_id',
                $packageId
            );
        }

        $node = $query->first();

        if (!$node) {
            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | Get Children
        |--------------------------------------------------------------------------
        */

        $childrenQuery = $treeModel::where(
            'placedunder_id',
            $node->userId
        );

        if ($packageId) {
            $childrenQuery->where(
                'package_id',
                $packageId
            );
        }

        $children = $childrenQuery
            ->orderBy('id')
            ->get();

        $childNodes = [];

        foreach ($children as $child) {

            $childNode = $this->buildTree(
                $treeModel,
                $child->userId,
                $packageId,
                $level + 1,
                $maxLevel
            );

            if ($childNode) {
                $childNodes[] = $childNode;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Return Node
        |--------------------------------------------------------------------------
        */

        return [

            'id' =>
                $node->id,

            'customer_id' =>
                $node->customer_id,

            'package_id' =>
                $node->package_id,

            'customer_name' =>
                $node->customer->name ?? '',

            'userId' =>
                $node->userId,

            'sponser_id' =>
                $node->sponser_id,

            'placedunder_id' =>
                $node->placedunder_id,

            'position' =>
                $node->position ?? null,

            'rootmap' =>
                $node->rootmap,

            'left_points' =>
                $node->left_points,

            'right_points' =>
                $node->right_points,

            'points' =>
                $node->points,

            'g_count' =>
                $node->g_count,

            'placedunderid_cnt' =>
                $node->placedunderid_cnt,

            'children' =>
                $childNodes,
        ];
    }
}