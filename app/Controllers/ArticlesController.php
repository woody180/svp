<?php namespace App\Controllers;

use \R as R;
use Cocur\Slugify\Slugify;
use  App\Engine\Libraries\Validation;
use App\Engine\Libraries\ImageResize\ImageResize;

class ArticlesController {
    
    protected $articlesModel;

    public function __construct() {
        $this->articlesModel = initModel('articles');
    }
    
    
    // Add new view
    public function new($req, $res)
    {
        $categoriesModel = initModel('categories');
        
        return $res->render('back/articles/new', [
            'categories' => $categoriesModel->categoryList()
        ]);
    }


    // Create view
    public function create($req, $res)
    {
        $slugify = new Slugify();
        
        // Prepare content
        $body = $req->body();
        unset($body['csrf_token']);
        unset($body['_method']);
        
        $body['title'] = strip_tags($body['title']);
        $body['url'] = $slugify->slugify($body['title']);
        $body['description'] = strip_tags($body['description'] ?? '');
        $body['description'] = str_replace(array("\r", "\n"), '', $body['description'] ?? '');
        $body['body'] = relevantPath($body['body'], false);
        $body['timestamp'] = time();
        $body['keywords'] = strip_tags($body['keywords'] ?? '');
        $body['thumbnail'] = $req->files('thumbnail')->show();
        
        
        // Valdiate request data
        $validation = new Validation();
        $errors = $validation
                ->with($body)
                ->rules([
                    'title|Title' => 'required|valid_input|max[200]',
                    'body|Body' => 'string',
                    'description|Description' => 'valid_input|max[300]',
                    'thumbnail|Thumbnail' => 'ext[jpg,jpeg,gif,bmp,png]',
                    'categories|Categories' => 'required|numeric|max[5]'
                ])
                ->validate();
        
        
        // If errors
        if (!empty($errors)) {
            unset($body['body']);
            setForm($body); // Save the form in cookies
            setFlashData('errors', $errors);
            
            return $res->redirect(baseUrl('article/new'));
        }
        unset($body['categories']);
        
        
        $content = $req->body('body');
        ///////////// Save base64 image as file /////////////
        // Check if image inside the content
        preg_match_all('/src="data:image(.*)"/', $content, $matches);

        // Generate image name with save location
        $imageSavePath = dirname(APPROOT).'/public/assets/tinyeditor/filemanager/files/images/';

        if (!empty($matches[1])) {
            // Convert base63 to image and save to the provided location with random name
            $savedImagesArray = base64_to_jpeg($matches[1], $imageSavePath);

            // Replace base64 images to real images
            foreach ($savedImagesArray as $src) 
                $content = preg_replace('#(<img\s(?>(?!src=)[^>])*?src=")data:image/(gif|png|jpeg);base64,([\w=+/]++)("[^>]*>)#', "<img src=\"{$src}\" alt=\"\" title=\"\" />", $content);
        }

        // Prepare image src's to save, create absolute path placeholder '%RELEVANT_PATH%'
        $content = relevantpath($content, false);
        ///////////// Save base64 image as file - END /////////////
        $body['body'] = $content;
        
        
        // Upload thumbnail
        if (!$req->files('thumbnail')->show('error')) {
            $imgName = 'svp.ge_'.bin2hex(random_bytes(20));
            $file = $req->files('thumbnail')->upload(dirname(APPROOT) . '/public/assets/tinyeditor/filemanager/files/images', $imgName);
            $image = new ImageResize($file);
            $image->resizeToLongSide(900);
            $image->save($file);
            $body['thumbnail'] = 'images/'.$imgName . '.' . pathinfo($file)['extension'];
        }
                
        
        // Insert article with categories
        $article = R::dispense('articles');
        $article = $article->import($body);
        
        foreach ($req->body('categories') as $catID) {
            $article->sharedCategoriesList[] = R::load('categories', $catID);
            $article->users = R::load('users', $_SESSION['userid']);
        }
        
        $id = R::store($article);
        
        // Redirect with message
        setFlashData('success', 'სტატია გამოქვეყნდა წარმატებით');
        return $res->redirect(baseUrl('articles'));
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
        
        $categoriesModel = initModel('categories');
        $categories = $categoriesModel->categoryList();
        
        $article = $this->articlesModel->loadArticle($id);
        $usedCategories = json_decode(json_encode($article->sharedCategories), true);
        
        return $res->render('back/articles/edit', [
            'article' => $article,
            'usedCategories' => $usedCategories,
            'categories' => $categories
        ]);
    }


