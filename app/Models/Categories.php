<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model {

	protected $fillable = [
		'name', 'description'
	];

	public static $rules = [
		'name' => 'required|string',
		'description' => 'string'
	];
}