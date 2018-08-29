<?php

namespace App\Http\Controllers;

use App\Models\Partners;
use App\Models\User;
use Illuminate\Http\Request;
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
            $partnerDetail = $partner->getPartnerDetails($partner);
            
            $partners = [
              "id" => $partner->id,
              "user_id" => $partner->user_id,
              "category" => $partner->category_id,
              "location" => $partner->location,
              "partner_details" => $partnerDetail
            ];

            $partnerDetails[] = $partners;
        }
        
        return response($partnerDetails, 200);
    }

    /**
     * Get single patner
     * 
     * @param integer $id - partner Id
     * 
     * @return object
     */
    public function show($id)
    {
        $partner = Partner::findOrFail($id);

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
              'category_id' => $this->request->category_id,
              'location' => $this->request->location
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
        //
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
}
