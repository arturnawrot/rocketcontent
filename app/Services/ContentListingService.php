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
                'deadline' => $contentListingData->deadline,
                'status' => 'active'
            ]);

            // $contentListing->options()->createMany($contentListingData->options);
            
            return $contentListing;
        });
    }

    public function addWriter(ContentListing $contentListing) : void {
        $contentListing->addWriter();
    }

    public function removeWrtier(ContentListing $contentListing) : void {
        $contentListing->removeWriter();
    }

    public function replaceWrtier(ContentListing $contentListing) : void {
        $this->removeWriter($contentListing);
        $this->addWrtier($contentListing);
    }
}