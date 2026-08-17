<?php

namespace App\Http\Controllers;

use App\Models\RewardWithdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RewardController extends Controller
{
    //
    public function requestRewardWithdrawal(Request $request)
    {
        $customer = auth()->user();

        $validator = Validator::make($request->all(), [

            'amount' => [
                'required',
                'numeric',
                'min:1',
            ],

        ]);

        if ($validator->fails()) {

            return back()
                ->withErrors($validator)
                ->withInput();
        }


        $amount = round(
            (float) $request->amount,
            2
        );


        /*
        |--------------------------------------------------------------------------
        | Current Rewards
        |--------------------------------------------------------------------------
        */

        $rewards = (float) (
            $customer->rewards ?? 0
        );


        /*
        |--------------------------------------------------------------------------
        | Check Balance
        |--------------------------------------------------------------------------
        */

        if ($amount > $rewards) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Insufficient reward balance.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Prevent Multiple Pending Requests
        |--------------------------------------------------------------------------
        */

        $pending = RewardWithdrawal::where(
            'customer_id',
            $customer->id
        )
            ->where(
                'status',
                'pending'
            )
            ->exists();


        if ($pending) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'You already have a pending withdrawal request.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | 18% Deduction
        |--------------------------------------------------------------------------
        */

        $deductionPercentage = 18;

        $deductionAmount = round(
            $amount * $deductionPercentage / 100,
            2
        );


        /*
        |--------------------------------------------------------------------------
        | Customer Receives 82%
        |--------------------------------------------------------------------------
        */

        $payableAmount = round(
            $amount - $deductionAmount,
            2
        );


        /*
        |--------------------------------------------------------------------------
        | Create Request
        |--------------------------------------------------------------------------
        */

        RewardWithdrawal::create([

            'customer_id' =>
                $customer->id,

            'requested_amount' =>
                $amount,

            'deduction_percentage' =>
                $deductionPercentage,

            'deduction_amount' =>
                $deductionAmount,

            'payable_amount' =>
                $payableAmount,

            'opening_rewards' =>
                $rewards,

            'status' =>
                'pending',

        ]);


        return back()->with(
            'success',
            'Withdrawal request submitted successfully.'
        );
    }
}
