<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Categories;

class Partners extends Model
{
    protected $fillable = [
      'user_id', 'category_id', 'location', 'lat', 'lng'
    ];

    protected $nullable = ['lat', 'lng'];
    public $timestamps = false;

    public static $rules = [
      'user_id' => 'required|integer',
      'category_id' => 'required|integer',
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
        $categoryDetails = Categories::find($partner->category_id);

        $partnerDetail = (object) [
					"email" => $userDetails->email,
					"image" => $userDetails->image,
          "category" => $categoryDetails->name,
          "name" => $userDetails->name,
        ];

        return $partnerDetail;
    }

    /**
     * Get filtered partners
     * 
     * @param Array $params - filter params
     * 
     * @return Array - List of Partners
     */
    function getPartners($params)
    {
        return Partners::where('location', $params->location)
                      ->where('category_id', $params->category);
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
