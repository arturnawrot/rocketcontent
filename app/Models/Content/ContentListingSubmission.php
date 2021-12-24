<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentListingSubmission extends Model
{
    use HasFactory;

    protected $table = 'content_listing_submissions';

    protected $fillable = [
        'content'
    ];
}