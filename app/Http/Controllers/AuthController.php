<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    private $request;


    /**
     * New controller instance
     * 
     * @param Request $request - Request
     * 
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Create a token
     * 
     * @param User $user - User
     * 
     * @return string - Token
     */
    protected function jwt(User $user)
    {
        $payload = [
            'iss' => 'lumen-jwt',
            'sub' => $user->id,
            'iat' => time(),
            'exp' => time() + 60*60
        ];

        return JWT::encode($payload, env('JWT_SECRET'));
    }


    /**
     * Create a new user.
     * 
     * @param Request $request - Request
     * 
     * @return {Object}
     */
    public function register(Request $request)
    {
        // validate $request data
        $this->validate($request, User::$newAccountRules);
        
        $newUser = User::create(
            [
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'idcard' => $request->idcard,
                'password' => Hash::make($request->password),
            ]
        );

        return response()->json($newUser, 201);
    }

    /**
     * User Login
     * 
     * @param User $user - User
     * 
     * @return {Object} - contains JWT token
     */
    public function login(User $user)
    {
        $this->validate($this->request, User::$loginRules);

        // find user by email
        $user = User::where('email', $this->request->email)->first();
        
        if (!$user) {
            return response()->json(
                [
                    'error' => 'email does not exist'
                ], 400
            );
        }

        // check if passwords match
        if (Hash::check($this->request->password, $user->password)) {
            return response()->json(
                [
                    'token' => $this->jwt($user),
                ], 201
            );
        }

        // bad request
        return response()->json(
            [
            'error' => 'email or password is incorrect'
            ], 400
        );
    }
}