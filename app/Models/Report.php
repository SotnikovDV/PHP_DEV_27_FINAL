<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Offer;
use App\Models\User;

class Report extends Model
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

    protected $attributes = ['offer_id' => 0, 'price' => 0, 'day' => 0, 'month' => 0, 'year' => 0, 'redir_count' => 0, 'accept_count' => 0, 'success_count' => 0, 'sum' => 0];

    protected $fillable = [
        'offer_id',
        'price',
        'day',
        'month',
        'year',
        'redir_count',
        'accept_count',
        'success_count',
        'sum'
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

    public function offer() { // от кого offer
        return $this->belongsTo(Offer::class);
    }

    protected static function booted()
    {
        static::creating(function (Report $report) {
            if (Auth::check()) {
                $report->offer_id = Auth::id();
            }
        });
    }

    public function scopeLimitAdv($query, $offer_id){
        return $query->where('offer_id', $offer_id);
    }
}
