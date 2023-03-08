@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                        <div class="jumbotron">
                          <h1 class="display-4">Размещение интернет-рекламы</h1>
                          <p class="lead">Мы предоставляем услуги по размещению интернет-рекламы на различных площадках.</p>
                          <hr class="my-4">
                          <p>Мы гарантируем высокое качество рекламных услуг и эффективность вашей рекламной кампании.</p>
                          <a class="btn btn-primary btn-lg" href="#" role="button">Узнать больше</a>
                        </div>
                    <hr>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
