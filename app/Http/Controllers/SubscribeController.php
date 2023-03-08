<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreSubscribeRequest;
use App\Http\Requests\UpdateSubscribeRequest;
use App\Models\Offer;
use App\Models\Subscribe;

class SubscribeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('subscribe-index', ['offer' => false, 'subscribes' => Subscribe::LimitAL()->orderByDesc('id')->paginate(10)]);
    }
    // тестирование получения рекламной ссылки и подтверждения перехода по ней
    public function test()
    {
        return view('test', ['subscribes' => Subscribe::LimitAL()->orderByDesc('id')->paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return null;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSubscribeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubscribeRequest $request)
    {
        return null;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subscribe  $subscribe
     * @return \Illuminate\Http\Response
     */
    public function show(Subscribe $subscribe)
    {
        return view('subscribe-show', ['subscribe' => $subscribe]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subscribe  $subscribe
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscribe $subscribe)
    {
        return view('subscribe-edit', ['edit' => 1, 'subscribe' => $subscribe]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSubscribeRequest  $request
     * @param  \App\Models\Subscribe  $subscribe
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubscribeRequest $request, Subscribe $subscribe)
    {
        $validated = $request->validated();
        $subscribe->fill($validated);
        $subscribe->webmaster_id = Auth::id();
        $subscribe->save();
        return redirect()->route('subscribe.show', $subscribe);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subscribe  $subscribe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscribe $subscribe)
    {
        $webmaster_id = $subscribe->webmaster->id;

        if ((Auth::user()->access_level == 2) && ((Auth::user()->webmaster && (Auth::user()->id == $webmaster_id)) || Auth::user()->admin) ) {
            $subscribe->delete();
            return redirect()->route('subscribes.index', $webmaster_id);
        } else {
            return null;
        }
    }
}
