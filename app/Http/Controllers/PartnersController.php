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
		
    public function index()
    {
			$partners = Partners::all();
			$partnerDetails = [];

			foreach ($partners as $partner) {
				$partnerDetail = $partner->getPartnerDetails($partner);
				
				$partners = [
					"id" => $partner->id,
					"user_id" => $partner->user_id,
					"category" => $partner->category_id,
					"image" => $partner->image,
					"partner_details" => $partnerDetail
				];

				$partnerDetails[] = $partners;
			}
			
			return response($partnerDetails, 200);
    }

    public function show($id)
    {
        //
    }

    public function create(Request $request)
    {
				// Create new Partner
				$this->validate($this->request, Partners::$rules);

				$newPartner = Partners::create(
						[
							'user_id' => $this->request->user_id,
							'category_id' => $this->request->category_id,
							'image' => $this->request->image
						]
				);
				return response()->json($newPartner, 201);

    }

    public function edit($id)
    {
        //
    }

    public function update($id, Request $request)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
