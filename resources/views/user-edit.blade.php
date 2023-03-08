@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h3>@if ($edit == 1) Профиль @else Создание @endif пользователя</h3>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form class="mt-2 d-inline" method="POST" action="@if($edit == 1){{ route('users.update', $user) }}@else{{ route('users.store') }}@endif">@csrf
                <div class="mb-3">
                    <input type="text" class="form-control" id="name" name="name" maxlength="255" value="{{ $user->name }}" required>
                    <label for="name" class="form-label">Имя</label>
                </div>
                <div class="mb-3">
                    <input type="email" class="form-control" id="email" name="email" maxlength="255" value="{{ $user->email }}" required>
                    <label for="email" class="form-label">E-mail</label>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" id="password" name="password" maxlength="255" @if($edit == 0) required @endif>
                    <label for="password" class="form-label">Пароль</label>
                </div>
                {{-- @if(Auth::user()->admin) --}}
                <div class="mb-3">
                    <select id="access_level" name="access_level" class="form-select"  @if(!Auth::user()->admin) disabled @endif required>
                        <option value="0" @if ($user->access_level == 0) selected @endif>Нет доступа</option>
                        <option value="1" @if ($user->access_level == 1) selected @endif>Только чтение</option>
                        <option value="2" @if ($user->access_level == 2) selected @endif>Исправление</option>
                    </select>
                    <label for="access_level" class="form-label">Уровень доступа</label>
                </div>
                {{-- @endif --}}
                <div class="form-group border rounded p-3 mb-3">
                <div class="mb-3">
                    <input type="checkbox" class="form-check-input" id="advertiser" name="advertiser" value="1" @if ($user->advertiser) checked @endif>
                    <label for="advertiser" class="form-label">Рекламодатель</label>
                </div>
                <div class="mb-3">
                    <input type="checkbox" class="form-check-input" id="webmaster" name="webmaster" value="1" @if ($user->webmaster) checked @endif>
                    <label for="webmaster" class="form-label">Web-мастер</label>
                </div>
                @if(Auth::user()->admin)
                <div class="mb-1">
                    <input type="checkbox" class="form-check-input" id="admin" name="admin" value="1" @if ($user->admin) checked @endif>
                    <label for="admin" class="form-label">Администратор</label>
                </div>
                @endif
                </div>
                <div class="form-group border rounded p-3 mb-3">
                    <label for="token_group" class="form-label">Токен для API-запросов</label>
                    <div class="input-group mb-3" id="token_group" name="token_group">
                        <input type="text" id="token" name="token"  class="form-control" placeholder="Нажмите кнопку [Получить], что бы сгенерировать токен " aria-label="Токен для API-запросов" aria-describedby="get_token">
                        <button class="btn btn-outline-secondary" type="button" id="get_token" onclick="getToken()">Получить</button>
                        <button class="btn btn-outline-secondary" type="button" id="copy_token" onclick="tokenToClipboard()">Копировать</button>
                    </div>

                </div>
                @if($edit == 1)<input type="hidden" name="_method" value="PATCH">@endif
                <button type="submit" class="btn btn-primary">Сохранить</button>
                <a type="button" class="btn btn-outline-secondary" href="{{ Redirect::back()->getTargetUrl() }}">Отмена</a>
            </form>
            @if($edit == 1)
            <form class="mt-2 d-inline" action="{{ route('users.destroy', $user) }}" method="POST">@csrf
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="btn btn-outline-danger">Удалить</button>
            </form>
            @endif
        </div>
    </div>
</div>
<script>
// функция получения токена
function getToken() {
    const url = '/token/create';
    const instance = axios.create({
        baseURL: url
    });
    instance.get('/')
        .then(response => {
            var token = response.data;
            elem = document.querySelector('#token');
            elem.value = token;
        })
        .catch(error => {
            console.error(error);
            var token = error;
        });
}
// функция копирования токена в буфер обмена
function tokenToClipboard(){
    text = document.querySelector('#token');
    text.select();
    document.execCommand("copy");
}
</script>
@endsection
