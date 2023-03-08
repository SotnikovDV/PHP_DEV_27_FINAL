<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Library\ApiHelpers;
use App\Models\Redir;
use App\Models\User;
use App\Models\Offer;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubscribeController;


class RedirController extends Controller
{
    // просмотр переходов по подписке
    public function from_subs($id)
    {
        $subscribe = Subscribe::find($id);
        return view('redir-index', ['offer' => false, 'subscribe' => $subscribe,
            'redirs' => Redir::LimitAL()->whereRaw('offer_id in (select s.offer_id from subscribes s where s.id = ?)', [$subscribe->id])->orderByDesc('id')->paginate(10)]);
    }
    // просмотр переходов по офферу
    public function from_offer($id)
    {
        $offer = Offer::find($id);
        return view('redir-index', ['offer' => $offer, 'subscribe' => false,
            'redirs' => Redir::LimitAL()->where(['offer_id' => $offer->id])->orderByDesc('id')->paginate(10)]);
    }
    // запрос рекламной ссылки
    public function go(Request $request, $id)
    {
        /* dd('redirect'); */
        $user = $this->get_user($request);

        $subscribe = Subscribe::where(['id' => $id])->first();
        if (!$subscribe){
            return route('redirerr');
        }
        //dd($subscribe);
        $offer_url = $this->create($subscribe);
        return $offer_url;
    }
    // сохранения факта запроса рекламной ссылки
    public function create(Subscribe $subscribe)
    {
        //return view('subscribe-edit', ['edit' => 0, 'subscribe' => new Subscribe(['offer_id' => $offer->id])]);
        $redir = new Redir();
        $redir->offer_id = $subscribe->offer->id;
        $redir->webmaster_id = Auth::user()->id;
        $redir->accept = $redir->webmaster_id == $subscribe->webmaster->id;
        $redir->success = false;
        $redir->save();
        if ($redir->accept) {
            return $subscribe->offer->url.'?rd='.$redir->id;
        } else {
            return route('redirerr');
        }
    }
    // подтверждение перехода по рекламной ссылке
    public function success(Request $request, $id)
    {
        $user = $this->get_user($request);
        $redir = Redir::find($id);
        // проверка на оффер рекламодателя
        if (!$redir){
            return route('redirerr');
        } else {
            $this->update_success($redir);
            return true;
        }
    }
    // подтверждение факта перехода по рекламной ссылке
    public function update_success(Redir $redir)
    {
        //return view('subscribe-edit', ['edit' => 0, 'subscribe' => new Subscribe(['offer_id' => $offer->id])]);
        $redir->success = true;
        $redir->save();
    }
    // предоставление нового токена
    public function new_token(Request $request){
        if(Auth::check()){
            Auth::user()->tokens()->delete();
            return auth()
                ->user()
                ->createToken(auth()->user()->name)
                ->plainTextToken;
        } else {
            return 'User not authenticated';
        }
    }

    /* // отображение текущего токена - пока не понял как сделать ((
    public function get_token(Request $request){
        if(Auth::check()){
            $user = auth()->user();
            $token =  $user->tokens()->find(6);
            if ($token) {
                return response()->json(['token' => $token->plainTextToken], 200);
            } else {
                return response()->json(['message' => 'Token not found'], 404);
            }
        } else {
            return 'User not authenticated';
        }
    } */

    // авторизация через токен

    public function get_user(Request $request)
    {
        // Задайте параметры запроса
        $url = 'http://192.168.1.77:82/api/user';
        $token = '7|HZYaGY7RaLt0uUF9qtThSmwdWeoP87syQghjaHkh';

        // Создайте экземпляр GuzzleHttp\Client с заголовком авторизации
        $client = new Client([
            'headers' => [
                'Authorization' => 'Bearer ' . $token
            ]
        ]);

        // Отправьте GET-запрос с использованием экземпляра GuzzleHttp\Client
        $response = $client->request('GET', $url);

        // Получите ответ в формате JSON
        $user = json_decode($response->getBody(), true);

        // Выведите данные пользователя
        return $user;

    }

}
