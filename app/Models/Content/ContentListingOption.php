<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentListingOption extends Model
{
    use HasFactory;

    protected $table = 'content_listing_options';

    protected $fillable = [
        'name',
        'value',
    ];
}