<?php

namespace App\Helpers;

class PHPUnit {
    public static function isPHPUnitProcessRunning() : bool
    {
        return (bool) exec("ps | grep -c '[v]endor/phpunit/phpunit/phpunit'");
    }
}