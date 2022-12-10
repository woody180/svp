<?php

use App\Engine\Libraries\Router;


$router = Router::getInstance();

$router->get('articles/new',                'ArticlesController@new');
$router->post('articles',                   'ArticlesController@create');
$router->get('articles',                    'ArticlesController@index');
$router->get('articles/(:segment)',         'ArticlesController@show');
$router->get('articles/(:segment)/edit',    'ArticlesController@edit');
$router->put('articles/(:segment)',         'ArticlesController@update');
$router->patch('articles/(:segment)',       'ArticlesController@update');
$router->delete('articles/(:segment)',      'ArticlesController@delete');
        