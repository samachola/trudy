<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Categories;

class Partners extends Model
{
    protected $fillable = [
      'user_id', 'skills'
    ];

    protected $nullable = ['image'];

    public $timestamps = false;

    public static $rules = [
      'user_id' => 'required|integer',
      'skills' => 'required'
    ];
}
