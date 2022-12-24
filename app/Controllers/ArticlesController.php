<?php namespace App\Controllers;

use \R as R;

class ArticlesController {
    
    protected $articlesModel;

    public function __construct() {
        $this->articlesModel = initModel('articles');
    }
    
    
    // Add new view
    public function new($req, $res) {
        
    }


    // Create view
    public function create($req, $res) {
       
    }


    // All items
    public function index($req, $res) {
        
        $list = $this->articlesModel->allArticles();
        
        return $res->render('back/articles/list', [
            'list' => $list
        ]);
    }


    // Show view
    public function show($req, $res) {
        $id = $req->getSegment(2);

        $article = $this->articlesModel->loadArticle($id);
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
        $similarArticles = $this->articlesModel->similar();
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
        
        dd($id);
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
        