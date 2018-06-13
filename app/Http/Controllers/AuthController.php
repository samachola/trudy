<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Illuminate\Http\Request;

class AuthController extends Controller
{
	public function __construct()
	{
		
	}

	/**
	 * Create a new user.
	 * 
	 * @param Request $request
	 * 
	 * @return {Object}
	 */
	public function register(Request $request)
	{
		try {
			$newUser = User::create($request->all());
			return response()->json($newUser, 201);

		} catch (Exception $e) {
			return response('Something went wrong', 500);
		}
		
	}
}