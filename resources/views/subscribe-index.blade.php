@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h3>Подписка на предложение @if($offer){{ $offer->name }}@endif</h3>
         {{-- @if($advertiser)
         <a type="button" class="btn btn-outline-primary" href="{{ route('offers.index') }}">Все предложения</a>
            @if($advertiser->id == Auth::user()->id)
                <a type="button" class="btn btn-outline-primary my-8" href="{{ route('users.offers.create', $advertiser) }}">Добавить предложение</a>
            @endif
         @else <a type="button" class="btn btn-outline-primary my-8" href="{{ route('offers.create') }}">Новое предложение</a> @endif --}}
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Web-мастер</th>
                    <th>Рекламодатель</th>
                    <th>Наименование</th>
                    <th>Цена</th>
                    <th>Статус</th>
                    <th>Переходы</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subscribes as $subscribe)
                <tr>
                    <td><a href="{{ route('subscribes.show', $subscribe) }}">{{ $subscribe->id }}</a></td>
                    <td><a href="{{ route('subscribes.index', $subscribe->webmaster) }}">{{ $subscribe->webmaster->name }}</a></td>
                    {{-- <td><a href="{{ route('users.offers.index', $subscribe->offer) }}">{{ $subscribe->offer->advertiser->name }}</a></td> --}}
                    <td>{{ $subscribe->offer->advertiser->name }}</td>
                    <td>{{ $subscribe->offer->name }}</td>
                    <td>{{ $subscribe->offer->price }}</td>
                    <td>@if($subscribe->offer->active)Доступно @else Не доступно @endif</td>
                    <td><a href="/subscribes/redirs/{{$subscribe->id}}">смотреть</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <a type="button" class="btn btn-outline-info" href="{{route('test')}}">Тестирование ссылок</a>
        <a type="button" class="btn btn-outline-secondary" href="{{ Redirect::back()->getTargetUrl() }}">Отмена</a>

        @if (count($subscribes) > 0) {{ $subscribes->links() }} @else Нет заявок @endif
        </div>
    </div>
</div>
@endsection
