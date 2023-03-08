@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <h3>Просмотр подписки на предложение {{ $subscribe->offer->id }} от
                    {{ $subscribe->offer->advertiser->name }} </h3>
                <div class="card my-4">
                    <div class="card-header">Принята: {{ date_format(date_create($subscribe->created_at), 'd.m.Y H:i:s') }}
                    </div>
                    <div class="card-body">
                        {{-- <h5 class="card-title">{{ $offer->advertiser->name }}</h5>
                <h6 class="card-subtitle mb-2 text-muted">{{ $offer->advertiser->name }}</h6> --}}
                        <dl class="row">
                            <dt class="col-sm-4">ID подписки</dt>
                            <dd class="col-sm-8">{{ $subscribe->id }}</dd>
                            <dt class="col-sm-4">Web-мастер</dt>
                            <dd class="col-sm-8">{{ $subscribe->webmaster->name }}</dd>
                            <dt class="col-sm-4">ID предложения</dt>
                            <dd class="col-sm-8"><a
                                    href="{{ route('offers.show', $subscribe->offer) }}">{{ $subscribe->offer->id }}</a>
                            </dd>
                            <dt class="col-sm-4">Имя offer`а</dt>
                            <dd class="col-sm-8">{{ $subscribe->offer->name }}</dd>
                            <dt class="col-sm-4">Цена перехода</dt>
                            <dd class="col-sm-8">{{ $subscribe->offer->price }}</dd>
                            <dt class="col-sm-4">Рекламодатель</dt>
                            {{-- <dd class="col-sm-8"><a href="{{ route('users.show', $subscribe->offer->advertiser) }}">{{ $subscribe->offer->advertiser->name }}</a></dd> --}}
                            <dd class="col-sm-8">{{ $subscribe->offer->advertiser->name }}</dd>
                            <dt class="col-sm-4">Тема</dt>
                            <dd class="col-sm-8">{{ $subscribe->offer->subjects }}</dd>
                            <dt class="col-sm-4">Ссылка для сайта</dt>
                            <dd class="col-sm-8"><a id="go_url" href="javascript:copyToClipboard('{{ $subscribe->go_url() }}')" //"{{ $subscribe->go_url() }}"
                                    {{-- target="_blank" --}}>{{ $subscribe->go_url() }}</a></dd>
                            <dt class="col-sm-4">Статус предложения</dt>
                            <dd class="col-sm-8">
                                @if ($subscribe->offer->active)
                                    Доступно
                                @else
                                    Недоступно
                                @endif
                            </dd>
                        </dl>
                    </div>
                    <div class="card-footer">
                        {{-- <a type="button" class="btn btn-outline-primary" href="{{ route('subscribes.destroy', $subscribe) }}">Отписаться</a> --}}
                        <form class="mt-2" action="{{ route('subscribes.destroy', $subscribe) }}" method="POST">@csrf
                            @if (Auth::user()->webmaster || Auth::user()->admin)
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-outline-danger">Отписаться</button>
                            @endif
                            <a type="button" class="btn btn-outline-secondary"
                                href="{{ Redirect::back()->getTargetUrl() }}">Отмена</a>
                            <a type="button" class="btn btn-outline-info"
                                href="{{ route('subscribes.index', $subscribe->webmaster) }}">Ещё подписки</a>
                        </form>
                        {{-- <a type="button" class="btn btn-outline-info" href="{{ route('users.show', $offer->advertiser) }}">Рекламодатель</a> --}}
                    </div>
                </div>
            </div>
        </div>
        <script>
            // функция на javascript для копирования ссылки в буфер обмена
            function copyToClipboard(text) {
                const textarea = document.createElement("textarea");
                textarea.value = text;
                document.body.appendChild(textarea);
                textarea.select();
                document.execCommand("copy");
                document.body.removeChild(textarea);
                alert('Ссылка < ' + text + ' > скопирована в буфер обмена');
                }
        </script>
    @endsection