    // Update
    public function update($req, $res) {
        $id = $req->getSegment(2);
        
        
        $slugify = new Slugify();
        
        // Prepare content
        $body = $req->body();
        unset($body['csrf_token']);
        unset($body['_method']);
        
        $body['title'] = strip_tags($body['title']);
        $body['url'] = $slugify->slugify($body['title']);
        $body['description'] = strip_tags($body['description'] ?? '');
        $body['description'] = str_replace(array("\r", "\n"), '', $body['description'] ?? '');
        $body['body'] = relevantPath($body['body'], false);
        $body['timestamp'] = time();
        $body['keywords'] = strip_tags($body['keywords'] ?? '');
        $body['thumbnail'] = $req->files('thumbnail')->show();
        
        
        // Valdiate request data
        $validation = new Validation();
        $errors = $validation
                ->with($body)
                ->rules([
                    'title|Title' => 'required|valid_input|max[200]',
                    'body|Body' => 'string',
                    'description|Description' => 'valid_input|max[300]',
                    'thumbnail|Thumbnail' => 'ext[jpg,jpeg,gif,bmp,png]',
                    'categories|Categories' => 'required|numeric|max[5]',
                    'thumbnail_hidden' => 'valid_input|max[200]'
                ])
                ->validate();
        
        
        // If errors
        if (!empty($errors)) {
            unset($body['body']);
            setForm($body); // Save the form in cookies
            setFlashData('errors', $errors);
            
            return $res->redirect(baseUrl('article/' . $id . '/edit'));
        }
        unset($body['categories']);
        
        $article = $this->articlesModel->loadArticle($id);
        
        $content = $req->body('body');
        ///////////// Save base64 image as file /////////////
        // Check if image inside the content
        preg_match_all('/src="data:image(.*)"/', $content, $matches);

        // Generate image name with save location
        $imageSavePath = dirname(APPROOT).'/public/assets/tinyeditor/filemanager/files/images/';

        if (!empty($matches[1])) {
            // Convert base63 to image and save to the provided location with random name
            $savedImagesArray = base64_to_jpeg($matches[1], $imageSavePath);

            // Replace base64 images to real images
            foreach ($savedImagesArray as $src) 
                $content = preg_replace('#(<img\s(?>(?!src=)[^>])*?src=")data:image/(gif|png|jpeg);base64,([\w=+/]++)("[^>]*>)#', "<img src=\"{$src}\" alt=\"\" title=\"\" />", $content);
        }

        // Prepare image src's to save, create absolute path placeholder '%RELEVANT_PATH%'
        $content = relevantpath($content, false);
        ///////////// Save base64 image as file - END /////////////
        $body['body'] = $content;
        
        
        // Upload thumbnail
        if (!$req->files('thumbnail')->show('error')) {
            $imgName = 'svp.ge_'.bin2hex(random_bytes(20));
            $file = $req->files('thumbnail')->upload(dirname(APPROOT) . '/public/assets/tinyeditor/filemanager/files/images', $imgName);
            $image = new ImageResize($file);
            $image->resizeToLongSide(900);
            $image->save($file);
            $body['thumbnail'] = 'images/'.$imgName . '.' . pathinfo($file)['extension'];
        } else {
            $body['thumbnail'] = $req->body('thumbnail_hidden');
        }
        
        if (empty($body['thumbnail'])) $body['thumbnail'] = null;
        unset($body['thumbnail_hidden']);
        
        // Update article
        $article->import($body);
        $article->sharedCategoriesList = [];
        foreach ($req->body('categories') as $catID) {
            $article->sharedCategoriesList[] = R::load('categories', $catID);
            $article->users = R::load('users', $_SESSION['userid']);
        }
        $id = R::store($article);
        
        // Redirect with message
        setFlashData('success', 'სტატია წარმატებით განახლდა');
        return $res->redirect(baseUrl('article/'.$id.'/edit'));

    }


    // Delete
    public function delete($req, $res) {
        $id = $req->getSegment(2);
    }

}