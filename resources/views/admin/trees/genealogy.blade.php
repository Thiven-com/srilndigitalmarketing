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
        margin-bottom: 40px;
    }

    .top-btn {
        border: none;
        padding: 12px 22px;
        border-radius: 14px;
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
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

    /* TREE */

    /* .genealogy-tree ul {
        padding-top: 35px;
        position: relative;
        display: flex;
        justify-content: center;
    } */
    .genealogy-tree ul {
        padding-top: 35px;
        position: relative;
        display: flex;
        justify-content: center;
        width: max-content;
        margin: auto;
    }

    .genealogy-tree>ul {
        display: flex;
        justify-content: center;
        width: max-content;
        margin: auto;
    }

    .genealogy-tree>ul>li {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .genealogy-tree li {
        list-style: none;
        text-align: center;
        position: relative;
        padding: 25px 18px 0 18px;
    }

    /* CONNECTORS */

    .genealogy-tree li::before,
    .genealogy-tree li::after {
        content: '';
        position: absolute;
        top: 0;
        right: 50%;
        border-top: 2px dashed #94a3b8;
        width: 50%;
        height: 25px;
    }

    .genealogy-tree li::after {
        right: auto;
        left: 50%;
        border-left: 2px dashed #94a3b8;
    }

    .genealogy-tree ul ul::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        border-left: 2px dashed #94a3b8;
        height: 35px;
    }

    .genealogy-tree li:only-child::before,
    .genealogy-tree li:only-child::after {
        display: none;
    }

    .genealogy-tree li:first-child::before {
        border: none;
    }

    .genealogy-tree li:last-child::after {
        border: none;
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

    .member-card::before {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg,
                rgba(79, 70, 229, 0.08),
                rgba(59, 130, 246, 0.08));
        opacity: 0;
        transition: 0.3s;
    }

    .member-card:hover::before {
        opacity: 1;
    }

    .member-card:hover {
        transform: translateY(-8px) scale(1.03);
        box-shadow:
            0 20px 40px rgba(37, 99, 235, 0.15);
    }

    /* ROOT CARD */

    .root-card {
        background: linear-gradient(135deg, #4f46e5, #2563eb);
        color: white;
    }

    .root-card .member-id,
    .root-card .member-name,
    .root-card .member-date {
        color: white;
    }

    .root-card .member-date {
        background: rgba(255, 255, 255, 0.15);
    }

    /* AVATAR */

    .member-avatar {
        width: 90px;
        height: 90px;
        margin: auto;
        position: relative;
        margin-bottom: 15px;
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
        font-size: 16px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 8px;
    }

    .member-name {
        font-size: 14px;
        font-weight: 500;
        color: #475569;
        line-height: 1.5;
    }

    .member-date {
        margin-top: 12px;
        display: inline-block;
        padding: 7px 14px;
        border-radius: 30px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 12px;
        font-weight: 600;
    }

    a {
        text-decoration: none;
    }

    /* MOBILE */

    @media(max-width:768px) {

        .tree-container {
            padding: 20px;
        }

        .member-card {
            width: 180px;
            padding: 18px;
        }

        .member-avatar {
            width: 70px;
            height: 70px;
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

</style>

<div class="tree-container">

    <!-- TOP BUTTONS -->

    <div class="top-bar">

        <a href="{{ route('admin.dashboard') }}">
            <button class="top-btn home-btn">
                🏠 Home
            </button>
        </a>

        <a href="{{ url('/admin/genealogy-tree/ASK11122025') }}">
            <button class="top-btn reset-btn">
                🔄 Reset Tree
            </button>
        </a>

        @php
            $upUser = $data['userId'] ?? null;
        @endphp

        @if ($upUser)

            <a href="{{ url("/admin/genealogy-tree/$upUser?uptree=y") }}">
                <button class="top-btn back-btn">
                    ⬅ Back Tree
                </button>
            </a>

        @else

            <button class="top-btn back-btn">
                ⬅ Back Tree
            </button>

        @endif

    </div>



        <div class="tree-section">

            <div class="genealogy-tree">

                <ul>

                    <li>

                        <!-- ROOT USER -->

                        <div class="member-card root-card">

                            <div class="member-avatar">

                                <img src="{{ asset('build/img/users/user-32.jpg') }}">

                            </div>

                            @if (isset($data['upline']->userid) && $data['upline']->userid == "ASK11122025")

                                <div class="member-id">
                                    {{ $data['upline']->userid ?? '' }}
                                </div>

                                <div class="member-name">
                                    {{ $data['upline']->name ?? '' }}
                                </div>

                            @else

                                <div class="member-id">
                                    {{ $data['upline']->userId ?? '' }}
                                </div>

                                <div class="member-name">
                                    {{ $data['upline']->reff_name->name ?? ' ' }}
                                </div>

                            @endif
                            <div class="member-referral">

                                👥 :
                                <span>

                                    {{ count($data['tree']) }}/5

                                </span>

                            </div>

                        </div>

                        <!-- CHILD USERS -->

                        <ul>

                            @foreach ($data['tree'] as $index => $tree)
                                @php
                                    $count = \App\Models\CustomerReferral::where('placedunder_id', $tree->userId)->count();
                                @endphp
                                <li>

                                    <a href="{{ url("/admin/genealogy-tree/$tree->userId") }}">

                                        <div class="member-card">

                                            <div class="member-avatar">

                                                <img src="{{ asset('build/img/users/user-32.jpg') }}">

                                            </div>

                                            <div class="member-id">

                                                {{ $tree->userId }}

                                            </div>

                                            <div class="member-name">

                                                {{ mb_strimwidth(ucwords(strtolower($tree->reff_name->name ?? '')), 0, 22, '...') }}

                                            </div>

                                            @if(isset($tree->edate))

                                                <div class="member-date">

                                                    {{ Carbon\Carbon::parse($tree->edate)->format('d M Y') }}

                                                </div>

                                            @endif
                                            <div class="member-referral">

                                                👥 :
                                                <span>

                                                    {{ $count }}/5

                                                </span>

                                            </div>


                                        </div>

                                    </a>

                                </li>

                            @endforeach

                        </ul>

                    </li>

                </ul>

            </div>
        </div>

</div>