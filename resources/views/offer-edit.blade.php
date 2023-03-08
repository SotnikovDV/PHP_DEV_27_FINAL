@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h3>@if ($edit == 1) Изменение @else Создание @endif предложения от @if($offer->advertiser) {{ $offer->advertiser->name }} @else {{Auth::user()->name}}@endif</h3>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form class="mt-2" method="POST" action="@if($edit == 1){{ route('offers.update', $offer) }}@else{{ route('offers.store', Auth::user()) }}@endif">@csrf
                <div class="mb-3">
                    <input type="text" class="form-control" id="name" name="name" maxlength="128" value="{{ $offer->name }}">
                    <label for="name" class="form-label">Название offer`а</label>
                </div>
                <div class="mb-3">
                    <textarea class="form-control" id="subjects" name="subjects" rows="3">{{ $offer->subjects }}</textarea>
                    <label for="subjects" class="form-label">Темы</label>
                </div>
                <div class="mb-3">
                    <textarea class="form-control" id="url" name="url" rows="2">{{ $offer->url }}</textarea>
                    <label for="url" class="form-label">Ссылка</label>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" id="price" name="price" maxlength="128" value="{{ $offer->price }}">
                    <label for="price" class="form-label">Цена</label>
                </div>
                <div class="mb-3">
                    <select id="active" name="active" class="form-select" required>
                        <option value="1" @if ($offer->active == 1) selected @endif>Доступно</option>
                        <option value="0" @if ($offer->active == 0) selected @endif>Недоступно</option>
                    </select>
                    <label for="active" class="form-label">Статус offer`а</label>
                </div>
                <input type="hidden" name="advertiser_id" value="@if($edit == 1) {{$offer->advertiser->id}} @else {{Auth::user()->id}} @endif">
                @if($edit == 1)<input type="hidden" name="_method" value="PATCH">@endif
                <button type="submit" class="btn btn-primary">Сохранить</button>
                <a type="button" class="btn btn-outline-secondary" href="{{ Redirect::back()->getTargetUrl() }}">Отмена</a>  {{-- route('users.index') --}}
            </form>
            @if($edit == 1)
            <form class="mt-2" action="{{ route('offers.destroy', $offer) }}" method="POST">@csrf
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="btn btn-outline-danger">Удалить</button>
            </form>
            @endif
        </div>
    </div>
</div>
@endsection
