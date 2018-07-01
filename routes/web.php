<?php // phpcs:disable

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {
	// authentication routes
	$router->group(['prefix' => 'auth'], function () use ($router) {
		$router->post('register', ['uses' => 'AuthController@register']);
		$router->post('login', ['uses' => 'AuthController@login']);
	});

	// user management routes
	$router->group(['prefix' => 'users'], function () use ($router) {
		$router->get('', ['uses' =>  'UserController@getAllUsers']);
	});


	// categories routes
	$router->group(['prefix' => 'categories'], function () use ($router) {
		$router->post('', ['uses' => 'CategoriesController@createCategory']);
		$router->get('', ['uses' => 'CategoriesController@getAllCategories']);
		$router->put('/{id}', ['uses' => 'CategoriesController@updateCategory']);
		$router->delete('/{id}', ['uses' => 'CategoriesController@deleteCategory']);
	});

});
