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
}
