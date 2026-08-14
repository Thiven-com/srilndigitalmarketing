<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Reward;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->paginate(10);

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
        } else {
            return redirect(route('admin.customers.show', ['customer' => $customer->id, 'slug' => 'profile']));
        }
    }
}
