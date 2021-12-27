<?php

namespace App\Services;

use App\Models\Content\ContentListing;
use App\DataTransferObject\ContentListingData;
use Illuminate\Support\Facades\DB;

class ContentListingService {

    public function createNewContentRequest(ContentListingData $contentListingData) : ContentListing {
        return DB::transaction(function () use ($contentListingData) {

            $contentListing = auth()->user()->contentListings()->create([
                'title' => $contentListingData->title,
                'description' => $contentListingData->description,
                'word_count' => $contentListingData->wordCount,
                'deadline' => $contentListingData->deadline,
                'status' => 'active'
            ]);

            // $contentListing->options()->createMany($contentListingData->options);
            
            return $contentListing;
        });
    }
}