<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Offer;
use App\Http\Requests\StoreOfferRequest;
use App\Http\Requests\UpdateOfferRequest;


class UserOfferController extends Controller
{
    public function index(User $user)
    {
        
        return view('offer-index', ['advertiser' => $user, 'offers' => Offer::where(['advertiser_id' => $user->id])->orderByDesc('id')->paginate(10)]);
    }

    public function create(User $user)
    {
        return view('offer-edit', ['edit' => 0, 'offer' => new Offer(['advertiser_id' => $user->id])]);
    }

    public function store(StoreOfferRequest $request, User $advertiser)
    {
        $validated = $request->validated();
        $offer = new Offer(['advertiser_id' => $advertiser->id]);
        $offer->fill($validated);
        $offer->save();
        return redirect()->route('offers.show', $offer);
    }
}
