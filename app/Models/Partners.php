<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Categories;

class Partners extends Model
{
		protected $fillable = [
			'user_id', 'category_id', 'image'
		];

		protected $nullable = ['image'];

		public $timestamps = false;

		public static $rules = [
			'user_id' => 'required|integer',
			'category_id' => 'required|integer',
		];

		public function getPartnerDetails($partner) {

			$userDetails = User::find($partner->user_id);
			$categoryDetails = Categories::find($partner->category_id);

			$partnerDetail = (object) [
				"email" => $userDetails->email,
				"category" => $categoryDetails->name,
				"name" => $userDetails->name,
			];

			return $partnerDetail;
		}
}
