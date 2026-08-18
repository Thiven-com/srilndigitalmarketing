<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\Customer;
use App\Models\Kyc;
use App\Models\Reward;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query();

        if ($request->type === 'new') {
            $query->whereDate('created_at', today());
        }

        $customers = $query->paginate(10);

        return view('admin.customers.all', compact('customers'));
    }

    public function show(Request $request, string $id)
    {
        $customer = Customer::find($id);
        if ($request->slug == 'profile') {
            return view('admin.customers.profile', compact('customer'));
        } elseif ($request->slug == 'rewards') {
            $rewards = Reward::where(['user_id' => $customer->id, 'role' => 'customer'])->orderBy('id', 'desc')->paginate(20)->withQueryString();
            return view('admin.customers.rewards', compact('customer', 'rewards'));
        } elseif ($request->slug == 'kyc') {

            // KYC details
            $kyc = Kyc::where('user_id', $customer->id)
                ->where('user_role', 'customer')
                ->first();

            $bankAccount = BankAccount::where('user_id', $customer->id)
                ->where('user_role', 'customer')
                ->first();

            return view('admin.customers.kyc', compact(
                'customer',
                'bankAccount',
                'kyc'
            ));

        } elseif ($request->slug == 'bankdetails') {

            $bankAccount = BankAccount::where('user_id', $customer->id)
                ->where('user_role', 'customer')
                ->first();

            return view('admin.customers.bankdetails', compact(
                'customer',
                'bankAccount'
            ));

        } else {
            return redirect(route('admin.customers.show', ['customer' => $customer->id, 'slug' => 'profile']));
        }
    }
}
