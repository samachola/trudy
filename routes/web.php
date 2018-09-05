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
		$router->get('', ['middleware' => 'jwt.auth', 'uses' =>  'UserController@getAllUsers']);
		$router->get('/{id}', ['uses' => 'UserController@getSingleUser']);
	
	});


	// categories routes
	$router->group(['prefix' => 'categories'], function () use ($router) {
		$router->post('', ['middleware' => 'jwt.auth', 'uses' => 'CategoriesController@createCategory']);
		$router->get('', ['uses' => 'CategoriesController@getAllCategories']);
		$router->put('/{id}', ['middleware' => 'jwt.auth', 'uses' => 'CategoriesController@updateCategory']);
		$router->delete('/{id}', ['middleware' => 'jwt.auth', 'uses' => 'CategoriesController@deleteCategory']);
	});

	// partners routes
	$router->group(['prefix' => 'partners'], function () use ($router) {
		$router->post('', ['middleware' => 'jwt.auth', 'uses' => 'PartnersController@create']);
		$router->get('', ['uses' => 'PartnersController@index']);
		$router->post('/filter', ['uses' => 'PartnersController@getPartners']);
		$router->put('/{id}', ['middleware' => 'jwt.auth', 'uses' => 'PartnersController@update']);
		$router->delete('/{id}', ['middleware' => 'jwt.auth', 'uses' => 'PartnersController@destroy']);
	});

	// request routes
	$router->group(['prefix' => 'requests', 'middleware' => 'jwt.auth'], function () use ($router) {
		$router->post('', ['uses' => 'RequestController@createRequest']);
		$router->get('', ['uses' => 'RequestController@getRequests']);
		$router->put('status/{$id}', ['uses' => 'RequestController@updateRequestStatus']);
		$router->delete('/{$id}', ['uses' => 'RequestController@removeRequest']);
		$router->patch('rating/{$id}', ['uses' => 'RequestController@updateRequestRating']);
	});
});
