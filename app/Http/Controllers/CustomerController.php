<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerPackage;
use App\Models\FiveWayDirectReferral;
use App\Models\FiveWayReferral;
use App\Models\Kyc;
use App\Models\Package;
use App\Models\PackageComponent;
use App\Models\PackageLevel;
use App\Models\Reward;
use App\Models\RewardWithdrawal;
use App\Models\ThreeWayDirectReferral;
use App\Models\ThreeWayReferral;
use App\Services\PlanApiService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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
    public function editProfile()
    {
        $customer = auth()->user();

        return view('website.customer.profile-edit', compact(
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

     public function bank()
    {
        $user = auth()->user();

        $kyc = Kyc::where('user_id', $user->id)
            ->where('user_role', 'customer')
            ->first();

        return view(
            'website.customer.bank',
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
                'max:255'
            ],

            'dob' => 'nullable|date',

            'profile_pic' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        if (!empty($request->email)) {

            $existingCustomer = Customer::where(
                'email',
                $request->email
            )
                ->where(
                    'id',
                    '!=',
                    $customer->id
                )
                ->first();

            if ($existingCustomer) {

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'This email address is already registered with another account.'
                    );
            }
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

    public function packageDetails($id)
    {
        $customer = Auth::user();

        $purchase = CustomerPackage::with('package')
            ->where('id', $id)
            ->where('customer_id', $customer->id)
            ->firstOrFail();

        return view(
            'website.customer.package-details',
            compact('customer', 'purchase')
        );
    }

    /**
     * Package Tree
     */
    public function packageTree($id)
    {
        $customer = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Get Customer Package
        |--------------------------------------------------------------------------
        */

        $customerPackage = CustomerPackage::with('package')
            ->where('id', $id)
            ->where('customer_id', $customer->id)
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Only Approved Package
        |--------------------------------------------------------------------------
        */

        if ($customerPackage->payment_status !== 'approved') {

            return back()->with(
                'error',
                'Tree is available only after package approval.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Package Tree Type
        |--------------------------------------------------------------------------
        */

        $treeType = $customerPackage->package->tree_type;


        /*
        |--------------------------------------------------------------------------
        | Select Tree Model
        |--------------------------------------------------------------------------
        */

        $treeModel = match ($treeType) {

            'three' =>
            ThreeWayReferral::class,

            'three_direct' =>
            ThreeWayDirectReferral::class,

            'five' =>
            FiveWayReferral::class,

            'five_direct' =>
            FiveWayDirectReferral::class,

            default =>
            null,
        };


        if (!$treeModel) {

            return back()->with(
                'error',
                'Invalid package tree type.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Get Customer Tree Node
        |--------------------------------------------------------------------------
        */

        $treeNode = $treeModel::where(
            'customer_id',
            $customer->id
        )->first();


        if (!$treeNode) {

            return back()->with(
                'error',
                'Your tree record was not found for this package.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Build Tree
        |--------------------------------------------------------------------------
        */

        $tree = $this->buildTree(
            $treeModel,
            $treeNode->userId
        );


        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'website.customer.package-tree',
            compact(
                'customer',
                'customerPackage',
                'treeNode',
                'tree',
                'treeType'
            )
        );
    }


    /**
     * Build package tree recursively.
     */
    protected function buildTree(
        string $treeModel,
        string $userId,
        int $level = 0,
        int $maxLevel = 6
    ): ?array {

        /*
        |--------------------------------------------------------------------------
        | Maximum Tree Level
        |--------------------------------------------------------------------------
        */

        if ($level >= $maxLevel) {
            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | Get Current Node
        |--------------------------------------------------------------------------
        */

        $node = $treeModel::where(
            'userId',
            $userId
        )->first();


        if (!$node) {
            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | Get Children
        |--------------------------------------------------------------------------
        */

        $children = $treeModel::where(
            'placedunder_id',
            $node->userId
        )
            ->orderBy('id')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Build Child Nodes
        |--------------------------------------------------------------------------
        */

        $childNodes = [];


        foreach ($children as $child) {

            $childNode = $this->buildTree(
                $treeModel,
                $child->userId,
                $level + 1,
                $maxLevel
            );


            if ($childNode) {
                $childNodes[] = $childNode;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Return Node
        |--------------------------------------------------------------------------
        */

        return [

            'id' =>
                $node->id,

            'customer_id' =>
                $node->customer_id,

            'userId' =>
                $node->userId,

            'sponser_id' =>
                $node->sponser_id,

            'placedunder_id' =>
                $node->placedunder_id,

            'rootmap' =>
                $node->rootmap,

            'left_points' =>
                $node->left_points,

            'right_points' =>
                $node->right_points,

            'points' =>
                $node->points,

            'g_count' =>
                $node->g_count,

            'placedunderid_cnt' =>
                $node->placedunderid_cnt,

            'children' =>
                $childNodes,
        ];
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

        $rewardHistory = Reward::where(
            'user_id',
            $customer->id
        )
            ->latest('id')
            ->get();
        $withdrawals = RewardWithdrawal::where('customer_id', $customer->id)
            ->latest('id')
            ->get();
        return view(
            'website.customer.wallet',
            compact(
                'customer',
                'rewardHistory',
                'withdrawals'
            )
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
        | My Direct Referrals
        |--------------------------------------------------------------------------
        */

        $referrals = Customer::where(
            'sponsor_id',
            $customer->userid
        )
            ->orderBy('created_at', 'desc')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $totalReferrals = $referrals->count();

        $directReferrals = $totalReferrals;

        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'website.customer.referrals',
            compact(
                'customer',
                'referrals',
                'totalReferrals',
                'directReferrals'
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
    // public function storePackagePurchase(Request $request, $id)
    // {
    //     $customer = auth()->user();

    //     $package = Package::where('id', $id)
    //         ->where('status', true)
    //         ->firstOrFail();

    //     $request->validate([
    //         'payment_reference' => [
    //             'nullable',
    //             'string',
    //             'max:255',
    //         ],

    //         'payment_receipt' => [
    //             'required',
    //             'image',
    //             'mimes:jpg,jpeg,png,webp',
    //             'max:5120',
    //         ],
    //     ]);

    //     /*
    //     |--------------------------------------------------------------------------
    //     | Check Existing Pending Purchase
    //     |--------------------------------------------------------------------------
    //     */

    //     $pendingPurchase = CustomerPackage::where(
    //         'customer_id',
    //         $customer->id
    //     )
    //         ->where(
    //             'package_id',
    //             $package->id
    //         )
    //         ->where(
    //             'payment_status',
    //             'pending'
    //         )
    //         ->exists();

    //     if ($pendingPurchase) {

    //         return back()
    //             ->withInput()
    //             ->with(
    //                 'error',
    //                 'You already have a pending payment for this package.'
    //             );
    //     }

    //     /*
    //     |--------------------------------------------------------------------------
    //     | Upload Receipt
    //     |--------------------------------------------------------------------------
    //     */

    //     $receiptPath = $request
    //         ->file('payment_receipt')
    //         ->store(
    //             'customer/package-payments',
    //             'public'
    //         );

    //     /*
    //     |--------------------------------------------------------------------------
    //     | Amount
    //     |--------------------------------------------------------------------------
    //     */

    //     $packageAmount = (float) ($package->price ?? 0);

    //     $joiningAmount = (float) ($package->joining_amount ?? 0);

    //     /*
    //     |--------------------------------------------------------------------------
    //     | Total
    //     |--------------------------------------------------------------------------
    //     |
    //     | Since this is a lifetime package, there is no expiry calculation.
    //     |
    //     */

    //     $totalAmount = $packageAmount;

    //     /*
    //     |--------------------------------------------------------------------------
    //     | Create Purchase
    //     |--------------------------------------------------------------------------
    //     */

    //     $purchase = CustomerPackage::create([

    //         'customer_id' => $customer->id,

    //         'package_id' => $package->id,

    //         'order_number' =>
    //             'PKG-' .
    //             now()->format('YmdHis') .
    //             '-' .
    //             strtoupper(Str::random(5)),

    //         'package_amount' => $packageAmount,

    //         'joining_amount' => $joiningAmount,

    //         'total_amount' => $totalAmount,

    //         'payment_method' => 'qr',

    //         'payment_reference' =>
    //             $request->payment_reference,

    //         'payment_receipt' =>
    //             $receiptPath,

    //         'payment_status' => 'pending',

    //         'package_status' => 'pending',
    //     ]);

    //     return redirect()
    //         ->route('customer.packages')
    //         ->with(
    //             'success',
    //             'Payment receipt uploaded successfully. Your package is waiting for admin approval.'
    //         );
    // }


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
        | Check Existing Package Purchase
        |--------------------------------------------------------------------------
        | A customer can purchase each package only once.
        |--------------------------------------------------------------------------
        */


        $existingPurchase = CustomerPackage::where('customer_id', $customer->id)
            ->where('package_id', $package->id)
            ->whereIn('payment_status', [
                'pending',
                'approved',
            ])
            ->exists();

        if ($existingPurchase) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'You have already purchased this package. You cannot purchase the same package again.'
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
        | Total Amount
        |--------------------------------------------------------------------------
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
                ->with(
                    'error',
                    'This Aadhaar number is already verified with another account.'
                )
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | Send Aadhaar OTP
        |--------------------------------------------------------------------------
        */

        $planApi = new PlanApiService();

        $response = $planApi->verifyAadhaar($aadhaarNo);

        Log::info('Aadhaar OTP Response', [
            'customer_id' => $customer->id,
            'response' => $response,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Check API status
        |--------------------------------------------------------------------------
        */

        $status = strtolower(
            (string) ($response['status'] ?? '')
        );

        if ($status !== 'success') {

            return back()
                ->with(
                    'error',
                    data_get($response, 'response.message')
                    ?? $response['message']
                    ?? $response['Message']
                    ?? 'Unable to send Aadhaar OTP. Please try again.'
                )
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | IMPORTANT
        |
        | PlanAPI returns:
        |
        | response.ref_id
        |--------------------------------------------------------------------------
        */

        $reqId = data_get(
            $response,
            'response.ref_id'
        );

        if (!$reqId) {

            Log::error('Aadhaar OTP Reference ID Missing', [
                'customer_id' => $customer->id,
                'response' => $response,
            ]);

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

        $kyc->aadhaar_req_id = $reqId;

        $kyc->save();

        /*
        |--------------------------------------------------------------------------
        | OTP Sent Successfully
        |--------------------------------------------------------------------------
        */

        return back()
            ->with(
                'success',
                'Aadhaar OTP sent successfully.'
            )
            ->with('aadhaar_otp', true);
    }

    public function verifyAadhaarOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => [
                'required'
            ],
        ], [
            'otp.required' => 'Please enter the Aadhaar OTP.'
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
        | Verify OTP
        |--------------------------------------------------------------------------
        */

        $planApi = new PlanApiService();

        $response = $planApi->verifyAadhaarOtp(
            $kyc->aadhaar_no,
            $request->otp,
            $kyc->aadhaar_req_id
        );

        Log::info('Aadhaar OTP Verification Response', [
            'customer_id' => $customer->id,
            'response' => $response,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Check Response
        |--------------------------------------------------------------------------
        */

        $status = strtolower(
            (string) ($response['status'] ?? '')
        );

        $errorCode = (int) (
            $response['Errorcode']
            ?? $response['errorcode']
            ?? 0
        );

        /*
        |--------------------------------------------------------------------------
        | PlanAPI Success Codes
        |
        | Documentation says:
        | 100, 200, 211 = successful
        |--------------------------------------------------------------------------
        */

        $success = in_array($errorCode, [
            100,
            200,
            211,
        ], true);

        if ($status === 'success') {
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
                    data_get($response, 'response.message')
                    ?? $response['message']
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

        $kyc->aadhaar_req_id = null;

        $kyc->save();

        /*
        |--------------------------------------------------------------------------
        | Update Customer KYC
        |--------------------------------------------------------------------------
        */

        $customer->kyc_status = 'approved';

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
                'required'
            ],
        ], [
            'pan_no.required' => 'Please enter your PAN number.'
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