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
                          <p class="lead">Мы предоставляем услуги рекламодателям по размещению интернет-рекламы на различных площадках.</p>
                          <p class="lead">Мы предоставляем web-мастерам возможности дополнительного заработка от размещения интернет-рекламы на своих ресурсах.</p>
                          <hr class="my-4">
                          <p class="lead">Мы гарантируем высокое качество рекламных услуг и эффективность вашей рекламной кампании.</p>
                          <p class="text-center">
                          <a class="btn btn-outline-secondary btn-lg" href="https://github.com/SotnikovDV/PHP_DEV_27_FINAL/blob/main/description.md" target="_blank" role="button">Узнать больше</a>
                          </p>
                        </div>
                    <hr>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <p class="text-center">
                    {{ __('You are logged in!') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
