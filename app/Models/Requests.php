<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * Service Request Model.
 */
class Requests extends Model
{

    protected $fillable = [
        'date', 'category_id', 'client_id', 'partner_id'
    ];

    public static $rules = [
        'date' => 'required',
    ];
}