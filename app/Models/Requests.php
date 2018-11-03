<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * Service Request Model.
 */
class Requests extends Model
{

    protected $fillable = [
				'date', 
				'category_id', 
				'client_email', 
				'partner_id', 
				'status', 
				'fee', 
				'rating', 
				'paid'
    ];

    public static $rules = [
      'date' => 'required',
      'category_id' => 'required|integer'
    ];
}