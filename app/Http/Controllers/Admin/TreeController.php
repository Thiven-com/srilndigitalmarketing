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
     * Display all 4 trees.
     */
    public function index(Request $request)
    {
        $treeType = $request->get('tree', 'three');

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

            $rootNode = $treeModel::where(
                'userId',
                $selectedUserId
            )->first();

        } else {

            /*
            |--------------------------------------------------------------------------
            | Default Root
            |--------------------------------------------------------------------------
            */

            $rootNode = $treeModel::orderBy(
                'id',
                'asc'
            )->first();
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
                $rootNode->userId
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
        int $level = 0,
        int $maxLevel = 6
    ): ?array {

        if ($level >= $maxLevel) {
            return null;
        }

        $node = $treeModel::where(
            'userId',
            $userId
        )->first();

        if (!$node) {
            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | Get Children
        |--------------------------------------------------------------------------
        */

        $children = $treeModel::where(
            'placedunder_id',
            $node->userId
        )
            ->orderBy('id')
            ->get();

        $childNodes = [];

        foreach ($children as $child) {

            $childNode = $this->buildTree(
                $treeModel,
                $child->userId,
                $level + 1,
                $maxLevel
            );

            if ($childNode) {
                $childNodes[] = $childNode;
            }
        }

        return [

            'id' => $node->id,

            'customer_id' =>
                $node->customer_id,
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