<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reward;
use Illuminate\Http\Request;

class RewardHistoryController extends Controller
{
    public function index()
    {
        $rewards = Reward::with('customer')
            ->latest()
            ->paginate(10);

        return view('admin.rewordhistory.index', compact('rewards'));
    }
}
