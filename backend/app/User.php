<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::created(function ($user) {
            $user->setting()->save(new UserSetting([
                'max_auto_bid' => 0,
                'auto_bid_reserve' => 0
            ]));
        });
    }

    public function setting()
    {
        return $this->hasOne(UserSetting::class);
    }

    public function bids() {
        return $this->hasMany(Bid::class, 'user_id');
    }

    // Get the value of the auto maximum bid amount which is available for auto bidding
    public function reserveBidAmount() {
        if ($this->setting->max_auto_bid) {
            $used_reserve = $this->bids()
                ->where('auto_bid', true)->sum('amount');

            return max($this->setting->max_auto_bid - $used_reserve, 0);
        }

        return 0;
    }
}
