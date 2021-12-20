<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\TracksHistory;

class Content extends Model
{
    use HasFactory, TracksHistory;

    protected $fillable = [
        ''
    ];
}
