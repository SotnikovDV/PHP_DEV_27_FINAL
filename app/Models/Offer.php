<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
/* use App\Models\Client;
use App\Models\Representative;
use App\Models\Event; */
use App\Models\User;

class Offer extends Model
{
    use HasFactory;
/*
    const TA = [
        0 => 'Отказ клиента',
        1 => 'Обращение',
        2 => 'Ожидание решения клиента',
        3 => 'Договор заключен',
        4 => 'Договор завершен'
    ]; */

    protected $attributes = ['subjects' => '', 'advertiser_id' => 0, 'url' => '', 'price' => 0, 'active' => false];

    protected $fillable = [
        'name',
        'subjects',
        'advertiser_id',
        'url',
        'price',
        'active'
    ];

    /* public function getTAttribute()
    {
        return self::TA[$this->type];
    } */
/*
    public function events() // события заявки
    {
        return $this->hasMany(Event::class);
    } */

    public function advertiser() { // от кого offer
        return $this->belongsTo(User::class);
    }

  /*   public function representative() { // основной представитель клиента по заявке
        return $this->belongsTo(Representative::class);
    } */

  /*   public function creater() { // пользователь - создатель
        return $this->belongsTo(User::class);
    } */

    /* public function updater() { // последний пользователь, обновивший модель
        return $this->belongsTo(User::class);
    } */

    protected static function booted()
    {
        static::creating(function (Offer $offer) {
            if (Auth::check()) {
                $offer->advertiser_id = Auth::id();
            }
        });
    }

    public function scopeLimitAdv($query, $advertiser_id){
        return $query->where('advertiser_id', $advertiser_id);
    }
}
