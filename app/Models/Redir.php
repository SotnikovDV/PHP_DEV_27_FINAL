<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Offer;
use App\Models\User;

class Redir extends Model
{
    use HasFactory;

    protected $attributes = ['offer_id' => 0, 'webmaster_id' => 0, 'success' => false, 'accept' => false];

    protected $fillable = [
        'offer_id',
        'webmaster_id',
        'success',
        'accept'
    ];

    public function offer() { // offer
        return $this->belongsTo(Offer::class);
    }

    public function webmaster() { // пользователь - web-мастер
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::creating(function (Redir $redir) {
            if (Auth::check()) {
                $redir->webmaster_id = Auth::id();
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
