<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Requests\StoreOfferRequest;
use App\Http\Requests\UpdateOfferRequest;
use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\Redir;
use App\Models\Report;
use Symfony\Component\Console\Input\Input;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            return view('report-index');
    }
    // Отображение отчетов на основе статистики переходов
    // Integer $id - код отчета:
    // 1 - подписка на офферы (Р,W,А)
    // 2 - статистика переходов (Р,W,А)
    // 3 - затраты на рекламу (Р)
    // 4 - Доходы от подписок (W, А)
    // 5 - доход площадки (А)
    public function show(Request $request, $id)
    {

        $date_beg = $request->input('date_beg');
        if (!$date_beg){
            $date_beg = date_format(Carbon::today()->addMonths(-1), 'Y-m-d');
        }
        $date_end = $request->input('date_end');
        if (!$date_end){
            $date_end = date_format(Carbon::today(), 'Y-m-d');
        }
        $per_type = $request->input('per_type');
        if (!$per_type){
            $per_type = 1;
        }
        $gr_type = $request->input('gr_type');
        if (!$gr_type){
            $gr_type = 0;
        }
        // тип периода
        switch ($per_type) {
            case 1:
                $per_type_fmt = '"%d.%m.%Y"';
                break;
            case 2:
                $per_type_fmt = '"%u неделя %Y"';
                break;
            case 3:
                //$per_type_fmt = '"%m месяц %Y"';
                $per_type_fmt = '"%M %Y"';
                break;
            case 4:
                $per_type_fmt = '"%Y"';
                break;
        }
        // Тип группировки
        switch ($gr_type) {
            case 0:
                $gr_type_fld = ['period'];
                $columns = '';
                break;
            case 1:
                $gr_type_fld = ['period', 'advertiser_name'];
                $columns = 'adv.name as advertiser_name, ';
                break;
            case 2:
                $gr_type_fld = ['period', 'advertiser_name', 'offer_name'];
                $columns = 'adv.name as advertiser_name, offers.name as offer_name, max(offers.price) as price, ';
                break;
        }

        //var_dump($request->input());
        $columns = $columns . 'date_format(redirs.created_at, ' . $per_type_fmt . ') period, count(*) as redir_count, sum(redirs.accept) as accept_count, sum(redirs.success) as success_count, ';

        switch ($id) {
            case 1:
                $title = 'Подписка на офферы';
                //$columns = 'redirs.offer_id, max(offers.price) as price, date_format(redirs.created_at, ' . $per_type_fmt . ') period, count(*) as redir_count, sum(redirs.accept) as accept_count, sum(redirs.success) as success_count, sum(redirs.accept*offers.price) as money_sum';
                $columns = $columns . 'sum(redirs.accept*offers.price) as money_sum';
                break;
            case 2:
                $title = 'Статистика переходов';
                //$columns = 'redirs.offer_id, max(offers.price) as price, date_format(redirs.created_at, ' . $per_type_fmt . ') period, count(*) as redir_count, sum(redirs.accept) as accept_count, sum(redirs.success) as success_count, sum(redirs.accept*offers.price) as money_sum';
                $columns = $columns . 'sum(redirs.accept*offers.price) as money_sum';
                break;
            case 3:
                $title = 'Затраты на рекламу';
                //$columns = 'redirs.offer_id, max(offers.price) as price, date_format(redirs.created_at, ' . $per_type_fmt . ') period, count(*) as redir_count, sum(redirs.accept) as accept_count, sum(redirs.success) as success_count, sum(redirs.accept*offers.price) as money_sum';
                $columns = $columns . 'sum(redirs.accept*offers.price) as money_sum';
                break;
            case 4:
                $title = 'Доходы Web-мастера от подписок';
                //$columns = 'redirs.offer_id, max(offers.price) as price, date_format(redirs.created_at, ' . $per_type_fmt . ') period, count(*) as redir_count, sum(redirs.accept) as accept_count, sum(redirs.success) as success_count, sum(redirs.accept * offers.price * 0.8) as money_sum';
                $columns = $columns . 'sum(redirs.accept * offers.price * 0.8) as money_sum';
                break;
            case 5:
                $title = 'Доходы площадки';
                //$columns = 'redirs.offer_id, max(offers.price) as price, date_format(redirs.created_at, ' . $per_type_fmt . ') period, count(*) as redir_count, sum(redirs.accept) as accept_count, sum(redirs.success) as success_count, sum(redirs.accept * offers.price * 0.2) as money_sum';
                $columns = $columns . 'sum(redirs.accept * offers.price * 0.8) as money_sum';
                break;
                }

            return view('report', ['title' => $title, 'id' => $id, 'date_beg' => $date_beg, 'date_end' => $date_end, 'per_type' => $per_type, 'gr_type' => $gr_type,
                            'reports' => Redir:: /* DB::table('redirs') */
                            select(DB::raw($columns))
                            ->limitAL()
                            ->whereDate('redirs.created_at', '>=', $date_beg)
                            ->whereDate('redirs.created_at', '<=', $date_end)
                            ->join('offers', 'redirs.offer_id', '=', 'offers.id')
                            ->join('users as adv', 'offers.advertiser_id', '=', 'adv.id')
                            ->orderBy('period')
                            ->groupBy($gr_type_fld)  //'period', 'offer_id')
                            ->get()]);
    }

    // Данные для диаграмм
    public function chart_data(Request $request, $id){
        $date_beg = $request->input('date_beg');
        if (!$date_beg){
            $date_beg = date_format(Carbon::today()->addMonths(-1), 'Y-m-d');
        }
        $date_end = $request->input('date_end');
        if (!$date_end){
            $date_end = date_format(Carbon::today(), 'Y-m-d');
        }
        $per_type = $request->input('per_type');
        if (!$per_type){
            $per_type = 1;
        }
        $gr_type = $request->input('gr_type');
        if (!$gr_type){
            $gr_type = 0;
        }
        // тип периода
        switch ($per_type) {
            case 1:
                $per_type_fmt = '"%d.%m.%Y"';
                break;
            case 2:
                $per_type_fmt = '"%u неделя %Y"';
                break;
            case 3:
                //$per_type_fmt = '"%m месяц %Y"';
                $per_type_fmt = '"%M %Y"';
                break;
            case 4:
                $per_type_fmt = '"%Y"';
                break;
        }
        // Тип группировки
        switch ($gr_type) {
            case 0:
                $gr_type_fld = ['period'];
                $columns = '';
                break;
            case 1:
                $gr_type_fld = ['period', 'advertiser_name'];
                $columns = 'adv.name as advertiser_name, ';
                break;
            case 2:
                $gr_type_fld = ['period', 'advertiser_name', 'offer_name'];
                $columns = 'adv.name as advertiser_name, offers.name as offer_name, max(offers.price) as price, ';
                break;
        }

        //var_dump($request->input());
        $columns = $columns . 'date_format(redirs.created_at, ' . $per_type_fmt . ') period, count(*) as redir_count, sum(redirs.accept) as accept_count, sum(redirs.success) as success_count, ';

        switch ($id) {
            case 1:
                $title = 'Подписка на офферы';
                //$columns = 'redirs.offer_id, max(offers.price) as price, date_format(redirs.created_at, ' . $per_type_fmt . ') period, count(*) as redir_count, sum(redirs.accept) as accept_count, sum(redirs.success) as success_count, sum(redirs.accept*offers.price) as money_sum';
                $columns = $columns . 'sum(redirs.accept*offers.price) as money_sum';
                break;
            case 2:
                $title = 'Статистика переходов';
                //$columns = 'redirs.offer_id, max(offers.price) as price, date_format(redirs.created_at, ' . $per_type_fmt . ') period, count(*) as redir_count, sum(redirs.accept) as accept_count, sum(redirs.success) as success_count, sum(redirs.accept*offers.price) as money_sum';
                $columns = $columns . 'sum(redirs.accept*offers.price) as money_sum';
                break;
            case 3:
                $title = 'Затраты на рекламу';
                //$columns = 'redirs.offer_id, max(offers.price) as price, date_format(redirs.created_at, ' . $per_type_fmt . ') period, count(*) as redir_count, sum(redirs.accept) as accept_count, sum(redirs.success) as success_count, sum(redirs.accept*offers.price) as money_sum';
                $columns = $columns . 'sum(redirs.accept*offers.price) as money_sum';
                break;
            case 4:
                $title = 'Доходы Web-мастера от подписок';
                //$columns = 'redirs.offer_id, max(offers.price) as price, date_format(redirs.created_at, ' . $per_type_fmt . ') period, count(*) as redir_count, sum(redirs.accept) as accept_count, sum(redirs.success) as success_count, sum(redirs.accept * offers.price * 0.8) as money_sum';
                $columns = $columns . 'sum(redirs.accept * offers.price * 0.8) as money_sum';
                break;
            case 5:
                $title = 'Доходы площадки';
                //$columns = 'redirs.offer_id, max(offers.price) as price, date_format(redirs.created_at, ' . $per_type_fmt . ') period, count(*) as redir_count, sum(redirs.accept) as accept_count, sum(redirs.success) as success_count, sum(redirs.accept * offers.price * 0.2) as money_sum';
                $columns = $columns . 'sum(redirs.accept * offers.price * 0.8) as money_sum';
                break;
                }

        $chartData = Redir::select(DB::raw($columns))
                        ->limitAL()
                        ->whereDate('redirs.created_at', '>=', $date_beg)
                        ->whereDate('redirs.created_at', '<=', $date_end)
                        ->join('offers', 'redirs.offer_id', '=', 'offers.id')
                        ->join('users as adv', 'offers.advertiser_id', '=', 'adv.id')
                        ->orderBy('period')
                        ->groupBy($gr_type_fld)  //'period', 'offer_id')
                        ->get()
                        ->toArray();

        $labels = array_column($chartData, 'period');
        $data = array_column($chartData, 'money_sum');

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }

}
