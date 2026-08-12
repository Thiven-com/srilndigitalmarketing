@extends('layouts.website')

@section('title', 'My Referrals')

@section('content')

<div class="customer-referrals-page">

    <div class="container">

        {{-- PAGE HEADER --}}
        <div class="customer-page-header">

            <div>
                <span class="page-label">MY NETWORK</span>

                <h1>My Referrals</h1>

                <p>
                    View your referral network and referral activity.
                </p>
            </div>

            <a
                href="{{ route('customer.dashboard') }}"
                class="back-dashboard-btn"
            >
                <i class="bi bi-arrow-left"></i>
                Dashboard
            </a>

        </div>


        {{-- REFERRAL SUMMARY --}}
        <div class="referral-stat-grid">

            <div class="referral-stat-card">

                <span>Total Referrals</span>

                <strong>
                    {{ $totalReferrals ?? 0 }}
                </strong>

            </div>


            <div class="referral-stat-card">

                <span>Direct Referrals</span>

                <strong>
                    {{ $directReferrals ?? 0 }}
                </strong>

            </div>


            <div class="referral-stat-card">

                <span>Total Income</span>

                <strong>
                    ₹{{ number_format($totalIncome ?? 0, 2) }}
                </strong>

            </div>

        </div>


        {{-- REFERRAL LINK --}}
        <div class="customer-content-card">

            <div class="customer-content-card-header">

                <h3>
                    Your Referral Link
                </h3>

                <span class="page-label">
                    INVITE & EARN
                </span>

            </div>


            <div class="referral-link-box">

                <input
                    type="text"
                    id="referralLink"
                    readonly
                    value="{{ url('/register?ref=' . ($customer->id ?? '')) }}"
                >

                <button
                    type="button"
                    class="referral-copy-btn"
                    onclick="copyReferralLink()"
                >
                    <i class="bi bi-copy"></i>
                    Copy Link
                </button>

            </div>

        </div>


        {{-- REFERRAL TABLE --}}
        <div
            class="customer-content-card"
            style="margin-top:22px;"
        >

            <div class="customer-content-card-header">

                <h3>
                    Referral Members
                </h3>

                <span class="page-label">
                    MY NETWORK
                </span>

            </div>


            @if(isset($referrals) && $referrals->count())

                <div class="customer-table-wrapper">

                    <table class="customer-table">

                        <thead>

                            <tr>

                                <th>#</th>

                                <th>Member</th>

                                <th>Mobile</th>

                                <th>Level</th>

                                <th>Points</th>

                                <th>Income</th>

                                <th>Date</th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($referrals as $referral)

                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>

                                        <strong>
                                            {{ $referral->customer->name ?? $referral->name ?? 'Member' }}
                                        </strong>

                                    </td>

                                    <td>
                                        {{ $referral->customer->mobile ?? $referral->mobile ?? '-' }}
                                    </td>

                                    <td>

                                        <span class="customer-status active">

                                            Level
                                            {{ $referral->level ?? 1 }}

                                        </span>

                                    </td>

                                    <td>
                                        {{ $referral->points ?? 0 }}
                                    </td>

                                    <td>

                                        <strong class="verified">

                                            ₹{{ number_format($referral->total_income ?? 0, 2) }}

                                        </strong>

                                    </td>

                                    <td>
                                        {{ optional($referral->created_at)->format('d M Y') }}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="packages-empty">

                    <div class="empty-icon">

                        <i class="bi bi-people"></i>

                    </div>

                    <h3>
                        No Referrals Yet
                    </h3>

                    <p>
                        You don't have any referral members yet.
                        Share your referral link to start building your network.
                    </p>

                    <button
                        type="button"
                        class="customer-primary-btn"
                        onclick="copyReferralLink()"
                    >
                        <i class="bi bi-share"></i>
                        Copy Referral Link
                    </button>

                </div>

            @endif

        </div>

    </div>

</div>


<script>

function copyReferralLink()
{
    const input = document.getElementById('referralLink');

    if (!input) {
        return;
    }

    navigator.clipboard.writeText(input.value)
        .then(function () {

            const buttons = document.querySelectorAll('.referral-copy-btn');

            buttons.forEach(function (button) {

                const original = button.innerHTML;

                button.innerHTML =
                    '<i class="bi bi-check"></i> Copied';

                setTimeout(function () {
                    button.innerHTML = original;
                }, 2000);

            });

        })
        .catch(function () {

            input.select();
            document.execCommand('copy');

        });
}

</script>

@endsection