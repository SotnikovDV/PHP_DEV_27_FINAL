@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h3>Просмотр переходов @if($offer)по офферу {{ $offer->name }}@endif @if($subscribe)по подписке {{ $subscribe->webmaster->name}} на оффер {{ $subscribe->offer->name }}@endif</h3>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Наименование</th>
                    <th>Рекламодатель</th>
                    <th>Web-мастер</th>
                    <th>Дата</th>
                    <th>Ссылка выдана</th>
                    <th>Подтвержден</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($redirs as $redir)
                <tr>
                    <td class="text-center">{{ $redir->id }}</td>
                    <td><a href="{{ route('offers.index', $redir->offer->id) }}">{{ $redir->offer->name }}</a></td>
                    <td>{{ $redir->offer->advertiser->name }}</td>
                    <td>{{ $redir->webmaster->name }}</td>
                    <td class="text-center">{{ $redir->created_at }}</td>
                    <td class="text-center">@if($redir->accept) ДА @else НЕТ @endif</td>
                    <td class="text-center">@if($redir->success) ДА @else <a href="javascript:success({{$redir->id}})">НЕТ</a> @endif</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-inline">
            @if (count($redirs) > 0) {{ $redirs->links() }} @else Нет переходов] @endif
            <a type="button" class="btn btn-outline-secondary d-inline" href="{{ Redirect::back()->getTargetUrl() }}">Отмена</a>
        </div>
        </div>
    </div>
</div>
<script>
    // функция подтверждения перехода
    function success(id) {
            //const url = '/redirs/success/'+id;
            const url = '/api/success/'+id;
            const instance = axios.create({
                baseURL: url,
                headers: {
                    'Authorization': `Bearer 72|7jR8UIgPKUTG9QVB78PNiEjTxP6jxmunm5Ldxtyr`,
                    'Content-Type': 'application/json'
                }
            });
            instance.get('/')
                .then(response => {
                    //var token = response.data; //$(this).attr('href');
                    //let elem = document.querySelector('#token');
                    //elem.value = token;
                    location.reload();
                })
                .catch(error => {
                    console.error(error);
                    //var token = error;
                });
        }

</script>
@endsection
