<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: #f1f5f9;
        font-family: 'Poppins', sans-serif;
    }

    .tree-container {
        padding: 35px;
        overflow-x: auto;
        min-height: 100vh;
        background:
            radial-gradient(circle at top left, #dbeafe 0%, transparent 25%),
            radial-gradient(circle at bottom right, #c7d2fe 0%, transparent 25%),
            #f8fafc;
    }

    /* TOP BAR */

    .top-bar {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        margin-bottom: 35px;
    }

    .top-btn {
        border: none;
        padding: 12px 24px;
        border-radius: 14px;
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        text-decoration: none;
        display: inline-block;
    }

    .top-btn:hover {
        transform: translateY(-3px);
    }

    .home-btn {
        background: linear-gradient(135deg, #0ea5e9, #2563eb);
    }

    .reset-btn {
        background: linear-gradient(135deg, #7c3aed, #4f46e5);
    }

    .back-btn {
        background: linear-gradient(135deg, #ef4444, #dc2626);
    }

    /* ROOT HEADER */

    .root-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 40px;
        padding: 30px;
        border-radius: 28px;
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(14px);
        box-shadow:
            0 10px 30px rgba(15, 23, 42, 0.08),
            inset 0 1px 0 rgba(255, 255, 255, 0.5);
    }

    .root-badge {
        display: inline-block;
        padding: 8px 18px;
        border-radius: 30px;
        background: linear-gradient(135deg, #4f46e5, #2563eb);
        color: white;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .root-title {
        font-size: 30px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 8px;
    }

    .root-subtitle {
        font-size: 15px;
        color: #64748b;
    }

    .root-subtitle span {
        font-weight: 700;
        color: #2563eb;
    }

    /* COUNT CARD */

    .count-card {
        min-width: 260px;
        display: flex;
        align-items: center;
        gap: 18px;
        padding: 22px;
        border-radius: 24px;
        background: linear-gradient(135deg, #4f46e5, #2563eb);
        color: white;
        box-shadow:
            0 15px 35px rgba(37, 99, 235, 0.25);
    }

    .count-icon {
        width: 72px;
        height: 72px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.15);
        font-size: 34px;
    }

    .count-content h3 {
        font-size: 34px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .count-content p {
        font-size: 14px;
        margin: 0;
        opacity: 0.9;
    }

    /* ROOT CARD */

    .root-card {
        width: 260px;
        position: relative;
        background: linear-gradient(135deg, #4f46e5, #2563eb);
        color: white;
        margin: auto;
        margin-bottom: 45px;
        border-radius: 26px;
        padding: 26px;
        box-shadow:
            0 20px 45px rgba(37, 99, 235, 0.25);
    }



    .root-card .member-date {
        background: rgba(255, 255, 255, 0.15);
    }

    /* TREE */

    .genealogy-tree ul {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 25px;
        padding: 0;
    }

    .genealogy-tree li {
        list-style: none;
    }

    /* MEMBER CARD */

    .member-card {
        width: 220px;
        position: relative;
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(12px);
        border-radius: 24px;
        padding: 22px;
        border: 1px solid rgba(255, 255, 255, 0.4);
        box-shadow:
            0 10px 30px rgba(15, 23, 42, 0.08),
            inset 0 1px 0 rgba(255, 255, 255, 0.5);
        transition: 0.35s ease;
        overflow: hidden;
    }

    .member-card:hover {
        transform: translateY(-8px) scale(1.03);
        box-shadow:
            0 20px 40px rgba(37, 99, 235, 0.15);
    }

    /* AVATAR */

    .member-avatar {
        width: 90px;
        height: 90px;
        margin: auto;
        position: relative;
        margin-bottom: 16px;
    }

    .member-avatar::before {
        content: "";
        position: absolute;
        inset: -5px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4f46e5, #06b6d4);
        animation: pulse 2s infinite;
    }

    .member-avatar img {
        position: relative;
        z-index: 2;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        border: 4px solid white;
        object-fit: cover;
    }

    @keyframes pulse {
        0% {
            transform: scale(0.95);
            opacity: 0.8;
        }

        70% {
            transform: scale(1.1);
            opacity: 0;
        }

        100% {
            transform: scale(1.1);
            opacity: 0;
        }
    }

    /* DETAILS */

    .member-id {
        font-size: 17px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 8px;
        text-align: center;
    }

    .member-name {
        font-size: 14px;
        font-weight: 500;
        color: #475569;
        line-height: 1.5;
        text-align: center;
    }

    .member-date {
        margin-top: 14px;
        display: inline-block;
        padding: 8px 14px;
        border-radius: 30px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 12px;
        font-weight: 600;
        width: 100%;
        text-align: center;
    }

    a {
        text-decoration: none;
    }

    /* PAGINATION */

    .pagination-wrapper {
        margin-top: 60px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .pagination {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        padding: 18px 24px;
        border-radius: 24px;
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(14px);
        box-shadow:
            0 10px 30px rgba(15, 23, 42, 0.08),
            inset 0 1px 0 rgba(255, 255, 255, 0.5);
    }

    .pagination .page-item {
        list-style: none;
    }

    .pagination .page-link {
        border: none !important;
        min-width: 50px;
        height: 50px;
        border-radius: 16px !important;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        font-weight: 600;
        color: #334155;
        background: white;
        transition: all 0.3s ease;
        text-decoration: none;
        box-shadow:
            0 4px 10px rgba(0, 0, 0, 0.05);
    }

    .pagination .page-link:hover {
        background: linear-gradient(135deg, #4f46e5, #2563eb);
        color: white;
        transform: translateY(-4px) scale(1.05);
        box-shadow:
            0 15px 25px rgba(37, 99, 235, 0.25);
    }

    .pagination .active .page-link {
        background: linear-gradient(135deg, #4f46e5, #2563eb);
        color: white;
    }

    .pagination .disabled .page-link {
        background: #e2e8f0;
        color: #94a3b8;
        cursor: not-allowed;
        box-shadow: none;
    }

    /* MOBILE */

    @media(max-width:768px) {

        .tree-container {
            padding: 20px;
        }

        .root-header {
            padding: 24px;
        }

        .root-title {
            font-size: 24px;
        }

        .count-card {
            width: 100%;
        }

        .member-card,
        .root-card {
            width: 180px;
            padding: 18px;
        }

        .member-avatar {
            width: 70px;
            height: 70px;
        }

        .pagination {
            padding: 14px 16px;
            gap: 8px;
            border-radius: 18px;
        }

        .pagination .page-link {
            min-width: 42px;
            height: 42px;
            font-size: 13px;
            border-radius: 12px !important;
        }
    }
</style>
<style>
    .member-referral {
        margin-top: 10px;
        padding: 10px 14px;
        border-radius: 14px;
        background: linear-gradient(135deg, #f8fafc, #eef2ff);
        text-align: center;
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        border: 1px solid #dbe4ff;

        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;

        min-height: 44px;
    }

    .member-referral span {
        color: #2563eb;
        font-size: 16px;
        font-weight: 700;
        margin-top: 5px
    }


    .status-badge {
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 700;
        margin-left: 50px;
    }

    .status-active {
        background: #dcfce7;
        color: #15803d;
    }

    .status-inactive {
        background: #fee2e2;
        color: #dc2626;
    }
</style>

<div class="tree-container">

    <!-- TOP BUTTONS -->

    <div class="top-bar">

        <a href="{{ route('admin.dashboard') }}" class="top-btn home-btn">

            🏠 Home

        </a>

        <a href="{{ url('/admin/unilevel-genealogy-tree/ASK11122025') }}" class="top-btn reset-btn">

            🔄 Reset Tree

        </a>

        @php
            $upUser = $data['upline']->userid ?? null;
        @endphp

        @if ($upUser != 'ASK11122025')

            <a href="{{ url("/admin/unilevel-genealogy-tree/$upUser?uptree=y") }}" class="top-btn back-btn">

                ⬅ Back Tree

            </a>

        @endif

    </div>
    <!-- ROOT USER -->

    <div class="member-card root-card">

        <div class="member-avatar">

            <img src="{{ asset('build/img/users/user-32.jpg') }}">

        </div>

        <div class="member-id">

            {{ $data['upline']->userid ?? '' }}

        </div>

        <div class="member-name">

            {{ $data['upline']->name ?? '' }}

        </div>

        <div class="member-date">

            Joined :
            {{ Carbon\Carbon::parse($data['upline']->created_at)->format('d M Y') }}

        </div>
        <div class="member-referral">

            👥
            <span>

                {{ $data['reffCount'] }}

            </span>

        </div>

    </div>

    <!-- CHILD USERS -->

    <div class="genealogy-tree">

        <ul>

            @foreach ($data['tree'] as $tree)
                @php

                    $directCount = \App\Models\Customer::where('sponsor_id', $tree->userid)->count();

                @endphp
                <li>

                    <a href="{{ url("/admin/unilevel-genealogy-tree/$tree->userid") }}">

                        <div class="member-card">

                            <div class="member-avatar">

                                <img src="{{ asset('build/img/users/user-32.jpg') }}">

                            </div>

                            <div class="member-id">

                                {{ $tree->userid }}

                            </div>

                            <div class="member-name">

                                {{ mb_strimwidth(ucwords(strtolower($tree->name ?? '')), 0, 22, '...') }}

                            </div>

                            <div class="member-date">

                                Joined :
                                {{ Carbon\Carbon::parse($tree->created_at)->format('d M Y') }}

                            </div>
                            <div class="member-referral">

                                👥
                                <span>

                                    {{ $directCount }}

                                </span>

                            </div><br>
                            @php

                                $activeSubscription = \App\Models\CustomerSubscription::where('customer_id', $tree->id)
                                    ->where('status', 'active')
                                    ->whereDate('end_date', '>=', now())
                                    ->exists();

                            @endphp
                            <div class="member-status">

                                @if (!$activeSubscription)
                                    <div class="text-center">
                                    <span class="status-badge status-inactive">

                                        Inactive

                                    </span>
                                    </div>

                                @else

                                    <span class="status-badge status-active">

                                        Active

                                    </span>

                                @endif

                            </div>

                        </div>

                    </a>

                </li>

            @endforeach

        </ul>

    </div>

    <!-- PAGINATION -->

    <div class="pagination-wrapper">

        {{ $data['tree']->links('pagination::bootstrap-5') }}

    </div>

</div>