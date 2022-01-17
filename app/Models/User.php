<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use App\Helpers\StripeConfig;
use App\Models\Traits\Presentable;
use App\Models\Content\ContentListing;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Billable, Presentable;

    public const ACCOUNT_TYPES = [
        'ADMIN', 'CUSTOMER', 'WRITER'
    ];

    protected $presenter = 'App\Presenters\UserPresenter';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar_path',
        'account_type',
        'trial_ends_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isSubscribing() : bool {
        return $this->subscribed(StripeConfig::PRODUCT_NAME);
    }

    public function isOnTrial() : bool {
        return $this->isSubscribing() && $this->trial_ends_at > now();
    }

    public function isRemovable() : bool {
        return !$this->isSubscribing();
    }

    public function daysBeforeTrialEnds() : int {
        return (int) now()->diff($this->trial_ends_at)->format('%d');
    }

    public function contentListings() {
        return $this->hasMany(ContentListing::class);
    }
}
