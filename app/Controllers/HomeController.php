<?php namespace App\Controllers;

use \R as R;

class HomeController {
    
    public function index($req, $res)
    {
        $categoryModel = initModel('categories');
        $articlesModel = initModel('articles');
        
        $res->render('welcome', [
            'latest' => $articlesModel->random(),
            'articles' => $articlesModel->allArticles()
        ]);
    }
}