<?php

use App\Engine\Libraries\Router;


$router = Router::getInstance();

$router->get('article/new',                'ArticlesController@new', 'Middlewares/checkAdmin');
$router->post('article',                   'ArticlesController@create', 'Middlewares/checkAdmin');
$router->get('article',                    'ArticlesController@index', 'Middlewares/checkAdmin');
$router->get('article/(:segment)',         'ArticlesController@show');
$router->get('article/(:segment)/edit',    'ArticlesController@edit', 'Middlewares/checkAdmin');
$router->put('article/(:segment)',         'ArticlesController@update', 'Middlewares/checkAdmin');
$router->patch('article/(:segment)',       'ArticlesController@update', 'Middlewares/checkAdmin');
$router->delete('article/(:segment)',      'ArticlesController@delete', 'Middlewares/checkAdmin');