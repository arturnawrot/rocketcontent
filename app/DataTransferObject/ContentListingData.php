<?php

namespace App\DataTransferObject;

use Spatie\DataTransferObject\DataTransferObject;

class ContentListingData extends DataTransferObject
{
    public string $title;

    public string $description;

    public int $wordCount;

    public string $deadline;

    public ?array $options;
}