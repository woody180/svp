<?php

use App\Engine\Libraries\Router;


$router = Router::getInstance();

$router->get('article/new',                'ArticlesController@new');
$router->post('article',                   'ArticlesController@create');
$router->get('article',                    'ArticlesController@index');
$router->get('article/(:segment)',         'ArticlesController@show');
$router->get('article/(:segment)/edit',    'ArticlesController@edit');
$router->put('article/(:segment)',         'ArticlesController@update');
$router->patch('article/(:segment)',       'ArticlesController@update');
$router->delete('article/(:segment)',      'ArticlesController@delete');
        