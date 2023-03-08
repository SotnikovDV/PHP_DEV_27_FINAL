<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const AAL = [
        0 => 'Нет доступа',
        1 => 'Только чтение',
        2 => 'Редактирование'
    ];

    protected $attributes = ['access_level' => 2, 'advertiser' => false, 'webmaster' => false, 'admin' => false];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'advertiser',
        'webmaster'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getALAttribute()
    {
        return self::AAL[$this->access_level];
    }

    public function scopeLimitAL($query){
        //$ac = Auth::user()->access_level;
        $adm = Auth::user()->admin;
        //if ($ac < 2) {
        if (!$adm) {
            return $query->where('id', Auth::id());
        } else {
            return $query;  //->where('access_level', '<=', $ac);
        }
    }
}
