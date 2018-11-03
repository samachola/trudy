<?php 
/**
 * User Controller
 * 
 * @author Achola <sam.achola@live.com>
 */

namespace App\Http\Controllers;

use App\Models\User;
use Exception;

/**
 * User Management Controller.
 */
class UserController extends Controller
{
    /**
     * Gets all registered users.
     * 
     * @return {Array} - List of users
     */
    function getAllUsers()
    {
        $users = User::all();

        return response()->json(['users' => $users], 200);
    }
    
    /**
     * Get one user.
     * 
     * @param integer $id - user id
     * 
     * @return Object - user details.
     */
    function getSingleUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'user not found'], 401);
        }

        return response()->json($user, 200);
    }
}
