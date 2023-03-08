@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h3>{{ $title }}</h3>
            <h4>Отчеты</h4>
            <form class="mt-2 d-inline" method="POST" action="{{ route('reports.show', $id) }}">@csrf
                <div class="input-group mb-3">
                    <span class="input-group-text" id="gr_type_lb">Группировка</span>
                    <select id="gr_type" name="gr_type" class="form-select" required>
                        <option value="0" @if ($gr_type == 0) selected @endif>Период</option>
                        <option value="1" @if ($gr_type == 1) selected @endif>Период, Рекламодатель</option>
                        <option value="2" @if ($gr_type == 2) selected @endif>Период, Оффер</option>
                    </select>
                    <span class="input-group-text" id="per_type_lb">Суммы по</span>
                    <select id="per_type" name="per_type" class="form-select" required>
                        <option value="1" @if ($per_type == 1) selected @endif>Дням</option>
                        <option value="2" @if ($per_type == 2) selected @endif>Неделям</option>
                        <option value="3" @if ($per_type == 3) selected @endif>Месяцам</option>
                        <option value="4" @if ($per_type == 4) selected @endif>Годам</option>
                    </select>
                    <span class="input-group-text" id="per_type_lb">Период с:</span>
                    <input type="date" class="form-control" id="date_beg" name="date_beg" value="{{$date_beg}}" required>
                    <span class="input-group-text" id="per_type_lb">По:</span>
                    <input type="date" class="form-control" id="date_end" name="date_end" value="{{$date_end}}" required>
                <button type="submit" class="btn btn-primary">Перестроить</button>
                </div>
        </form>
        <?php
            $money_sum = 0;
            $redir_count = 0;
            $accept_count = 0;
            $success_count = 0;
         ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    @if(($gr_type > 0))
                    <th class="text-center">Рекламодатель</th>
                    @endif
                    @if(($gr_type == 2))
                    <th class="text-center">Оффер ID</th>
                    @endif
                    <th class="text-center">Период</th>
                    @if(($gr_type == 2))
                    <th class="text-center">Цена</th>
                    @endif
                    @if($id == 2)
                    <th class="text-center">Запросов ссылки</th>
                    <th class="text-center">Акцептовано запросов</th>
                    @endif
                    <th class="text-center">Подтверждено переходов</th>
                    @if($id > 2)
                        <th class="text-center">Сумма @switch($id)
                        @case(3)затрат@break
                        @case(4)доходов от подписки@break
                        @case(5)доходов площадки@break
                        @default ?
                        @endswitch
                        </th>
                    @endif
                </tr>
            </thead>
            <tbody>
                 @foreach ($reports as $report)
                 <?php
                    $money_sum = $money_sum + $report->money_sum;
                    $redir_count = $redir_count + $report->redir_count;
                    $accept_count = $accept_count + $report->accept_count;
                    $success_count = $success_count + $report->success_count;
                 ?>
                <tr>
                    @if(($gr_type > 0))
                    <td>{{$report->advertiser_name}}</td>
                    @endif
                    @if(($gr_type == 2))
                    <td>{{$report->offer_name}}</td>
                    @endif
                    <td class="text-center">{{$report->period}}</td>
                    @if(($gr_type == 2))
                    <td class="text-center">{{$report->price}}</td>
                    @endif
                    @if($id == 2)
                    <td class="text-center">{{$report->redir_count}}</td>
                    <td class="text-center">{{$report->accept_count}}</td>
                    @endif
                    <td class="text-center">{{$report->success_count}}</td>
                    @if($id > 2)
                    <td class="text-center">{{$report->money_sum}}</td>
                    @endif
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="table-secondary">
                    {{-- @if(($gr_type > 0))
                    <th></th>
                    @endif
                    @if(($gr_type == 2))
                    <th></th>
                    @endif --}}
                    <th class="text-left" @if($gr_type > 0)colspan="{{$gr_type+1}}"@endif>ИТОГО:</th>
                    @if(($gr_type == 2))
                    <th class="text-center"></th>
                    @endif
                    @if($id == 2)
                    <th class="text-center">{{$redir_count}}</th>
                    <th class="text-center">{{$accept_count}}</th>
                    @endif
                    <th class="text-center">{{$success_count}}</th>
                    @if($id > 2)
                    <th class="text-center">{{$money_sum}}</th>
                    @endif
                </tr>
            </tfoot>
        </table>

        </div>
        <div class="d-inline">
            {{-- @if (Auth::user()->advertiser or Auth::user()->admin)
            <a type="button" class="btn btn-outline-secondary" href="{{route('reports.show', 1)}}">Подписка на оферы</a>
            @endif --}}
            <a type="button" class="btn btn-outline-secondary" href="{{route('reports.show', 2)}}">Статистика переходов</a>
            @if (Auth::user()->advertiser or Auth::user()->admin)
            <a type="button" class="btn btn-outline-secondary" href="{{route('reports.show', 3)}}">Расходы на рекламу</a>
            @endif
            @if (Auth::user()->webmaster or Auth::user()->admin)
            <a type="button" class="btn btn-outline-secondary" href="{{route('reports.show', 4)}}">Доходы от подписок</a>
            @endif
            @if (Auth::user()->admin)
            <a type="button" class="btn btn-outline-secondary" href="{{route('reports.show', 5)}}">Доходы площадки</a>
            @endif
        </div>
    </div>
    @if ($gr_type == 0 && $id > 2)
    <div class="row justify-content-center">
        <canvas id="data-chart"></canvas>
    </div>
    <script>
        var ctx = document.getElementById('data-chart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: '{{ $title }}',
                    data: [],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
             options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        fetch('{{route('charts.data', $id)}}')
            .then(response => response.json())
            .then(data => {
                chart.data.labels = data.labels;
                chart.data.datasets[0].data = data.data;
                //console.log(data.data);
                chart.update();
            });
    </script>
    @endif
</div>
@endsection
