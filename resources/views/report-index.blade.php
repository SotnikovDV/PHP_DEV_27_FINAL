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
                        <table class="table table-striped">
                            <tbody>
                                {{-- <tr>
                                    <td>1.</td>
                                    <td><a href="{{route('reports.show', 1)}}">Подписка на оферы</a></td>
                                    <td>Колличестов подписок на офферы</td>
                                </tr> --}}
                                <tr>
                                    <td>1.</td>
                                    <td><a href="{{route('reports.show', 2)}}">Статистика переходов и подтверждений по ссылка</a></td>
                                    <td>Колличество переходов по ссылка офферов в разрезе дня, месяца, года</td>
                                </tr>
                                <tr>
                                    <td>2.</td>
                                    <td><a href="{{route('reports.show', 3)}}">Расходы на оплату переходов</a></td>
                                    <td>Суммы, необходимые на оплату привлечения клиентов, в разрезе дня, месяца, года</td>
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
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <td>1.</td>
                                    <td><a href="{{route('reports.show', 2)}}">Статистика переходов, отказов и подтверждений по ссылка</a></td>
                                    <td>Колличество переходов по ссылка офферов в разрезе дня, месяца, года</td>
                                </tr>
                                <tr>
                                    <td>2.</td>
                                    <td><a href="{{route('reports.show', 4)}}">Доходы от подписок</a></td>
                                    <td>Суммы, причитающиеся за переходы клиентов по ссылкам, в разрезе дня, месяца, года</td>
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
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <td>1.</td>
                                    <td><a href="{{route('reports.show', 2)}}">Статистика переходов, отказов и подтверждений по ссылка</a></td>
                                    <td>Колличество переходов по ссылка офферов в разрезе дня, месяца, года</td>
                                </tr>
                                <tr>
                                    <td>2.</td>
                                    <td><a href="{{route('reports.show', 5)}}">Доходы площадки</a></td>
                                    <td>Суммы, причитающиеся за переходы клиентов по ссылкам, в разрезе дня, месяца, года</td>
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
