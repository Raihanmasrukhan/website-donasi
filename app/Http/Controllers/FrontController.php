<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDonationRequest;
use App\Models\category;
use App\Models\Donatur;
use App\Models\fundraising;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    //
    public function index(){
        $categories = Category::all(); 
        
        $fundraisings = Fundraising::with(['category', 'fundraiser'])->where('is_active', 1)
        ->orderByDesc('id')
        ->get();


        return view('front.views.index', compact('categories', 'fundraisings'));
    }

    public function category(Category $category){
        return view('front.views.category', compact('category'));
    }

    public function details(Fundraising $fundraising){
        $goalReached = $fundraising->totalReachedAmount() >= $fundraising->target_amount;
        return view('front.views.details', compact('fundraising', 'goalReached'));
    }

    public function support(Fundraising $fundraising) {
        return view('front.views.donation', compact('fundraising'));
    }

    public function checkout(Fundraising $fundraising, $totalAmountDonation) {
        return view('front.views.checkout', compact('fundraising', 'totalAmountDonation'));
    }
    public function store(StoreDonationRequest $request, Fundraising $fundraising, $totalAmountDonation){
        DB::transsaction(function  () use ($request, $fundraising, $totalAmountDonation) {

            $validated = $request->validated();

            if($request->hasFile('proof')) {
                $proofPath = $request->file('proof')->store('proofs', 'public');
                $validated['proof'] = $proofPath;
            }

            $validated['fundraising_id'] = $fundraising->id;
            $validated['total_amount'] = $totalAmountDonation;
            $validated['is_paid'] = false;

            $donatur = Donatur::create($validated);
        });

        return redirect()->route('front.details', $fundraising->slug);

    }
}
