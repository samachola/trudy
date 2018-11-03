<?php

namespace App\Http\Controllers;

use App\Models\Partners;
use App\Models\User;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PartnersController extends Controller
{
    /**
     * Request instance
     * 
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * New controller instance
     * 
     * @param Request $request - Request object
     * 
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get list of all partners
     * 
     * @return object { $partners }
     */
    public function index(Request $request)
    {
        $partners = Partners::all();
        $partnerDetails = [];

        foreach ($partners as $partner) {
            $partnerDetail = $this->getPartnerDetails($partner);
            
            $partners = [
              "id" => $partner->id,
              "user_id" => $partner->user_id,
              "category" => $partner->category,
              "location" => $partner->location,
              "lat" => $partner->lat,
              "lng" => $partner->lng,
              "partner_details" => $partnerDetail
            ];

            $partnerDetails[] = $partners;
        }
        
        return response($partnerDetails, 200);
    }

    /**
     * Get single patner
     * 
     * @param integer $id - user Id
     * 
     * @return object
     */
    public function show($id)
    {
        $partner = Partners::where('user_id', $id)->first();

        return response()->json($partner, 200);
    }

    /**
     * Register a new partner
     * 
     * @param object $request - request object
     * 
     * @return object {$newPartner}
     */
    public function create(Request $request)
    {
        // Create new Partner
        $this->validate($this->request, Partners::$rules);

        $newPartner = Partners::create(
            [
              'user_id' => $this->request->user_id,
              'category' => $this->request->category,
              'location' => $this->request->location,
              'lat' => $this->request->lat,
              'lng' => $this->request->lng
            ]
        );
        return response()->json($newPartner, 201);
    }

    /**
     * Update partner
     * 
     * @param integer $id - Partner ID. 
     * @param object $request - Request 
     * 
     * @return {void}
     */
    public function update($id, Request $request)
    {
        $partner = Partners::findOrFail($id);

        $partner->category = $this->request->category;
        $partner->location = $this->request->location;
        $partner->lat = $this->request->lat;
        $partner->lng = $this->request->lng;

        $partner->save();

        return response()->json(
            [
              "message" => "Partner details updated successfully"
            ],
            201
        );

    }
    

    /** 
     * get filtered partners
     * 
     * @param object $request -Request
     * 
     * @return array - List of partners that meet the filter.
     **/
    public function getPartners(Request $request)
    {
        $circle_radius = 3959;
        $max_distance = 20;
        $lat = $this->request->lat;
        $lng = $this->request->lng;
        $category = $this->request->category;
        
        $partners = DB::table('partners')
                        ->where('lat', '<', $lat + (20 * 0.018))
                        ->where('category', $category)
                        ->get();
        
        $availablePartners = [];

        foreach ($partners as $partner) {
            $partnerDetails = $this->getPartnerDetails($partner);
            
            $partners = [
              "id" => $partner->id,
              "user_id" => $partner->user_id,
              "category" => $partner->category,
              "location" => $partner->location,
              "lat" => $partner->lat,
              "lng" => $partner->lng,
              "partner_details" => $partnerDetails
            ];

            $availablePartners[] = $partners;
        }

        return response()->json($availablePartners, 200);
    }

    /**
     * Delete partner
     * 
     * @param integer $id - Partner ID.
     * 
     * @return {void}
     */
    public function destroy($id)
    {
        //
    }
    
    /**
     * Get partner details
     * 
     * @param Object $partner - Partner object
     * 
     */
    public function getPartnerDetails($partner)
    {
        $userDetails = User::find($partner->user_id);
        $categoryDetails = Categories::find($partner->category);

        $partnerDetails = (object) [
          "email" => $userDetails->email,
          "image" => $userDetails->image,
          "category" => $categoryDetails->name,
          "name" => $userDetails->name,
        ];

        return $partnerDetails;
    }
}
