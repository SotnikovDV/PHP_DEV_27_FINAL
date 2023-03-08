<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreOfferRequest;
use App\Http\Requests\UpdateOfferRequest;
use App\Models\Offer;
use Symfony\Component\Console\Input\Input;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            return view('offer-index', ['advertiser' => false, 'offers' => Offer::orderByDesc('id')->paginate(20)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('offer-edit', ['edit' => 0, 'offer' => new Offer()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOfferRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOfferRequest $request)
    {
        $validated = $request->validated();
        $offer = new Offer();
        $offer->fill($validated);

        /* $offer->name = $validated['name'];
        $offer->subjects = $validated['email'];
        if (strlen($validated['password']) > 7)
        {
            $user->password = Hash::make($validated['password']);
        }
        $user->access_level = $validated['access_level'];
        $user->advertiser = $request['advertiser'] || 0; //$validated['advertiser'];
        $user->webmaster = $request['webmaster'] || 0; //$validated['webmaster'];
        $user->admin = $request['admin'] || 0; //$validated['admin']; */
        $offer->save();
        return redirect()->route('offers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function show(Offer $offer)
    {
        return view('offer-show', ['offer' => $offer]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function edit(Offer $offer)
    {
        return view('offer-edit', ['edit' => 1, 'offer' => $offer]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOfferRequest  $request
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOfferRequest $request, Offer $offer)
    {
        $validated = $request->validated();
        if (Auth::user()->access_level == 2) {
            $offer->fill($validated);
        }
        //$offer->advertiser_id = Auth::id();
        $offer->save();
        return redirect()->route('offers.show', $offer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Offer $offer)
    {
        if ((Auth::user()->access_level == 2) && (Auth::user()->advertiser || Auth::user()->admin)) {
            $advertiser_id = $offer->advertiser->id;
            $offer->delete();
            return redirect()->route('advertiser.offer.index', $advertiser_id);
        } else {
            return null;
        }
    }
}
