@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h3>Просмотр предложения {{ $offer->id }} от {{ $offer->advertiser->name }} </h3>
            <div class="card my-4">
            <div class="card-header">{{ $offer->active }}. Создано: {{ date_format(date_create($offer->created_at), 'd.m.Y H:i:s') }}, изменёно {{ date_format(date_create($offer->updated_at), 'd.m.Y H:i:s') }} </div>
            <div class="card-body">
                {{-- <h5 class="card-title">{{ $offer->advertiser->name }}</h5>
                <h6 class="card-subtitle mb-2 text-muted">{{ $offer->advertiser->name }}</h6> --}}
                <dl class="row">
                    <dt class="col-sm-4">ID offer`а</dt>
                    <dd class="col-sm-8">{{ $offer->id }}</dd>
                    <dt class="col-sm-4">Название offer`а</dt>
                    <dd class="col-sm-8">{{ $offer->name }}</dd>
                    <dt class="col-sm-4">Темы</dt>
                    <dd class="col-sm-8">{{ $offer->subjects }}</dd>
                    <dt class="col-sm-4">Ссылка</dt>
                    <dd class="col-sm-8"><a href="{{ $offer->url }}" target="_blank">{{ $offer->url }}</a></dd>
                    <dt class="col-sm-4">Статус предложения</dt>
                    <dd class="col-sm-8">@if($offer->active) Доступно @else Недоступно @endif</dd>
                    <dt class="col-sm-4">Рекламодатель</dt>
                    <dd class="col-sm-8"><a href="{{ route('users.show', $offer->advertiser) }}">{{ $offer->advertiser->name }}</a></dd>
                </dl>
                <p class="card-text">{{ $offer->subject }}</p>
            </div>
            <div class="card-footer">
                @if((Auth::user()->access_level > 1) && ((Auth::user()->id == $offer->advertiser->id) || Auth::user()->admin))
                <a type="button" class="btn btn-outline-primary" href="{{ route('offers.edit', $offer->id) }}">Изменить</a>
                @endif
                @if((Auth::user()->webmaster || Auth::user()->admin))
                <a type="button" class="btn btn-outline-primary" href="{{ route('offers.subscribes.create', $offer) }}">Подписаться</a>
                @endif
                <a type="button" class="btn btn-outline-secondary" href="{{ Redirect::back()->getTargetUrl(); }}">Отмена</a>
                <a type="button" class="btn btn-outline-info" href="{{ route('users.offers.index', $offer->advertiser) }}">Ещё предложения</a>
                <a type="button" class="btn btn-outline-info" href="{{ route('offers.subscribes.index', $offer) }}">Подписки на предложение</a>
                {{-- <a type="button" class="btn btn-outline-info" href="{{ route('users.show', $offer->advertiser) }}">Рекламодатель</a> --}}
            </div>
        </div>
    </div>
</div>
@endsection
