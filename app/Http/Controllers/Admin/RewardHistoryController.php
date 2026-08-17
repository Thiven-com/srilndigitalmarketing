<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reward;
use Illuminate\Http\Request;

class RewardHistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Reward::with('customer')->latest();

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('description', 'like', "%{$search}%")
                    ->orWhere('source_type', 'like', "%{$search}%")
                    ->orWhere('source_id', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($customer) use ($search) {

                        $customer->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('mobile', 'like', "%{$search}%");

                    });

            });
        }

        $rewards = $query->paginate(10)->withQueryString();

        return view('admin.reward.index', compact('rewards'));
    }
}
