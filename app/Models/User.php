<?php

namespace App\Models;

use App\Repositories\Cache\PaymentMethodRepository;
use App\Repositories\Cache\StripeMetaDataRepository;
use App\Services\StorageService;
use App\Services\CustomerService;
use App\Models\Traits\Presentable;
use App\Models\Content\ContentListing;
use App\Helpers\StripeConfig;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Billable, Presentable;

    // Don't edit these.
    public const ACCOUNT_TYPES = [
        'ADMIN', 'CUSTOMER', 'WRITER', 'MANAGER'
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

    protected $attributes = [
        'avatar_path' => ''
    ];

    public function getSubscriptionStripeId()
    {
        return StripeConfig::PRODUCT_NAME;
    }

    public function isSubscribing() : bool {
        return $this->subscribed($this->getSubscriptionStripeId());
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

    public function getAvatarUrl() {
        return StorageService::getFileUrl('avatars', $this->avatar_path);
    }

    public function getPaymentMethods() {
        return PaymentMethodRepository::getPaymentMethods($this);
    }

    public function getSubscription()
    {
        return StripeMetaDataRepository::getStripeSubscriptionObject($this);
    }

    public function getNextBillingDate() : \Carbon\Carbon
    {
        $timestamp = $this->getSubscription()->current_period_end;
        return \Carbon\Carbon::createFromTimeStamp($timestamp);
    }

    public function isCustomer()
    {
        return $this->account_type == 'CUSTOMER';
    }

    protected static function booted()
    {
        static::updated(function ($user) {
            if($user->isCustomer()) {
                CustomerService::syncCustomerDataWithStripe($user);
            }
        });
    }

    public function getStripeUpdatableFields()
    {
        return [
            'name' => $this->name,
            'email' => $this->email
        ];
    }

    public function isAdmin() : bool
    {
        return $this->account_type == 'ADMIN';
    }
}