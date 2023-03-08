<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Offer;
use App\Models\User;
use GuzzleHttp\Psr7\Request;

class Subscribe extends Model
{
    use HasFactory;

    protected $attributes = ['offer_id' => 0, 'webmaster_id' => 0];

    protected $fillable = [
        'offer_id',
        'webmaster_id'
    ];


    public function offer() { // offer
        return $this->belongsTo(Offer::class);
    }

    public function webmaster() { // web-мастер
        return $this->belongsTo(User::class);
    }
    // Ссылка для размещения на сайте webmaster
    public function go_url(){
        return route('go', ['id' => $this->id]);
    }

    protected static function booted()
    {
        static::creating(function (Subscribe $subscribe) {
            if (Auth::check()) {
                $subscribe->webmaster_id = Auth::id();
            }
        });
    }

    public function scopeLimitAL($query){
        $adm = Auth::user()->admin;
        $wm = Auth::user()->webmaster;
        $adv = Auth::user()->advertiser;
        if ($adm) {
            return $query;
        } elseif ($wm) {
            return $query->where('webmaster_id', Auth::id());
        } elseif ($adv) {
            //return $query->where('offer_id', 0);
            return $query->whereRaw('offer_id in (select o.id from offers o where o.advertiser_id = ?)', [Auth::id()]);
        }

    }
}
