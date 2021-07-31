<?php

namespace App\Http\Controllers\Dev;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

class ShowPHPInfoController extends Controller
{
    public function show()
    {
        if(!App::environment(['local'])) {
            return abort(403);
        }

        return phpinfo();
    }
}