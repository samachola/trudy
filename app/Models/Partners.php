<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Categories;

class Partners extends Model
{
    protected $fillable = [
      'user_id', 'category', 'location', 'lat', 'lng'
    ];

    public $timestamps = false;

    public static $rules = [
      'user_id' => 'required|integer',
      'category' => 'required|integer',
      'location' => 'required',
		];

    /**
     * Get partner details
     * 
     * {@param} $partner - Partner object
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

    /**
     * Get all partner requests.
     * 
     * @return {Object}
     */
    public function requests()
    {
        return $this->hasMany('App\Models\Requests');
    }
}
