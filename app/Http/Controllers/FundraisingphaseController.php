<?php

namespace App\Http\Controllers;

use App\Models\fundraisingphase;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFundraisingPhaseRequest;
use App\Http\Requests\StoreFundraisingRequest;
use App\Models\fundraising;
use App\Models\fundraisingWithdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FundraisingphaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFundraisingPhaseRequest $request, Fundraising $fundraising)
    {
        //
        DB::transaction(function () use ($request, $fundraising) {

            $validated = $request->validated();

            if($request->hasFile('photo')){
                $photoPath = $request->file('photo')->store('photos', 'public');
                $validated['photo'] = $photoPath;
            }

            $validated['fundraising_id'] = $fundraising->id;
            
            $fundraisingphase = FundraisingPhase::create($validated);

            $withdrawalToUpdate = FundraisingWithdrawal::where('fundraising_id', $fundraising->id)
            ->latest()
            ->first();

            $withdrawalToUpdate->update([
                'has_received' => true
            ]);
            $fundraising->update([
                'has_received' => true
            ]);
        });

        return redirect()->route('admin.my_withdrawals');

    }

    /**
     * Display the specified resource.
     */
    public function show(fundraisingphase $fundraisingphase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(fundraisingphase $fundraisingphase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, fundraisingphase $fundraisingphase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(fundraisingphase $fundraisingphase)
    {
        //
    }
}
