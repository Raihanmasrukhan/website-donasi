<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Models\Donatur;
use App\Models\fundraiser;
use App\Models\fundraising;
use App\Models\fundraisingWithdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function apply_fundraiser() {

        $user = Auth::user();

        DB::transaction(function () use ($user) {

            $validated['user_id'] = $user->id;
            $validated['is_active'] = false;

            fundraiser::create($validated);
            
        });

        return redirect()->route('admin.fundraisers.index');

    }

        public function my_withdrawals(){
            $user = Auth::user();
            $fundraiserId = $user->fundraiser->id;

            $withdrawals = fundraisingWithdrawal::where('fundraiser_id', $fundraiserId)->orderByDesc('id')->get();
            return view('admin.my_withdrawals.index', compact('withdrawals'));
            
        }

        public function my_withdrawals_details(FundraisingWithdrawal $fundraisingWithdrawal) {
            return view('admin.my_withdrawals.details', compact('fundraisingWithdrawal'));
        }

        public function index() {
            $user = Auth::user();

            $fundraisingQuery = Fundraising::query();
            $withdrawalsQuery = FundraisingWithdrawal::query();

            if($user->hasRole('fundraiser')) {
                $fundraiserId = $user->fundraiser->id;

                $fundraisingQuery->where('fundraiser_id', $fundraiserId);
                $withdrawalsQuery->where('fundraiser_id', $fundraiserId);

                $fundraisingIds = $fundraisingQuery->pluck('id');

                $donaturs = Donatur::whereIn('fundraising_id', $fundraisingIds)
                ->where('is_paid', true)
                ->count();
            } else {
                $donaturs = Donatur::where('is_paid', true)
                ->count();
            }

            $fundraisings = $fundraisingQuery->count();
            $withdrawals = $withdrawalsQuery->count();
            $categories = Category::count();
            $fundraisers = Fundraiser::count();

            return view('dashboard', compact('donaturs', 'fundraisings', 'categories', 'withdrawals', 'fundraisers'));

        }

}

