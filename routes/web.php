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
	$router->group(['prefix' => 'auth'], function () use ($router) {
		$router->post('register', ['uses' => 'AuthController@register']);
		$router->post('login', ['uses' => 'AuthController@login']);
	});


	// categories routes
	$router->group(['prefix' => 'categories'], function () use ($router) {
		$router->post('', ['uses' => 'CategoriesController@createCategory']);
		$router->get('', ['uses' => 'CategoriesController@getAllCategories']);
		$router->put('/{id}', ['uses' => 'CategoriesController@updateCategory']);
		$router->delete('/{id}', ['uses' => 'CategoriesController@deleteCategory']);
	});

});
