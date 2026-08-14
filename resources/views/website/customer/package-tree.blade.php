@extends('layouts.website')

@section('content')

<style>

    .package-tree-page {
        padding: 40px 0 60px;
    }

    .package-header {
        background: #ffffff;
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.06);
    }

    .package-title {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .package-subtitle {
        color: #777;
        font-size: 14px;
    }

    .package-info {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 20px;
    }

    .info-box {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 12px 18px;
        min-width: 150px;
    }

    .info-label {
        display: block;
        color: #777;
        font-size: 12px;
        margin-bottom: 3px;
    }

    .info-value {
        font-weight: 600;
        font-size: 15px;
    }


    /* Tree */

    .tree-container {
        background: #ffffff;
        border-radius: 20px;
        padding: 35px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.06);

        overflow-x: auto;
    }

    .tree {
        min-width: max-content;
        text-align: center;
    }


    .tree-node {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
    }


    .tree-user {
        background: #ffffff;
        border: 2px solid #198754;
        border-radius: 16px;
        padding: 15px 20px;
        min-width: 190px;
        box-shadow: 0 5px 18px rgba(0, 0, 0, 0.08);
        position: relative;
        z-index: 2;
    }


    .user-id {
        font-size: 17px;
        font-weight: 700;
        color: #198754;
        margin-bottom: 8px;
    }


    .placed-under {
        font-size: 12px;
        color: #666;
        margin-top: 4px;
    }


    .tree-children {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        gap: 25px;
        margin-top: 45px;
        position: relative;
    }


    .tree-children::before {
        content: "";
        position: absolute;
        top: -25px;
        left: 50%;
        width: 2px;
        height: 25px;
        background: #ced4da;
    }


    .tree-children > .tree-node {
        position: relative;
    }


    .tree-children > .tree-node::before {
        content: "";
        position: absolute;
        top: -25px;
        left: 50%;
        width: 2px;
        height: 25px;
        background: #ced4da;
    }


    .tree-empty {
        text-align: center;
        padding: 50px;
        color: #777;
    }


    .back-button {
        margin-top: 20px;
    }


    @media (max-width: 768px) {

        .package-tree-page {
            padding: 25px 0 40px;
        }

        .tree-container {
            padding: 20px;
        }

        .tree-user {
            min-width: 160px;
            padding: 12px;
        }

        .user-id {
            font-size: 14px;
        }

        .tree-children {
            gap: 15px;
        }

    }

</style>


<div class="container package-tree-page">


    {{-- Success --}}
    @if(session('success'))

        <div class="alert alert-success rounded-3">
            {{ session('success') }}
        </div>

    @endif


    {{-- Error --}}
    @if(session('error'))

        <div class="alert alert-danger rounded-3">
            {{ session('error') }}
        </div>

    @endif


    {{-- Package Header --}}

    <div class="package-header">

        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">

            <div>

                <div class="package-title">

                    {{ $customerPackage->package->name ?? 'Package' }}

                </div>

                <div class="package-subtitle">

                    Package Tree Structure

                </div>

            </div>


            <div>

                @if($customerPackage->payment_status === 'approved')

                    <span class="badge bg-success rounded-pill px-3 py-2">

                        Approved

                    </span>

                @endif

            </div>

        </div>


        {{-- Package Information --}}

        <div class="package-info">


            <div class="info-box">

                <span class="info-label">
                    Order Number
                </span>

                <span class="info-value">

                    {{ $customerPackage->order_number }}

                </span>

            </div>


            <div class="info-box">

                <span class="info-label">
                    Package
                </span>

                <span class="info-value">

                    {{ $customerPackage->package->name ?? '-' }}

                </span>

            </div>


            <div class="info-box">

                <span class="info-label">
                    Tree Type
                </span>

                <span class="info-value">

                    {{ ucfirst(str_replace('_', ' ', $treeType)) }}

                </span>

            </div>


            <div class="info-box">

                <span class="info-label">
                    Amount
                </span>

                <span class="info-value">

                    ₹{{ number_format($customerPackage->total_amount, 2) }}

                </span>

            </div>


            <div class="info-box">

                <span class="info-label">
                    Your User ID
                </span>

                <span class="info-value">

                    {{ $treeNode->userId }}

                </span>

            </div>


            <div class="info-box">

                <span class="info-label">
                    Children
                </span>

                <span class="info-value">

                    {{ $treeNode->placedunderid_cnt ?? 0 }}

                </span>

            </div>

        </div>


        <div class="back-button">

            <a
                href="{{ route('customer.packages') }}"
                class="btn btn-outline-secondary rounded-pill px-4"
            >
                <i class="bi bi-arrow-left me-1"></i>
                Back to My Packages
            </a>

        </div>

    </div>


    {{-- Tree --}}

    <div class="tree-container">

        <h5 class="fw-bold mb-4">

            {{ ucfirst(str_replace('_', ' ', $treeType)) }} Tree

        </h5>


        @if($tree)

            <div class="tree">

                @include(
                    'website.customer.partials.tree-node',
                    [
                        'node' => $tree
                    ]
                )

            </div>

        @else

            <div class="tree-empty">

                <i class="bi bi-diagram-3 fs-1 text-muted"></i>

                <h5 class="mt-3">
                    No Tree Data Found
                </h5>

                <p class="text-muted mb-0">
                    Your package tree has not been created yet.
                </p>

            </div>

        @endif

    </div>


</div>

@endsection