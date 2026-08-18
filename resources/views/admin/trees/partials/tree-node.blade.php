<style>
    .tree-node {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* ================= USER CARD ================= */

    .tree-user-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .tree-user {
        width: 190px;
        min-height: 155px;
        background: #fff;
        border: 1px solid #e9edf5;
        border-radius: 18px;
        padding: 18px 14px 14px;
        text-align: center;
        position: relative;
        box-shadow: 0 8px 25px rgba(31, 41, 55, 0.08);
        transition: all .25s ease;
    }

    .tree-user:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 35px rgba(79, 70, 229, 0.15);
        border-color: #c7d2fe;
    }

    /* ================= USER ICON ================= */

    .tree-user-avatar {
        width: 58px;
        height: 58px;
        border-radius: 50%;
        margin: -2px auto 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(
            135deg,
            #4f46e5,
            #7c3aed
        );
        color: #fff;
        font-size: 27px;
        box-shadow: 0 7px 18px rgba(79, 70, 229, .25);
        border: 4px solid #fff;
    }

    .tree-user-avatar i {
        line-height: 1;
    }

    /* ================= USER ID ================= */

    .tree-user .user-id {
        font-size: 14px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 4px;
        word-break: break-word;
    }

    /* ================= CUSTOMER NAME ================= */

    .tree-user .customer-id {
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 8px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* ================= PACKAGE ================= */

    .tree-package {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #eef2ff;
        color: #4f46e5;
        border-radius: 20px;
        padding: 4px 10px;
        font-size: 10px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    /* ================= PLACED UNDER ================= */

    .tree-user .position {
        font-size: 10px;
        color: #94a3b8;
        border-top: 1px solid #f1f5f9;
        padding-top: 8px;
        margin-top: 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .tree-user .position strong {
        color: #64748b;
    }

    /* ================= ROOT BADGE ================= */

    .root-badge {
        position: absolute;
        top: -9px;
        right: -7px;
        background: linear-gradient(
            135deg,
            #f59e0b,
            #d97706
        );
        color: #fff;
        font-size: 9px;
        font-weight: 800;
        padding: 4px 9px;
        border-radius: 20px;
        box-shadow: 0 4px 10px rgba(245, 158, 11, .25);
        text-transform: uppercase;
    }

    /* ================= CHILDREN ================= */

    .tree-children {
        display: flex;
        justify-content: center;
        gap: 35px;
        margin-top: 45px;
        position: relative;
    }

    /* ================= CONNECTOR ================= */

    .tree-children::before {
        content: '';
        position: absolute;
        top: -25px;
        left: 50%;
        width: 2px;
        height: 25px;
        background: #cbd5e1;
    }

    .tree-children > .tree-node {
        position: relative;
    }

    .tree-children > .tree-node::before {
        content: '';
        position: absolute;
        top: -25px;
        left: 50%;
        width: 2px;
        height: 25px;
        background: #cbd5e1;
    }

    /* Horizontal connector */

    .tree-children > .tree-node:not(:first-child)::after,
    .tree-children > .tree-node:not(:last-child)::after {
        content: '';
        position: absolute;
        top: -25px;
        height: 2px;
        background: #cbd5e1;
    }

    .tree-children > .tree-node:not(:first-child)::after {
        left: -35px;
        width: 35px;
    }

    .tree-children > .tree-node:not(:last-child)::after {
        right: -35px;
        width: 35px;
    }


    /* ================= MOBILE ================= */

    @media(max-width: 768px) {

        .tree-user {
            width: 155px;
            min-height: 145px;
            padding: 15px 10px 12px;
        }

        .tree-user-avatar {
            width: 50px;
            height: 50px;
            font-size: 23px;
        }

        .tree-user .user-id {
            font-size: 12px;
        }

        .tree-user .customer-id {
            font-size: 11px;
        }

        .tree-children {
            gap: 18px;
        }

        .tree-children > .tree-node:not(:first-child)::after {
            left: -18px;
            width: 18px;
        }

        .tree-children > .tree-node:not(:last-child)::after {
            right: -18px;
            width: 18px;
        }
    }

</style>


<div class="tree-node">

    <a
        href="{{ route('admin.trees.index', [
            'tree' => $treeType,
            'user' => $node['userId'],
            'package_id' => $packageId
        ]) }}"
        class="tree-user-link"
    >

        <div class="tree-user">

            {{-- ROOT BADGE --}}
            @if(empty($node['placedunder_id']))

                <span class="root-badge">
                    Root
                </span>

            @endif


            {{-- USER ICON --}}
            <div class="tree-user-avatar">

                <i class="ti ti-user"></i>

            </div>


            {{-- USER ID --}}
            <div class="user-id">

                {{ $node['userId'] ?? '-' }}

            </div>


            {{-- CUSTOMER NAME --}}
            <div class="customer-id">

                {{ $node['customer_name'] ?? 'Customer' }}

            </div>


            {{-- PACKAGE --}}
            @if(!empty($node['package_id']))

                <div class="tree-package">

                    <i class="ti ti-package"></i>

                    Package {{ $node['package_id'] }}

                </div>

            @endif


            {{-- PLACED UNDER --}}
            @if(!empty($node['placedunder_id']))

                <div class="position">

                    <i class="ti ti-arrow-down me-1"></i>

                    Placed Under:
                    <strong>
                        {{ $node['placedunder_id'] }}
                    </strong>

                </div>

            @endif

        </div>

    </a>


    {{-- ================= CHILDREN ================= --}}

    @if(!empty($node['children']))

        <div class="tree-children">

            @foreach($node['children'] as $child)

                @if($child)

                    @include(
                        'admin.trees.partials.tree-node',
                        [
                            'node' => $child,
                            'treeType' => $treeType,
                            'packageId' => $packageId
                        ]
                    )

                @endif

            @endforeach

        </div>

    @endif

</div>