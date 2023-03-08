@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h3>Просмотр предложений @if($advertiser){{ $advertiser->name }}@endif</h3>
         @if($advertiser)
         <a type="button" class="btn btn-outline-primary" href="{{ route('offers.index') }}">Все предложения</a>
            @if(Auth::user()->advertiser && $advertiser->id == Auth::user()->id)
                <a type="button" class="btn btn-outline-primary my-8" href="{{ route('users.offers.create', $advertiser) }}">Добавить предложение</a>
            @endif
         @elseif (Auth::user()->advertiser) <a type="button" class="btn btn-outline-primary my-8" href="{{ route('offers.create') }}">Новое предложение</a> @endif
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Рекламодатель</th>
                    <th>Наименование</th>
                    <th>Темы</th>
                    <th>Цена</th>
                    <th>Статус</th>
                    <th>Переходы</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($offers as $offer)
                <tr>
                    <td><a href="{{ route('offers.show', $offer) }}">{{ $offer->id }}</a></td>
                    <td><a href="{{ route('users.offers.index', $offer->advertiser) }}">{{ $offer->advertiser->name }}</a></td>
                    <td>{{ $offer->name }}</td>
                    <td>{{ $offer->subjects }}</td>
                    <td>{{ $offer->price }}</td>
                    <td>@if($offer->active)Доступно @else Не доступно @endif</td>
                    <td><a href="/offers/redirs/{{$offer->id}}">смотреть</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @if (count($offers) > 0) {{ $offers->links() }} @else Нет заявок @endif
        </div>
    </div>
</div>
@endsection
