<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerPackage;
use App\Models\Kyc;
use App\Models\Package;
use App\Models\PackageComponent;
use App\Models\PackageLevel;
use App\Services\PlanApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    protected PlanApiService $planApiService;

    public function __construct(PlanApiService $planApiService)
    {
        $this->planApiService = $planApiService;
    }
    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    public function dashboard()
    {
        $customer = auth()->user();

        return view('website.customer.dashboard', compact(
            'customer'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    public function profile()
    {
        $customer = auth()->user();

        return view('website.customer.profile', compact(
            'customer'
        ));
    }

    public function kyc()
    {
        $user = auth()->user();

        $kyc = Kyc::where('user_id', $user->id)
            ->where('user_role', 'customer')
            ->first();

        return view(
            'website.customer.kyc',
            compact('user', 'kyc')
        );
    }



    /*
    |--------------------------------------------------------------------------
    | Update Profile
    |--------------------------------------------------------------------------
    */

    public function updateProfile(Request $request)
    {
        $customer = auth()->user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',

            'email' => [
                'nullable',
                'email',
                'max:255',
                'unique:customers,email,' . $customer->id,
            ],

            'dob' => 'nullable|date',

            'profile_pic' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }


        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->dob = $request->dob;


        /*
        |--------------------------------------------------------------------------
        | Profile Picture
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('profile_pic')) {

            if ($customer->profile_pic) {

                Storage::disk('public')->delete(
                    $customer->profile_pic
                );
            }

            $customer->profile_pic = $request
                ->file('profile_pic')
                ->store('customers/profile', 'public');
        }


        /*
        |--------------------------------------------------------------------------
        | Email Verification Reset
        |--------------------------------------------------------------------------
        */

        if (
            $customer->isDirty('email') &&
            $customer->email
        ) {
            $customer->email_verified = 'no';
            $customer->email_verified_at = null;
        }


        $customer->save();


        return back()->with(
            'success',
            'Profile updated successfully.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Packages
    |--------------------------------------------------------------------------
    */

    public function myPackages()
    {
        $customer = auth()->user();

        $packages = CustomerPackage::with('package')
            ->where('customer_id', $customer->id)
            ->latest()
            ->get();

        return view(
            'website.customer.my-packages',
            compact('customer', 'packages')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Package Details
    |--------------------------------------------------------------------------
    */

    public function packageDetails($id)
    {
        $package = Package::query()
            ->where('id', $id)
            ->where('status', true)
            ->firstOrFail();


        $components = PackageComponent::query()
            ->where('package_id', $package->id)
            ->where('status', true)
            ->orderBy('sort_order')
            ->get();


        $levels = PackageLevel::query()
            ->where('package_id', $package->id)
            ->where('status', true)
            ->orderBy('level')
            ->get();


        return view(
            'website.customer.package-details',
            compact(
                'package',
                'components',
                'levels'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | My Package
    |--------------------------------------------------------------------------
    */

    public function myPackage()
    {
        $customer = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Package relationship will be connected here
        |--------------------------------------------------------------------------
        |
        | Once your customer package/purchase table is created,
        | load the customer's active package here.
        |
        */

        $package = null;

        return view(
            'website.customer.my-package',
            compact(
                'customer',
                'package'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Wallet
    |--------------------------------------------------------------------------
    */

    public function wallet()
    {
        $customer = auth()->user();

        return view(
            'website.customer.wallet',
            compact('customer')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Rewards
    |--------------------------------------------------------------------------
    */

    public function rewards()
    {
        $customer = auth()->user();

        return view(
            'website.customer.rewards',
            compact('customer')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Earnings
    |--------------------------------------------------------------------------
    */

    public function earnings()
    {
        $customer = auth()->user();

        return view(
            'website.customer.earnings',
            compact('customer')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Referrals
    |--------------------------------------------------------------------------
    */

    public function referrals(Request $request)
    {
        $customer = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Customer Packages
        |--------------------------------------------------------------------------
        */

        $customerPackages = CustomerPackage::with('package')
            ->where('customer_id', $customer->id)
            ->where('payment_status', 'approved')
            ->latest()
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Package List
        |--------------------------------------------------------------------------
        */

        $packages = $customerPackages
            ->map(function ($customerPackage) {

                if (!$customerPackage->package) {
                    return null;
                }

                $package = clone $customerPackage->package;

                /*
                 * Important:
                 * Customer can purchase same package multiple times.
                 *
                 * Therefore we keep customer_package ID.
                 */

                $package->customer_package_id =
                    $customerPackage->id;

                return $package;

            })
            ->filter()
            ->values();


        /*
        |--------------------------------------------------------------------------
        | Selected Customer Package
        |--------------------------------------------------------------------------
        */

        $selectedCustomerPackage = null;

        $selectedPackage = null;


        if ($request->filled('package')) {

            $selectedCustomerPackage = $customerPackages
                ->firstWhere(
                    'id',
                    $request->package
                );


            if (
                $selectedCustomerPackage &&
                $selectedCustomerPackage->package
            ) {

                $selectedPackage =
                    $selectedCustomerPackage->package;

            }
        }


        /*
        |--------------------------------------------------------------------------
        | Referral Data
        |--------------------------------------------------------------------------
        |
        | Will connect later:
        |
        | three_way_referrals
        | three_way_direct_referrals
        |
        | five_way_referrals
        | five_way_direct_referrals
        |
        */

        $referrals = collect();

        $totalReferrals = 0;

        $directReferrals = 0;

        $totalPoints = 0;

        $totalIncome = 0;


        return view(
            'website.customer.referrals',
            compact(
                'customer',
                'packages',
                'selectedPackage',
                'selectedCustomerPackage',
                'referrals',
                'totalReferrals',
                'directReferrals',
                'totalPoints',
                'totalIncome'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('home')
            ->with(
                'success',
                'Logged out successfully.'
            );
    }

    public function purchasePackage($id)
    {
        $customer = auth()->user();

        $package = Package::where('id', $id)
            ->where('status', true)
            ->first();

        return view(
            'website.customer.package-purchase',
            compact(
                'customer',
                'package'
            )
        );
    }
    public function storePackagePurchase(Request $request, $id)
    {
        $customer = auth()->user();

        $package = Package::where('id', $id)
            ->where('status', true)
            ->firstOrFail();

        $request->validate([
            'payment_reference' => [
                'nullable',
                'string',
                'max:255',
            ],

            'payment_receipt' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Check Existing Pending Purchase
        |--------------------------------------------------------------------------
        */

        $pendingPurchase = CustomerPackage::where(
            'customer_id',
            $customer->id
        )
            ->where(
                'package_id',
                $package->id
            )
            ->where(
                'payment_status',
                'pending'
            )
            ->exists();

        if ($pendingPurchase) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'You already have a pending payment for this package.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Upload Receipt
        |--------------------------------------------------------------------------
        */

        $receiptPath = $request
            ->file('payment_receipt')
            ->store(
                'customer/package-payments',
                'public'
            );

        /*
        |--------------------------------------------------------------------------
        | Amount
        |--------------------------------------------------------------------------
        */

        $packageAmount = (float) ($package->price ?? 0);

        $joiningAmount = (float) ($package->joining_amount ?? 0);

        /*
        |--------------------------------------------------------------------------
        | Total
        |--------------------------------------------------------------------------
        |
        | Since this is a lifetime package, there is no expiry calculation.
        |
        */

        $totalAmount = $packageAmount;

        /*
        |--------------------------------------------------------------------------
        | Create Purchase
        |--------------------------------------------------------------------------
        */

        $purchase = CustomerPackage::create([

            'customer_id' => $customer->id,

            'package_id' => $package->id,

            'order_number' =>
                'PKG-' .
                now()->format('YmdHis') .
                '-' .
                strtoupper(Str::random(5)),

            'package_amount' => $packageAmount,

            'joining_amount' => $joiningAmount,

            'total_amount' => $totalAmount,

            'payment_method' => 'qr',

            'payment_reference' =>
                $request->payment_reference,

            'payment_receipt' =>
                $receiptPath,

            'payment_status' => 'pending',

            'package_status' => 'pending',
        ]);

        return redirect()
            ->route('customer.packages')
            ->with(
                'success',
                'Payment receipt uploaded successfully. Your package is waiting for admin approval.'
            );
    }

    public function verifyAadhaar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'aadhaar_no' => [
                'required',
                'digits:12',
            ],
        ], [
            'aadhaar_no.required' => 'Please enter your Aadhaar number.',
            'aadhaar_no.digits' => 'Aadhaar number must be exactly 12 digits.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $customer = Auth::user();

        $aadhaarNo = $request->aadhaar_no;

        /*
        |--------------------------------------------------------------------------
        | Check Aadhaar already used
        |--------------------------------------------------------------------------
        */

        $alreadyUsed = Kyc::where('aadhaar_no', $aadhaarNo)
            ->where('user_role', 'customer')
            ->where('user_id', '!=', $customer->id)
            ->where('aadhar_status', 'approved')
            ->exists();

        if ($alreadyUsed) {
            return back()
                ->with('error', 'This Aadhaar number is already verified with another account.')
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | PlanAPI Aadhaar OTP
        |--------------------------------------------------------------------------
        */

        $planApi = new PlanApiService();

        $response = $planApi->verifyAadhaar($aadhaarNo);

        \Log::info('Aadhaar OTP Response', [
            'customer_id' => $customer->id,
            'response' => $response,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Check API response
        |--------------------------------------------------------------------------
        */

        if (
            empty($response) ||
            (
                isset($response['status']) &&
                !in_array(strtolower((string) $response['status']), [
                    'success',
                    '1',
                    'true',
                ])
            )
        ) {
            return back()
                ->with(
                    'error',
                    $response['message']
                    ?? $response['Message']
                    ?? 'Unable to send Aadhaar OTP. Please try again.'
                )
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | Get Request ID
        |--------------------------------------------------------------------------
        */

        $reqId =
            $response['ref_id']
            ?? $response['RefId']
            ?? $response['ReqId']
            ?? $response['req_id']
            ?? data_get($response, 'data.ref_id')
            ?? data_get($response, 'data.RefId')
            ?? data_get($response, 'data.ReqId');

        if (!$reqId) {
            return back()
                ->with(
                    'error',
                    'Aadhaar OTP was requested, but verification reference was not received.'
                )
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | Create / Update KYC
        |--------------------------------------------------------------------------
        */

        $kyc = Kyc::firstOrNew([
            'user_id' => $customer->id,
            'user_role' => 'customer',
        ]);

        $kyc->aadhaar_no = $aadhaarNo;

        $kyc->aadhar_status = 'pending';

        /*
        |--------------------------------------------------------------------------
        | Store temporary request ID
        |
        | If you don't have req_id column, add it to kycs table.
        |--------------------------------------------------------------------------
        */

        $kyc->aadhaar_req_id = $reqId;

        $kyc->save();

        return back()
            ->with('success', 'Aadhaar OTP sent successfully.')
            ->with('aadhaar_otp', true);
    }

    public function verifyAadhaarOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => [
                'required',
                'digits:6',
            ],
        ], [
            'otp.required' => 'Please enter the Aadhaar OTP.',
            'otp.digits' => 'OTP must be exactly 6 digits.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $customer = Auth::user();

        $kyc = Kyc::where('user_id', $customer->id)
            ->where('user_role', 'customer')
            ->first();

        if (!$kyc) {
            return back()->with(
                'error',
                'KYC record not found. Please request Aadhaar OTP first.'
            );
        }

        if (!$kyc->aadhaar_no) {
            return back()->with(
                'error',
                'Aadhaar number not found. Please request OTP again.'
            );
        }

        if (!$kyc->aadhaar_req_id) {
            return back()->with(
                'error',
                'Aadhaar verification session expired. Please request OTP again.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | PlanAPI OTP Verification
        |--------------------------------------------------------------------------
        */

        $planApi = new PlanApiService();

        $response = $planApi->verifyAadhaarOtp(
            $kyc->aadhaar_no,
            $request->otp,
            $kyc->aadhaar_req_id
        );

        \Log::info('Aadhaar OTP Verification Response', [
            'customer_id' => $customer->id,
            'response' => $response,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Determine verification status
        |--------------------------------------------------------------------------
        */

        $success = false;

        if (isset($response['status'])) {
            $status = strtolower((string) $response['status']);

            $success = in_array($status, [
                'success',
                '1',
                'true',
            ]);
        }

        if (
            isset($response['success']) &&
            in_array($response['success'], [true, 1, '1', 'true'], true)
        ) {
            $success = true;
        }

        if (
            isset($response['Status']) &&
            in_array(
                strtolower((string) $response['Status']),
                ['success', '1', 'true']
            )
        ) {
            $success = true;
        }

        /*
        |--------------------------------------------------------------------------
        | Failed
        |--------------------------------------------------------------------------
        */

        if (!$success) {

            $kyc->aadhar_status = 'rejected';
            $kyc->save();

            return back()
                ->with(
                    'error',
                    $response['message']
                    ?? $response['Message']
                    ?? 'Aadhaar OTP verification failed.'
                )
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | Aadhaar Verified
        |--------------------------------------------------------------------------
        */

        $kyc->aadhar_status = 'approved';

        $kyc->aadhaar_verified_at = Carbon::now();

        $kyc->save();

        /*
        |--------------------------------------------------------------------------
        | Update customer KYC status
        |--------------------------------------------------------------------------
        */

        $customer->kyc_status = 'pending';

        $customer->save();

        return redirect()
            ->route('customer.kyc')
            ->with(
                'success',
                'Aadhaar verified successfully.'
            );
    }

    public function verifyPan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pan_no' => [
                'required',
                'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
            ],
        ], [
            'pan_no.required' => 'Please enter your PAN number.',
            'pan_no.regex' => 'Please enter a valid PAN number.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $customer = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Aadhaar must be verified first
        |--------------------------------------------------------------------------
        */

        $kyc = Kyc::firstOrNew([
            'user_id' => $customer->id,
            'user_role' => 'customer',
        ]);

        if ($kyc->aadhar_status !== 'approved') {
            return back()->with(
                'error',
                'Please complete Aadhaar verification first.'
            );
        }

        $panNo = strtoupper($request->pan_no);

        /*
        |--------------------------------------------------------------------------
        | Check PAN already used
        |--------------------------------------------------------------------------
        */

        $alreadyUsed = Kyc::where('pan_no', $panNo)
            ->where('user_role', 'customer')
            ->where('user_id', '!=', $customer->id)
            ->where('pan_status', 'approved')
            ->exists();

        if ($alreadyUsed) {
            return back()
                ->with('error', 'This PAN is already verified with another account.')
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | PlanAPI PAN Verification
        |--------------------------------------------------------------------------
        */

        $planApi = new PlanApiService();

        $response = $planApi->verifyPan($panNo);

        \Log::info('PAN Verification Response', [
            'customer_id' => $customer->id,
            'response' => $response,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Determine API success
        |--------------------------------------------------------------------------
        */

        $success = false;

        if (isset($response['status'])) {

            $status = strtolower((string) $response['status']);

            $success = in_array($status, [
                'success',
                '1',
                'true',
            ]);
        }

        if (
            isset($response['success']) &&
            in_array($response['success'], [true, 1, '1', 'true'], true)
        ) {
            $success = true;
        }

        /*
        |--------------------------------------------------------------------------
        | Failed
        |--------------------------------------------------------------------------
        */

        if (!$success) {

            $kyc->pan_status = 'rejected';
            $kyc->save();

            return back()
                ->with(
                    'error',
                    $response['message']
                    ?? $response['Message']
                    ?? 'PAN verification failed.'
                )
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | Save PAN
        |--------------------------------------------------------------------------
        */

        $kyc->pan_no = $panNo;

        $kyc->pan_status = 'approved';

        $kyc->pan_verified_at = Carbon::now();

        $kyc->save();

        /*
        |--------------------------------------------------------------------------
        | Overall KYC
        |--------------------------------------------------------------------------
        */

        if (
            $kyc->aadhar_status === 'approved' &&
            $kyc->pan_status === 'approved'
        ) {
            $customer->kyc_status = 'approved';
        } else {
            $customer->kyc_status = 'pending';
        }

        $customer->save();

        return redirect()
            ->route('customer.kyc')
            ->with(
                'success',
                'PAN verified successfully.'
            );
    }
    public function verifyBank(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account_number' => [
                'required',
                'numeric',
                'digits_between:8,20',
                'confirmed',
            ],

            'account_number_confirmation' => [
                'required',
            ],

            'ifsc' => [
                'required',
                'string',
            ],
        ], [
            'account_number.required' => 'Please enter your account number.',
            'account_number.numeric' => 'Account number must contain only digits.',
            'account_number.digits_between' => 'Account number must be between 8 to 20 digits.',
            'account_number.confirmed' => 'Account Number and Confirm Account Number must match.',
            'account_number_confirmation.required' => 'Please confirm your account number.',
            'ifsc.required' => 'Please enter IFSC.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        try {

            $accountNo = $request->account_number;
            $ifsc = strtoupper($request->ifsc);

            $planApi = new PlanApiService();

            $data = $planApi->verifyBank(
                $accountNo,
                $ifsc
            );

            $response = $data['response'] ?? [];

            $account = $response['beneficiary_account'] ?? $accountNo;
            $beneficiaryIfsc = $response['beneficiary_ifsc'] ?? $ifsc;
            $accountName = $response['beneficiary_name'] ?? null;
            $accountStatus = $response['account_status'] ?? null;
            $branchName = $response['branch_name'] ?? null;
            $bankName = $response['bank_name'] ?? null;

            return response()->json([
                'success' => 1,

                'account' => $account,

                'ifsc' => $beneficiaryIfsc,

                'bank_name' => $bankName,

                'branch_name' => $branchName,

                'account_status' => $accountStatus,

                'account_name' => $accountName,
            ]);

        } catch (\Throwable $e) {

            return response()->json([
                'success' => 0,
                'message' => 'Bank verification failed.',
            ], 422);
        }
    }
    public function verifyUpi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'upi_id' => [
                'required',
                'string',
                'max:255',
            ],
        ], [
            'upi_id.required' => 'Please enter UPI ID.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        try {

            $upiId = $request->upi_id;

            $planApi = new PlanApiService();

            $data = $planApi->verifyUpi($upiId);

            $upiData = $data['data'] ?? [];

            $upiName = $upiData['Name']
                ?? $upiData['name']
                ?? null;

            $verifiedUpi = $upiData['Upiid']
                ?? $upiData['UpiId']
                ?? $upiId;

            return response()->json([
                'success' => 1,
                'name' => $upiName,
                'upi_id' => $verifiedUpi,
                'data' => $data,
            ]);

        } catch (\Throwable $e) {

            return response()->json([
                'success' => 0,
                'message' => 'UPI verification failed.',
            ], 422);
        }
    }
}