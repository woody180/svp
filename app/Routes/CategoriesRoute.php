<?php

use App\Engine\Libraries\Router;


$router = Router::getInstance();

$router->get('categories/new',                'CategoriesController@new');
$router->post('categories',                   'CategoriesController@create');
$router->get('categories',                    'CategoriesController@index');
$router->get('categories/(:segment)',         'CategoriesController@show');
$router->get('categories/(:segment)/edit',    'CategoriesController@edit');
$router->put('categories/(:segment)',         'CategoriesController@update');
$router->patch('categories/(:segment)',       'CategoriesController@update');
$router->delete('categories/(:segment)',      'CategoriesController@delete');
        