@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h3>Просмотр статистики и финансовых отчетов</h3>
                @if (Auth::user()->advertiser or Auth::user()->admin)
                <div class="card">
                    <div class="card-header">Для рекламодателя</div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <tbody>
                                {{-- <tr>
                                    <td>1.</td>
                                    <td><a href="{{route('reports.show', 1)}}">Подписка на оферы</a></td>
                                    <td>Колличестов подписок на офферы</td>
                                </tr> --}}
                                <tr>
                                    <td>1.</td>
                                    <td><a href="{{route('reports.show', 2)}}">Статистика переходов по целевым ссылкам</a></td>
                                    <td>Колличество запросов, отказов и подтверждений по целевым ссылкам в разрезе периодов, рекламодателей, офферов</td>
                                </tr>
                                <tr>
                                    <td>2.</td>
                                    <td><a href="{{route('reports.show', 3)}}">Расходы на привлечение клиентов</a></td>
                                    <td>Суммы, необходимые на оплату переходов по ссылкам офферов, в разрезе дней, недель, месяцев, лет</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
                <p> </p>
                @if (Auth::user()->webmaster or Auth::user()->admin)
                <div class="card">
                    <div class="card-header">Для Web-мастера</div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <td>1.</td>
                                    <td><a href="{{route('reports.show', 2)}}">Статистика переходов по целевым ссылкам</a></td>
                                    <td>Колличество запросов, отказов и подтверждений по целевым ссылкам в разрезе периодов, рекламодателей, офферов</td>
                                </tr>
                                <tr>
                                    <td>2.</td>
                                    <td><a href="{{route('reports.show', 4)}}">Доходы от подписок на офферы</a></td>
                                    <td>Суммы, причитающиеся за подтвержденные переходы клиентов по целевым ссылкам, в разрезе дней, недель, месяцев, лет</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    </div>
                @endif
                <p> </p>
                @if (Auth::user()->admin)
                <div class="card">
                    <div class="card-header">Для администратора</div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <td>1.</td>
                                    <td><a href="{{route('reports.show', 2)}}">Статистика переходов по целевым ссылкам</a></td>
                                    <td>Колличество запросов, отказов и подтверждений по целевым ссылкам в разрезе периодов, рекламодателей, офферов</td>
                                </tr>
                                <tr>
                                    <td>2.</td>
                                    <td><a href="{{route('reports.show', 5)}}">Доходы площадки</a></td>
                                    <td>Суммы, причитающиеся за привлечение клиентов на сайты рекламодателей, в разрезе дней, недель, месяцев, лет</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
                </div>
            </div>
        </div>
    </div>
@endsection
