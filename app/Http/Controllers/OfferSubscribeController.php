<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Offer;
use App\Models\Subscribe;
use App\Http\Requests\StoreSubscribeRequest;
use App\Http\Requests\UpdateSubscribeRequest;



class OfferSubscribeController extends Controller
{
    public function index(Offer $offer)
    {

        return view('subscribe-index', ['offer' => $offer, 'subscribes' => Subscribe::LimitAL()->where(['offer_id' => $offer->id])->orderByDesc('id')->paginate(10)]);
    }

    public function create(Offer $offer)
    {
        //return view('subscribe-edit', ['edit' => 0, 'subscribe' => new Subscribe(['offer_id' => $offer->id])]);
        $subscribe = new Subscribe();
        $subscribe->offer_id = $offer->id;
        $subscribe->webmaster_id = Auth::id();
        $subscribe->save();
        return redirect()->route('offers.index');
    }
    public function update(UpdateSubscribeRequest $request, Offer $offer)
    {
        $subscribe = new Subscribe();
        $subscribe->offer_id = $offer->id;
        $subscribe->webmaster_id = Auth::id();
        $subscribe->save();
        return redirect()->route('offers.index');
    }

    public function store(StoreSubscribeRequest $request, Offer $offer)
    {
        $validated = $request->validated();
        $subscribe = new Subscribe(['offer_id' => $offer->id]);
        $offer->fill($validated);
        $offer->save();
        return redirect()->route('offers.show', $offer);
    }
}
