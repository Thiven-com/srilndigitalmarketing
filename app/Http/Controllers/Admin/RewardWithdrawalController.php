<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\Customer;
use App\Models\Reward;
use App\Models\RewardWithdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RewardWithdrawalController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    |
    | Show all reward withdrawal requests.
    |
    */

    public function index(Request $request)
    {
        $query = RewardWithdrawal::with('customer')
            ->latest('id');


        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->whereHas(
                'customer',
                function ($q) use ($search) {

                    $q->where(
                        'name',
                        'like',
                        "%{$search}%"
                    )
                        ->orWhere(
                            'userid',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'mobile',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'email',
                            'like',
                            "%{$search}%"
                        );
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $withdrawals = $query
            ->paginate(20)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $pendingCount = RewardWithdrawal::where(
            'status',
            'pending'
        )->count();

        $approvedCount = RewardWithdrawal::where(
            'status',
            'approved'
        )->count();

        $settledCount = RewardWithdrawal::where(
            'status',
            'settled'
        )->count();

        $rejectedCount = RewardWithdrawal::where(
            'status',
            'rejected'
        )->count();


        return view(
            'admin.reward_withdrawals.index',
            compact(
                'withdrawals',
                'pendingCount',
                'approvedCount',
                'settledCount',
                'rejectedCount'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    |
    | Show complete withdrawal details.
    |
    */

    public function show($id)
    {
        $withdrawal = RewardWithdrawal::with(
            'customer'
        )->findOrFail($id);


        $customer = $withdrawal->customer;
        $bankAccount = BankAccount::where(
            'user_id',
            $customer->id
        )->first();

        return view(
            'admin.reward_withdrawals.show',
            compact(
                'withdrawal',
                'customer',
                'bankAccount'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | APPROVE
    |--------------------------------------------------------------------------
    |
    | Approval:
    |
    | 1. Lock withdrawal
    | 2. Lock customer
    | 3. Check status
    | 4. Check reward balance
    | 5. Deduct requested amount
    | 6. Save opening/closing balance
    | 7. Create reward debit history
    | 8. Mark withdrawal approved
    |
    */

    public function approve($id)
    {
        return DB::transaction(
            function () use ($id) {

                /*
                |--------------------------------------------------------------------------
                | Lock Withdrawal
                |--------------------------------------------------------------------------
                */

                $withdrawal =
                    RewardWithdrawal::lockForUpdate()
                        ->findOrFail($id);


                /*
                |--------------------------------------------------------------------------
                | Only Pending Can Be Approved
                |--------------------------------------------------------------------------
                */

                if (
                    $withdrawal->status !==
                    'pending'
                ) {

                    return back()->with(
                        'warning',
                        'This withdrawal request has already been processed.'
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | Lock Customer
                |--------------------------------------------------------------------------
                */

                $customer =
                    Customer::lockForUpdate()
                        ->findOrFail(
                            $withdrawal->customer_id
                        );


                /*
                |--------------------------------------------------------------------------
                | Current Reward Balance
                |--------------------------------------------------------------------------
                */

                $openingBalance =
                    round(
                        (float) (
                            $customer->rewards ?? 0
                        ),
                        2
                    );


                /*
                |--------------------------------------------------------------------------
                | Requested Amount
                |--------------------------------------------------------------------------
                */

                $requestedAmount =
                    round(
                        (float) 
                        $withdrawal->requested_amount,
                        2
                    );


                /*
                |--------------------------------------------------------------------------
                | Check Balance
                |--------------------------------------------------------------------------
                */

                if (
                    $openingBalance <
                    $requestedAmount
                ) {

                    $withdrawal->status =
                        'rejected';

                    $withdrawal->admin_remark =
                        'Insufficient reward balance at the time of approval.';

                    $withdrawal->save();


                    return back()->with(
                        'error',
                        'Withdrawal rejected because the customer has insufficient reward balance.'
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | Closing Balance
                |--------------------------------------------------------------------------
                */

                $closingBalance =
                    round(
                        $openingBalance -
                        $requestedAmount,
                        2
                    );


                /*
                |--------------------------------------------------------------------------
                | Debit Customer Rewards
                |--------------------------------------------------------------------------
                */

                $customer->rewards =
                    $closingBalance;

                $customer->save();


                /*
                |--------------------------------------------------------------------------
                | Update Withdrawal
                |--------------------------------------------------------------------------
                */

                $withdrawal->opening_rewards =
                    $openingBalance;

                $withdrawal->closing_rewards =
                    $closingBalance;

                $withdrawal->status =
                    'approved';

                $withdrawal->admin_remark =
                    null;

                $withdrawal->save();


                /*
                |--------------------------------------------------------------------------
                | Create Reward History
                |--------------------------------------------------------------------------
                */

                Reward::create([

                    'user_id' =>
                        $customer->id,

                    'role' =>
                        'customer',

                    'activity_id' =>
                        null,

                    'source_type' =>
                        'reward_withdrawal',

                    'source_id' =>
                        $withdrawal->id,

                    'reward_type' =>
                        'withdrawal',

                    'transaction_type' =>
                        'debit',

                    'amount' =>
                        $requestedAmount,

                    'opening_balance' =>
                        $openingBalance,

                    'closing_balance' =>
                        $closingBalance,

                    'description' =>
                        'Reward withdrawal approved',

                    'status' =>
                        'completed',

                    'is_reverted' =>
                        0,

                    'meta_data' =>
                        json_encode([
                            'requested_amount' =>
                                $requestedAmount,

                            'deduction_percentage' =>
                                $withdrawal
                                    ->deduction_percentage,

                            'deduction_amount' =>
                                $withdrawal
                                    ->deduction_amount,

                            'payable_amount' =>
                                $withdrawal
                                    ->payable_amount,
                        ]),
                ]);


                return back()->with(
                    'success',
                    'Withdrawal approved successfully. ₹' .
                    number_format(
                        $requestedAmount,
                        2
                    ) .
                    ' has been deducted from customer rewards.'
                );
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | REJECT
    |--------------------------------------------------------------------------
    |
    | Rejection does NOT change customer's rewards.
    |
    */

    public function reject(
        Request $request,
        $id
    ) {

        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'admin_remark' =>
                'required|string|max:1000',

        ]);


        return DB::transaction(
            function () use ($request, $id) {

                /*
                |--------------------------------------------------------------------------
                | Lock Withdrawal
                |--------------------------------------------------------------------------
                */

                $withdrawal =
                    RewardWithdrawal::lockForUpdate()
                        ->findOrFail($id);


                /*
                |--------------------------------------------------------------------------
                | Only Pending Can Be Rejected
                |--------------------------------------------------------------------------
                */

                if (
                    $withdrawal->status !==
                    'pending'
                ) {

                    return back()->with(
                        'warning',
                        'This withdrawal request has already been processed.'
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | Reject
                |--------------------------------------------------------------------------
                */

                $withdrawal->status =
                    'rejected';

                $withdrawal->admin_remark =
                    $request->admin_remark;

                $withdrawal->save();


                return back()->with(
                    'success',
                    'Withdrawal request rejected successfully.'
                );
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SETTLE
    |--------------------------------------------------------------------------
    |
    | Settlement happens AFTER approval.
    |
    | Example:
    |
    | Requested       ₹1,000
    | Deduction 18%   ₹180
    | Payable         ₹820
    |
    | Admin transfers ₹820 to customer bank account.
    |
    */

    public function settle(
        Request $request,
        $id
    ) {

        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'settled_amount' => [
                'required',
                'numeric',
                'min:0',
            ],

            'settlement_reference' => [
                'required',
                'string',
                'max:255',
            ],

            'settlement_remark' => [
                'nullable',
                'string',
                'max:1000',
            ],

        ]);


        return DB::transaction(
            function () use ($request, $id) {

                /*
                |--------------------------------------------------------------------------
                | Lock Withdrawal
                |--------------------------------------------------------------------------
                */

                $withdrawal =
                    RewardWithdrawal::lockForUpdate()
                        ->findOrFail($id);


                /*
                |--------------------------------------------------------------------------
                | Only Approved Can Be Settled
                |--------------------------------------------------------------------------
                */

                if (
                    $withdrawal->status !==
                    'approved'
                ) {

                    return back()->with(
                        'warning',
                        'Only approved withdrawals can be settled.'
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | Prevent Duplicate Settlement
                |--------------------------------------------------------------------------
                */

                if (
                    $withdrawal->settled_at
                ) {

                    return back()->with(
                        'warning',
                        'This withdrawal has already been settled.'
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | Payable Amount
                |--------------------------------------------------------------------------
                */

                $payableAmount =
                    round(
                        (float) 
                        $withdrawal->payable_amount,
                        2
                    );


                /*
                |--------------------------------------------------------------------------
                | Settled Amount
                |--------------------------------------------------------------------------
                */

                $settledAmount =
                    round(
                        (float) 
                        $request->settled_amount,
                        2
                    );


                /*
                |--------------------------------------------------------------------------
                | Amount Must Match
                |--------------------------------------------------------------------------
                */

                if (
                    $settledAmount !==
                    $payableAmount
                ) {

                    return back()
                        ->withInput()
                        ->with(
                            'error',
                            'Settlement amount must be ₹' .
                            number_format(
                                $payableAmount,
                                2
                            )
                        );
                }


                /*
                |--------------------------------------------------------------------------
                | Settle
                |--------------------------------------------------------------------------
                */

                $withdrawal->settled_amount =
                    $settledAmount;

                $withdrawal->settlement_reference =
                    $request->settlement_reference;

                $withdrawal->settlement_remark =
                    $request->settlement_remark;

                $withdrawal->settled_at =
                    now();

                $withdrawal->settled_by =
                    auth()->id();

                $withdrawal->status =
                    'settled';

                $withdrawal->save();


                return redirect()
                    ->route(
                        'admin.reward-withdrawals.show',
                        $withdrawal->id
                    )
                    ->with(
                        'success',
                        'Withdrawal settled successfully.'
                    );
            }
        );
    }
}