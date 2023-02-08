<?php

use App\Engine\Libraries\Router;


$router = Router::getInstance();

$router->get('search', function($req, $res)
{
    $model = initModel('Articles');
    $results = $model->search($req->query('title'));

    if ($res->isAjax()) return $res->send($results);
    
    return $res->render('search', [
        'results' => $results,
        'isAdmin' => checkAuth([1])
    ]);
});