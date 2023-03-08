@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Тестирование рекламных ссылок для {{ Auth::user()->name }}</div>

                    <div class="card-body">
                        <label for="test-form" class="form-label">Авторизация через токен</label>
                        <div class="form-group border rounded p-3 mb-3" id="test-form">
                            <label for="token_group" class="form-label">Токен для API-запросов</label>
                            <div class="input-group mb-3" id="token_group" name="token_group">
                                <input type="text" id="token" name="token" class="form-control"
                                    placeholder="Нажмите кнопку [Получить], что бы сгенерировать токен "
                                    aria-label="Токен для API-запросов" aria-describedby="get_token">
                                <button class="btn btn-outline-primary" type="button" id="get_token"
                                    onclick="getToken()">Получить</button>
                                <button class="btn btn-outline-secondary" type="button" id="copy_token"
                                    onclick="tokenToClipboard()">Копировать</button>
                            </div>

                        </div>
                        <label for="subscribe-list" class="form-label">Ваши подписки на offer`s</label>
                        <div class="form-group border rounded p-3 mb-3" id="subscribe-list">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Рекламодатель</th>
                                    <th>Наименование</th>
                                    <th>Web-мастер</th>
                                    <th>Цена</th>
                                    <th>Статус</th>
                                    <th>Переходы</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subscribes as $subscribe)
                                <tr>
                                    <td><a href="javascript:go({{ $subscribe->id }})">{{ $subscribe->id }}</a></td>
                                    <td>{{ $subscribe->offer->advertiser->name }}</td>
                                    <td>{{ $subscribe->offer->name }}</td>
                                    <td>{{ $subscribe->webmaster->name }}</td>
                                    <td>{{ $subscribe->offer->price }}</td>
                                    <td>@if($subscribe->offer->active)Доступно @else Не доступно @endif</td>
                                    <td><a href="/subscribes/redirs/{{$subscribe->id}}">смотреть</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <a href="javascript:go(61)">Ссылка на оффер без подписки</a>
                    </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        //import axios from 'axios';

        // Задайте параметры запроса
        //const url1 = 'http://localhost:82/api/go/';
        //const token = '33|hQYmL509bC5muyxqduKmoGrZvGda2Y6mQWMrKL5N';

        // функция для перехода по ссылке на рекламу
        function go(id) {
            let url = "{{route('go',0)}}".slice(0, -1) + id;
            let token = getToken(go, id);
            if (!token) {
                return;
            }

            axios.defaults.withCredentials = true;
            const instance = axios.create({
                baseURL: url,
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });
            instance.get('/')
                .then(response => {
                    console.log(response.data);
                    var href = response.data;
                    window.open(href, '_blank').focus();
                })
                .catch(error => {
                    //console.error(error);
                    alert(error);
                });
        }
        // функция генерации токена
        function createToken() {
            const url = '/token/create';
            const instance = axios.create({
                baseURL: url
            });
            instance.get('/')
                .then(response => {
                    var token = response.data; //$(this).attr('href');
                    let elem = document.querySelector('#token');
                    elem.value = token;
                })
                .catch(error => {
                    console.error(error);
                    var token = error;
                });
        }
        // функция возвращает токен пользователя из поля "Токен". Если его нет - генерирует новый и повторно вызывает функцию перехода по ссылке
        function getToken(func, id) {
            let elem = document.querySelector('#token');
            let token = elem.value;
            if (!token){
                console.log('Токен не указан. Пробую получить');
                createToken();
                setTimeout(func /* go */, 1000, id)
                return;
            } else {
                return token;
            }
        }
        // функция копирования токена в буфер обмена
        function tokenToClipboard() {
            let text = document.querySelector('#token');
            text.select();
            document.execCommand("copy");
        }
/*
              function go1(id) {
                    let url = "{{route('go',0)}}".slice(0, -1) + id;
                    let token = getToken(go1, id);
                    if (!token) {
                        return;
                    }
                    const headers = {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json'
                    };
                    // Отправляем запрос на сервер с заголовком Authorization
                    fetch(url,
                            headers
                        )
                        .then(response => {
                            if (!response.ok) {
                                console.log('Ошибка аутентификации');
                                //throw new Error('Ошибка аутентификации');
                            }
                            //return response.json();
                            console.log('1');
                            console.log(response.data);
                            var href = response.data;
                            window.open(href, '_blank').focus();
                        })
                        .then(data => {
                            // Данные авторизованного пользователя
                            console.log('2');
                            console.log(data);
                            var href = data;
                            window.open(href, '_blank').focus();
                        })
                        .catch(error => {
                            // Обрабатываем ошибку аутентификации
                            //console.error(error);
                            alert(error);
                        });
                }

                function testToken3() {

                    // Отправляем запрос на сервер с заголовком Authorization
                    fetch(url2, headers)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Ошибка аутентификации');
                            }
                            return response.json();
                        })
                        .then(data => {
                            // Данные авторизованного пользователя
                            console.log(data);
                        })
                        .catch(error => {
                            // Обрабатываем ошибку аутентификации
                            console.error(error);
                        });
                }
         */
    </script>
@endsection
