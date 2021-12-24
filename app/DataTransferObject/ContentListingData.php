<?php

namespace App\DataTransferObject;

use Spatie\DataTransferObject\DataTransferObject;

class ContentListingData extends DataTransferObject
{
    public string $title;

    public string $description;

    public string $deadline;
}