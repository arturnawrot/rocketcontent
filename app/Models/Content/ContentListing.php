<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\TracksHistory;

class ContentListing extends Model
{
    use HasFactory, TracksHistory;

    protected $table = 'content_listings';

    protected $fillable = [
        'title',
        'description',
        'deadline',
        'status'
    ];

    public function options() {
        return $this->hasMany(ContentOption::class);
    }

    public function writer() {
        return $this->belongsTo(User::class, 'content_listing_has_a_writer')
            ->wherePivot('status', 'active');
    }

    public function submissions() {
        return $this->hasMany(ContentListingSubmission::class);
    }

    public function addWriter(User $user) : void {

    }

    public function removeWrtier(User $user) : void {

    }
}