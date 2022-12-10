<?php namespace App\Controllers;

use \R as R;

class HomeController {
    
    public function index($req, $res)
    {
        $categoryModel = initModel('categories');
        $articlesModel = initModel('articles');
        
        $categoryModel->loadCategory('სმენის');
        
        
        $res->render('welcome', [
            'latest' => $articlesModel->latestArticles()
        ]);
    }
}