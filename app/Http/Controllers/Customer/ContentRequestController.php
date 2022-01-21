<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Requests\ContentListingRequest;
use App\Http\Controllers\Controller;
use App\Models\ContentListing;
use App\Services\ContentListingService;

class ContentRequestController extends Controller
{
    private $contentListingService;

    public function __construct(ContentListingService $contentListingService) {
        $this->contentListingService = $contentListingService;
    }

    public function showRequestForm() {
        return view('customer.content-listing.request-form');
    }

    public function submitRequest(ContentListingRequest $request) {
        $contentListing = $this->contentListingService->createNewContentRequest( $request->getDto() );

        return $contentListing;
    }

    public function deleteRequest() {

    }

    public function editRequest() {

    }

    public function updateRequest() {
        
    }
}
