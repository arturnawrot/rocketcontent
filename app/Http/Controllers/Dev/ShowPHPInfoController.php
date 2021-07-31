<?php

namespace App\Http\Controllers\Dev;

use App\Http\Controllers\Controller;

class ShowPHPInfoController extends Controller
{
    public function show()
    {
        return phpinfo();
    }
}