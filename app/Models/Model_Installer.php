<?php
        
class Model_Installer extends RedBean_SimpleModel {

    public function open() {
        
    }

    public function dispense() {
        
    }

    public function update() {
        
    }

    public function after_update() {
        
    }

    public function delete() {
        
    }

    public function after_delete() {
        
    }


    public function migrate()
    {
        R::exec('SET FOREIGN_KEY_CHECKS = 0;');
        R::nuke();

        // Create pages table
        $page = R::dispense('page');
        $page->import([
            'title' => 'title',
            'url' => 'url',
            'description' => 'description',
            'thumbnail' => 'thumbnail',
            'body' => 'body',
            'createdat' => 'createdat'
        ]);
        R::store($page);
        
        $lastPage = R::findLast('page');
        R::trash($lastPage);


        // Create articles & categories table
        $category = R::dispense('categories');
        $article = R::dispense('articles');

        $category->import([
            'title' => 'title',
            'url' => 'url',
            'banner' => 'banner',
            'description' => 'description'
        ]);
        
        $article->import([
            'title' => 'title',
            'url' => 'url',
            'thumbnail' => 'thumbnail',
            'description' => 'description',
            'body' => 'body',
            'keywords' => 'keywords',
            'timestamp' => time()
        ]);
        $article->sharedCategoriesList[] = $category;
        R::store($article);
        R::trash('categories', 1);
        R::trash('articles', 1);
    }
}