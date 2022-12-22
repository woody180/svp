<?php namespace App\Controllers;

use \R as R;

class ArticlesController {
    
    // Add new view
    public function new($req, $res) {
        
    }


    // Create view
    public function create($req, $res) {
       
    }


    // All items
    public function index($req, $res) {
       
    }


    // Show view
    public function show($req, $res) {
        $id = $req->getSegment(2);

        $articlesModel = initModel('Articles');
        $article = $articlesModel->loadArticle($id);
        $categories = $article->sharedCategories;

        $categoriesStr = '';
        $arr = json_decode(json_encode($categories), true);
        $i = 0;
        
        foreach ($arr as $cat) {
            $i++;
            $title = trim($cat['title']);
            $categoriesStr .= '<a href="'.baseurl("categories/{$cat['url']}").'">'.$title .= (count($arr) === $i ? '' : ', ') .'</a>';
        }
        
        
        
        // Similar articles
        $similarArticles = $articlesModel->similar();
        //dd($similarArticles);

        return $res->render('article', [
            'article' => $article,
            'categories' => $categoriesStr,
            'title' => $article->title,
            'similars' => $similarArticles
        ]);
    }


    // Edit view
    public function edit($req, $res) {
        $id = $req->getSegment(2);
    }


    // Update
    public function update($req, $res) {
        $id = $req->getSegment(2);
    }


    // Delete
    public function delete($req, $res) {
        $id = $req->getSegment(2);
    }

}
        