<?php

namespace App\Http\Controllers\Property;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Property;
use App\Repositories\PropertyRepository;
use Illuminate\Support\Facades\DB;

class PropertyController extends Controller {

    /**
     * The Property repository instance.
     *
     * @var PropertyRepository
     */
    protected $propertyRepository;
    protected $items_per_page = 9;

    /**
     * Create a new controller instance.
     *
     * @param  TaskRepository  $tasks
     * @return void
     */
    public function __construct(PropertyRepository $propertyRepository) {
        // $this->middleware('auth');

        $this->propertyRepository = $propertyRepository;
    }

    /**
     * Display a list of all of the user's task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request) {
        //if ($request->isMethod('post') || $request->input('_token') != '' || $request->input('sortby') != '' ) {
            $featured = $request->input('featured');
            $AgentID = $request->input('AgentID');
            $myproperty = $request->input('myproperty');
            $limitPerPage = $this->items_per_page;
            $selectedListing = '';

            $similar_item = 0;
            $listings = $this->propertyRepository->search($featured, $AgentID, $similar_item, $myproperty, $limitPerPage, $selectedListing);
            return view('property/properties', [
                'data' => $listings,
            ]);
        //}
        //$data = $this->propertyRepository->getPaginated($this->items_per_page);
        //return view('property/properties', [
        //    'data' => $data
        //]);
    }

    public function propertyDetails(Request $request) {
        
        $property = Property::find($request->id);
        $carousel = PropertyRepository::getCarousel($request->id);
        $featured = '';
        $myproperty = '';
        $selectedListing = '';
        $AgentID = '';
        $similar_item = $request->id;
        $similar = $this->propertyRepository->search($featured, $AgentID, $similar_item, $myproperty, $this->items_per_page, $selectedListing);
        
        return view('property/property', [
            'property' => $property,
            'title' => 'Property Details',
            'carousel' => $carousel['carousel'],
            'indicators' => $carousel['indicators'],
            'similar'  => $similar,
        ]);
    }

}
