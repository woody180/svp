<?php

use App\Engine\Libraries\Router;


$router = Router::getInstance();

$router->get('pages/new',                'PagesController@new');
$router->post('pages',                   'PagesController@create');
$router->get('pages',                    'PagesController@index');
$router->get('pages/(:segment)',         'PagesController@show');
$router->get('pages/(:segment)/edit',    'PagesController@edit');
$router->put('pages/(:segment)',         'PagesController@update');
$router->patch('pages/(:segment)',       'PagesController@update');
$router->delete('pages/(:segment)',      'PagesController@delete');
        