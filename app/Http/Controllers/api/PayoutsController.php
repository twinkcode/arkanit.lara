<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePayoutRequest;
use App\Http\Requests\UpdatePayoutRequest;
use App\Http\Resources\PayoutsResource;
use App\Models\Payouts;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PayoutsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return PayoutsResource::collection(
            Payouts::with('user')
                ->paginate(
                    $perPage = $request->input('itemsPerPage', 3),
                    $columns = ['*'],
                    $pageName = 'page',
                    $page = $request->input('page', 1),
                ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePayoutRequest $request): string
    {
        $validated = $request->validated();
        if (!$validated) abort(500,'request no valid');
        $newPayout = Payouts::query()->create($validated);
        return $newPayout;

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePayoutRequest $request, string $id) : Payouts
    {
        $validated = $request->validated();
        if (!$validated) abort(500,'request no valid');

        $payoutRecord = Payouts::find($id);
        $payoutRecord->update(['status'=>$request->input('status')]);
//        $payoutRecord->update(['status'=>!$payoutRecord->status]);
        $payoutRecord->save();
        return Payouts::find($id)->with('user')->first();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        //
    }
}
