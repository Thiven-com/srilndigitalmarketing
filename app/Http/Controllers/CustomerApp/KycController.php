<?php

namespace App\Http\Controllers\CustomerApp;

use App\Http\Controllers\Controller;
use App\Http\Resources\BankCollection;
use App\Models\BankAccount;
use App\Models\Kyc;
use App\Services\PlanApiService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class KycController extends Controller
{
    //
    public function index()
    {
        $user = auth('customer')->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $bankAccount = BankAccount::where('user_id', $user->id)
            ->where('user_role', 'customer')
            ->first();

        return view('website.customer.bank', compact('bankAccount'));
    }


    /**
     * Verify and Save Bank Account
     */
    public function store(Request $request)
    {
        $user = auth('customer')->user();

        if (!$user) {
            return redirect()
                ->route('login')
                ->with('error', 'Please login to continue.');
        }

        $validator = Validator::make(
            $request->all(),
            [
                'account_number' => [
                    'required',
                    'numeric',
                    'digits_between:8,20',
                    'confirmed',
                ],

                'account_number_confirmation' => [
                    'required',
                ],

                'ifsc_code' => [
                    'required',
                    'string',
                    'size:11',
                    'regex:/^[A-Z]{4}0[A-Z0-9]{6}$/i',
                ],
            ],
            [
                'account_number.required' =>
                    'Please enter your account number.',

                'account_number.numeric' =>
                    'Account number must contain only digits.',

                'account_number.digits_between' =>
                    'Account number must be between 8 and 20 digits.',

                'account_number.confirmed' =>
                    'Account Number and Confirm Account Number must match.',

                'account_number_confirmation.required' =>
                    'Please confirm your account number.',

                'ifsc_code.required' =>
                    'Please enter IFSC code.',

                'ifsc_code.size' =>
                    'IFSC code must be exactly 11 characters.',

                'ifsc_code.regex' =>
                    'Please enter a valid IFSC code.',
            ]
        );

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $accountNo = $request->account_number;
        $ifscCode = strtoupper(trim($request->ifsc_code));

        try {

            /*
             * Call PlanAPI
             */
            $planApi = new PlanApiService();

            $response = $planApi->verifyBank(
                $accountNo,
                $ifscCode
            );

            /*
             * Check API response
             */
            if (
                empty($response) ||
                !isset($response['response'])
            ) {
                return back()
                    ->with('error', 'Unable to verify bank details. Please try again.')
                    ->withInput();
            }

            $apiData = $response['response'];

            $account = $apiData['beneficiary_account'] ?? null;
            $verifiedIfsc = $apiData['beneficiary_ifsc'] ?? $ifscCode;
            $accountName = $apiData['beneficiary_name'] ?? null;
            $accountStatus = $apiData['account_status'] ?? null;
            $branchName = $apiData['branch_name'] ?? null;
            $bankName = $apiData['bank_name'] ?? null;

            /*
             * Check verification result
             */
            if (empty($accountName)) {

                return back()
                    ->with(
                        'error',
                        'Bank account could not be verified. Please check your Account Number and IFSC.'
                    )
                    ->withInput();
            }

            /*
             * Optional status check
             *
             * Adjust these values according to PlanAPI's
             * actual response.
             */
            if (
                !empty($accountStatus) &&
                !in_array(
                    strtolower($accountStatus),
                    ['active', 'success', 'verified', 'valid']
                )
            ) {
                return back()
                    ->with(
                        'error',
                        'Bank account verification failed. Account status: ' . $accountStatus
                    )
                    ->withInput();
            }

            /*
             * Find existing bank account
             */
            $bank = BankAccount::where('user_id', $user->id)
                ->where('user_role', 'customer')
                ->first();

            if (!$bank) {
                $bank = new BankAccount();

                $bank->user_id = $user->id;
                $bank->user_role = 'customer';
            }

            /*
             * Save VERIFIED details from PlanAPI
             *
             * Do not use account_name/bank_name/branch_name
             * submitted by the customer.
             */
            $bank->account_number = $account;
            $bank->ifsc_code = $verifiedIfsc;
            $bank->account_name = $accountName;
            $bank->branch_name = $branchName;
            $bank->bank_name = $bankName;

            $bank->bank_status = 'approved';

            /*
             * Preserve existing UPI details
             */
            $bank->save();

            return redirect()
                ->route('customer.bank.index')
                ->with(
                    'success',
                    'Bank account verified successfully.'
                );

        } catch (Throwable $e) {

            Log::error('Bank verification failed', [
                'user_id' => $user->id,
                'account_number' => $accountNo,
                'ifsc' => $ifscCode,
                'error' => $e->getMessage(),
            ]);

            return back()
                ->with(
                    'error',
                    'Bank verification service is currently unavailable. Please try again later.'
                )
                ->withInput();
        }
    }


    /**
     * Verify and Save UPI
     */
    public function storeUpi(Request $request)
    {
        $user = auth('customer')->user();

        if (!$user) {
            return redirect()
                ->route('login')
                ->with('error', 'Please login to continue.');
        }

        $validator = Validator::make(
            $request->all(),
            [
                'upi_id' => [
                    'required',
                    'string',
                    'max:100',
                    'regex:/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+$/',
                ],
            ],
            [
                'upi_id.required' =>
                    'Please enter your UPI ID.',

                'upi_id.regex' =>
                    'Please enter a valid UPI ID.',
            ]
        );

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $upiId = trim($request->upi_id);

        try {

            $planApi = new PlanApiService();

            $response = $planApi->verifyUpi($upiId);

            /*
             * Check API response
             */
            if (
                empty($response) ||
                !isset($response['data'])
            ) {
                return back()
                    ->with('error', 'Unable to verify UPI ID.')
                    ->withInput();
            }

            $apiData = $response['data'];

            $upiName = $apiData['Name'] ?? null;
            $verifiedUpiId = $apiData['Upiid'] ?? $upiId;

            if (empty($upiName)) {
                return back()
                    ->with(
                        'error',
                        'Invalid UPI ID. Please enter a valid UPI ID.'
                    )
                    ->withInput();
            }

            /*
             * Find existing bank account
             */
            $bankAccount = BankAccount::where('user_id', $user->id)
                ->where('user_role', 'customer')
                ->first();

            if (!$bankAccount) {

                $bankAccount = new BankAccount();

                $bankAccount->user_id = $user->id;
                $bankAccount->user_role = 'customer';
            }

            $bankAccount->upi_id = $verifiedUpiId;
            $bankAccount->upi_status = 'approved';

            $bankAccount->save();

            return redirect()
                ->route('customer.bank.index')
                ->with(
                    'success',
                    'UPI ID verified successfully.'
                );

        } catch (Throwable $e) {

            Log::error('UPI verification failed', [
                'user_id' => $user->id,
                'upi_id' => $upiId,
                'error' => $e->getMessage(),
            ]);

            return back()
                ->with(
                    'error',
                    'UPI verification service is currently unavailable.'
                )
                ->withInput();
        }
    }


    public function panVerify(Request $request)
    {
        $pan_no = strtoupper($request->pan_no);
        if (empty($pan_no)) {
            return response()->json([
                'success' => 0,
                'message' => 'Pan No Required'
            ]);
        }
        $plan_api = new PlanApiService();
        $data = $plan_api->verifyPan($pan_no);
        $pan_name = $data['response']['registered_name'];
        $pan_no = $data['response']['pan_no'];
        if (!empty($pan_name)) {
            return response()->json([
                'success' => 1,
                'name' => $pan_name,
                'pan_no' => $pan_no,
            ]);
        } else {
            return response()->json([
                'success' => 0,
                'message' => 'Enter Valid Pan No'
            ]);
        }
    }

    public function panConfirm(Request $request)
    {

        $user = auth('sanctum')->user();
        if (!isset($user->id)) {
            return response()->json([
                'success' => 9,
                'message' => 'Please Login'
            ]);
        }
        // $validator = Validator::make($request->all(), [
        //     'pan_no' => 'required',
        //     'pan_name' => 'required',

        // ]);
        $kyc = Kyc::where(['user_role' => 'customer', 'user_id' => $user->id])->first();

        $validator = Validator::make($request->all(), [
            'pan_no' => [
                'required',
                Rule::unique('kycs', 'pan_no')->ignore($kyc?->id),
            ],
            'pan_name' => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ]);
        }

        if (isset($kyc->id)) {
            $kyc->pan_no = strtoupper($request->pan_no);
            $kyc->pan_status = 'approved';
            $kyc->pan_verified_at = Carbon::now();
            $kyc->save();
        } else {
            $kyc = new Kyc();
            $kyc->user_id = $user->id;
            $kyc->user_role = 'customer';
            $kyc->pan_no = strtoupper($request->pan_no);
            $kyc->pan_status = 'approved';
            $kyc->pan_verified_at = Carbon::now();
            $kyc->save();
        }

        $user->old_name = $user->name;
        $user->save();
        $user->name = $request->pan_name;
        $user->save();

        return response()->json([
            'success' => 1,
            'message' => 'PAN Number Updated Successfully'
        ]);
    }
}
