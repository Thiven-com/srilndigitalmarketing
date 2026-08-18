@extends('layout.mainlayout')

@section('title', 'Package Trees')

@section('content')

    <div class="page-wrapper">

        <div class="content">

            {{-- Page Header --}}
            <div class="page-header d-flex justify-content-between align-items-center">

                <div class="page-title">

                    <h4>{{ $title }}</h4>

                    <h6>Manage customer package placement trees</h6>

                </div>

            </div>


            {{-- Tree Type Tabs --}}
            <div class="card">

                <div class="card-body">

                    <div class="row g-3">

                        {{-- Three Way --}}
                        <div class="col-xl-3 col-md-6">

                            <a href="{{ route('admin.trees.index', ['tree' => 'three', 'package_id' => '1']) }}" class="text-decoration-none">

                                <div class="tree-tab-card
                                    {{ $packageId === '1' ? 'active-three' : '' }}">

                                    <div class="tree-icon three-icon">
                                        <i data-feather="git-branch"></i>
                                    </div>

                                    <div>
                                        <h6 class="mb-1">
                                            Three Way Tree
                                        </h6>

                                        <span>
                                            3 Member Placement
                                        </span>
                                    </div>

                                </div>

                            </a>

                        </div>


                        {{-- Three Way Direct --}}
                        <div class="col-xl-3 col-md-6">

                            <a href="{{ route('admin.trees.index', ['tree' => 'three', 'package_id' => '2']) }}"
                                class="text-decoration-none">

                                <div class="tree-tab-card
                                    {{  $packageId === '2' ? 'active-three' : '' }}">

                                    <div class="tree-icon three-icon">
                                        <i data-feather="users"></i>
                                    </div>

                                    <div>
                                        <h6 class="mb-1">
                                            Three Way Direct
                                        </h6>

                                        <span>
                                            3 Direct Placement
                                        </span>
                                    </div>

                                </div>

                            </a>

                        </div>


                        {{-- Five Way --}}
                        <div class="col-xl-3 col-md-6">

                            <a href="{{ route('admin.trees.index', ['tree' => 'three', 'package_id' => '3']) }}" class="text-decoration-none">

                                <div class="tree-tab-card
                                    {{  $packageId === '3' ? 'active-three' : '' }}">

                                    <div class="tree-icon five-icon">
                                        <i data-feather="git-merge"></i>
                                    </div>

                                    <div>
                                        <h6 class="mb-1">
                                            Five Way Tree
                                        </h6>

                                        <span>
                                            5 Member Placement
                                        </span>
                                    </div>

                                </div>

                            </a>

                        </div>


                        {{-- Five Way Direct --}}
                        {{-- <div class="col-xl-3 col-md-6">

                            <a href="{{ route('admin.trees.index', ['tree' => 'five_direct']) }}"
                                class="text-decoration-none">

                                <div class="tree-tab-card
                                    {{ $treeType === 'five_direct' ? 'active-five' : '' }}">

                                    <div class="tree-icon five-icon">
                                        <i data-feather="share-2"></i>
                                    </div>

                                    <div>
                                        <h6 class="mb-1">
                                            Five Way Direct
                                        </h6>

                                        <span>
                                            5 Direct Placement
                                        </span>
                                    </div>

                                </div>

                            </a>

                        </div> --}}

                    </div>

                </div>

            </div>


            {{-- Tree --}}
            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center">

                    <div>

                        <h5 class="mb-1">
                            {{ $title }}
                        </h5>

                        <span class="text-muted">
                            Customer placement structure
                        </span>

                    </div>

                    <span class="badge
                        {{ in_array($treeType, ['three', 'three_direct'])
        ? 'bg-primary'
        : 'bg-success' }}">

                        {{ ucwords(str_replace('_', ' ', $treeType)) }}

                    </span>

                </div>


                <div class="card-body">

                    @if(!empty($trees) && count($trees) > 0)

                        <div class="tree-wrapper">

                            @foreach($trees as $tree)

                                @if(!empty($tree))

                                    @include(
                                        'admin.trees.partials.tree-node',
                                        [
                                            'node' => $tree
                                        ]
                                    )

                                @endif

                            @endforeach

                        </div>

                    @else

                        <div class="text-center py-5">

                            <div class="empty-tree-icon mb-3">

                                <i data-feather="git-branch"></i>

                            </div>

                            <h5>
                                No tree members found
                            </h5>

                            <p class="text-muted mb-0">
                                Customers will appear here after package activation.
                            </p>

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>


    <style>
        /*
        |--------------------------------------------------------------------------
        | Tree Type Cards
        |--------------------------------------------------------------------------
        */

        .tree-tab-card {

            display: flex;
            align-items: center;
            gap: 15px;

            padding: 18px;

            border: 1px solid #e5e7eb;

            border-radius: 10px;

            background: #fff;

            transition: all .2s ease;

            height: 100%;
        }


        .tree-tab-card:hover {

            transform: translateY(-2px);

            box-shadow: 0 5px 18px rgba(0, 0, 0, .08);

        }


        .tree-tab-card h6 {

            color: #212529;

            font-weight: 600;

            margin: 0;

        }


        .tree-tab-card span {

            color: #6c757d;

            font-size: 12px;

        }


        .tree-icon {

            width: 48px;

            height: 48px;

            min-width: 48px;

            border-radius: 10px;

            display: flex;

            align-items: center;

            justify-content: center;

        }


        .tree-icon svg {

            width: 23px;

            height: 23px;

        }


        .three-icon {

            background: #eaf2ff;

            color: #3577f1;

        }


        .five-icon {

            background: #e9f8ef;

            color: #28a745;

        }


        .active-three {

            border-color: #3577f1;

            background: #f7faff;

            box-shadow: 0 0 0 1px #3577f1;

        }


        .active-five {

            border-color: #28a745;

            background: #f7fff9;

            box-shadow: 0 0 0 1px #28a745;

        }


        /*
        |--------------------------------------------------------------------------
        | Tree Wrapper
        |--------------------------------------------------------------------------
        */

        .tree-wrapper {

            width: 100%;

            overflow-x: auto;

            overflow-y: hidden;

            padding: 50px 30px;

            min-height: 500px;

        }


        /*
        |--------------------------------------------------------------------------
        | Tree Node
        |--------------------------------------------------------------------------
        */

        .tree-node {

            position: relative;

            text-align: center;

            min-width: 170px;

        }


        .tree-user {

            display: inline-block;

            min-width: 170px;

            background: #fff;

            border: 1px solid #e6e6e6;

            border-radius: 10px;

            padding: 14px 16px;

            box-shadow: 0 3px 12px rgba(0, 0, 0, .07);

            position: relative;

            z-index: 2;

        }


        .tree-user .user-id {

            font-size: 14px;

            font-weight: 700;

            color: #212529;

        }


        .tree-user .customer-id {

            font-size: 12px;

            color: #6c757d;

            margin-top: 5px;

        }


        .tree-user .position {

            font-size: 11px;

            color: #3577f1;

            margin-top: 5px;

        }


        .tree-user .children-count {

            font-size: 11px;

            color: #6c757d;

            margin-top: 4px;

        }


        /*
        |--------------------------------------------------------------------------
        | Children
        |--------------------------------------------------------------------------
        */

        .tree-children {

            display: flex;

            justify-content: center;

            gap: 45px;

            margin-top: 50px;

            position: relative;

        }


        /*
        |--------------------------------------------------------------------------
        | Vertical Line
        |--------------------------------------------------------------------------
        */

        .tree-children>.tree-node::before {

            content: '';

            position: absolute;

            top: -30px;

            left: 50%;

            width: 1px;

            height: 30px;

            background: #cfd4da;

        }


        /*
        |--------------------------------------------------------------------------
        | Horizontal Line
        |--------------------------------------------------------------------------
        */

        .tree-children::before {

            content: '';

            position: absolute;

            top: -30px;

            left: 10%;

            right: 10%;

            height: 1px;

            background: #cfd4da;

        }


        /*
        |--------------------------------------------------------------------------
        | Empty
        |--------------------------------------------------------------------------
        */

        .empty-tree-icon {

            width: 70px;

            height: 70px;

            border-radius: 50%;

            background: #f5f6f8;

            color: #6c757d;

            display: inline-flex;

            align-items: center;

            justify-content: center;

        }


        .empty-tree-icon svg {

            width: 30px;

            height: 30px;

        }


        /*
        |--------------------------------------------------------------------------
        | Mobile
        |--------------------------------------------------------------------------
        */

        @media(max-width: 767px) {

            .tree-wrapper {

                padding: 30px 15px;

            }

            .tree-children {

                gap: 25px;

            }

            .tree-user {

                min-width: 145px;

            }

        }
    </style>


    @push('scripts')

        <script>

            document.addEventListener('DOMContentLoaded', function () {

                if (typeof feather !== 'undefined') {
                    feather.replace();
                }

            });

        </script>

    @endpush

@endsection