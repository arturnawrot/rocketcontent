<?php

namespace App\DataTransferObject;

use Spatie\DataTransferObject\DataTransferObject;

class UserData extends DataTransferObject
{
    public string $name;

    public string $email;

    public string $password;
}