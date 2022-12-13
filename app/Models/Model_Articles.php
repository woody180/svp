<?php
        
class Model_Articles extends RedBean_SimpleModel {

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
    
    
    
    public function random()
    {
        $res = R::getAll('SELECT a.id, a.title, a.url, a.description, a.thumbnail, 
        GROUP_CONCAT(c.id) AS cat_id, 
        GROUP_CONCAT(c.title) as cat_title, 
        GROUP_CONCAT(c.url)  as cat_url
    FROM articles a INNER JOIN articles_categories ac ON a.id = ac.articles_id 
    INNER JOIN categories c ON ac.categories_id = c.id 
    GROUP BY a.id, a.title, a.url, a.description, a.thumbnail
    ORDER BY RAND() limit 20');
        
        $data = toJSON($res);
        return json_decode($data);
    }
    
    
    
    public function allArticles()
    {
        
        $totalPages = R::count('articles');
        $currentPage = $_GET["page"] ?? 1;
        if ($currentPage < 1 OR $currentPage > $totalPages) $currentPage = 1;
        $limit = 12;
        $offset = ($currentPage - 1) * $limit;  
        $pagingData = pager([
            'total' => $totalPages,
            'limit' => $limit,
            'current' => $currentPage
        ]);
        
        
        
        
        $res = R::getAll("with groups_gr as 
            (
                SELECT  a.title, a.id, a.url, a.thumbnail, a.timestamp, a.description,
                group_concat(c.title) as categories, 
                group_concat(c.id) as cat_id, 
                group_concat(c.url) as cat_url 
                FROM categories c 
                INNER join articles_categories ac on c.id=ac.categories_id 
                INNER join articles a  on a.id=ac.articles_id 
                GROUP BY a.title, a.id, a.url, a.thumbnail, a.timestamp, a.description 
                ORDER BY a.id ASC 
            )
            select a.title, a.id, a.url, a.thumbnail, a.timestamp, a.description, g.categories, g.cat_id, g.cat_url 
            FROM categories c 
            INNER join articles_categories ac on c.id=ac.categories_id 
            INNER join articles a  on a.id=ac.articles_id 
            INNER JOIN groups_gr g on g.id = a.id 
            GROUP BY a.title, a.id, a.url, a.thumbnail, a.timestamp, a.description, g.categories, g.cat_id, g.cat_url 
            ORDER BY a.id DESC 
            LIMIT $limit OFFSET $offset");
        
        
        $obj = new stdClass();
        $obj->pager = $totalPages > $limit ? $pagingData : null;
        $obj->data = json_decode(json_encode($res));
        
        return $obj;
    }
    
    
    
    public function articles($title = null, $ascDsc = 'DESC')
    {
        
        $sql = $title ? " WHERE a.title LIKE ? " : " ";
        $argsArray = [];
        if (!is_null($title)) $argsArray[] = "%{$title}%";
        
        //dd($argsArray);
        
        $totalPages = !is_null($title) ? R::count('articles', 'title LIKE ?', $argsArray) : R::count('articles');
        $currentPage = $_GET["page"] ?? 1;
        if ($currentPage < 1 OR $currentPage > $totalPages) $currentPage = 1;
        $limit = 12;
        $offset = ($currentPage - 1) * $limit;  
        $pagingData = pager([
            'total' => $totalPages,
            'limit' => $limit,
            'current' => $currentPage
        ]); 
        $pages = R::getAll("SELECT "
            . "a.title, a.url, a.id, a.thumbnail, a.description "
            . "FROM articles a "
            . "$sql"
            . "ORDER BY a.id $ascDsc "
            . "limit $limit offset $offset", $argsArray);

        $obj = new stdClass();
        $obj->articles = json_decode(json_encode($pages));
        $obj->pager = $totalPages > $limit ? $pagingData : '';

        return $obj;
    }
    
    
    public function latestArticles($limit = 10) {

        // R::fancyDebug();
        
        $res = R::getAll('SELECT a.id, a.title, a.url, a.description, a.thumbnail, 
        GROUP_CONCAT(c.id) AS cat_id, 
        GROUP_CONCAT(c.title) as cat_title, 
        GROUP_CONCAT(c.url)  as cat_url
    FROM articles a INNER JOIN articles_categories ac ON a.id = ac.articles_id 
    INNER JOIN categories c ON ac.categories_id = c.id 
    GROUP BY a.id, a.title, a.url, a.description, a.thumbnail
    ORDER BY a.id DESC LIMIT ?', [$limit]);
        
        $data = toJSON($res);
        return json_decode($data);
    }
    
    
    public function similar() {
        $url = urlSegments('last', true);
        $where = is_numeric($url) ? 'WHERE a.id = ? ' : 'WHERE a.url = ? ';
        
        $cateogry = R::getAll('SELECT '
                . 'c.id as cat_id, c.url as cat_url '
                . 'FROM articles a '
                . 'INNER JOIN articles_categories ac '
                . 'ON a.id = ac.articles_id '
                . 'INNER JOIN categories c '
                . 'ON ac.categories_id = c.id '
                . $where
                . 'ORDER BY a.id DESC', [$url])[0];
        $cateogry = to_object($cateogry);
        $categoryID = $cateogry->cat_id;
        
        //R::fancyDebug();

        $res = R::getAll("with groups_gr as 
            (SELECT  a.title, a.id, a.url, a.thumbnail, a.timestamp, a.description,
            group_concat(c.title) as categories, 
            group_concat(c.id) as cat_id, 
            group_concat(c.url) as cat_url 
            FROM categories c 
            INNER join articles_categories ac on c.id=ac.categories_id 
            INNER join articles a  on a.id=ac.articles_id 
            GROUP BY a.title, a.id, a.url, a.thumbnail, a.timestamp, a.description 
            ORDER BY a.id ASC 
            )
            select a.title, a.id, a.url, a.thumbnail, a.timestamp, a.description, g.categories, g.cat_id, g.cat_url 
            FROM categories c 
            INNER join articles_categories ac on c.id=ac.categories_id 
            INNER join articles a  on a.id=ac.articles_id 
            INNER JOIN groups_gr g on g.id = a.id 
            WHERE c.id=? 
            GROUP BY a.title, a.id, a.url, a.thumbnail, a.timestamp, a.description, g.categories, g.cat_id, g.cat_url 
            ORDER BY RAND() 
            LIMIT 8 
            ", [$categoryID]);
        
        
        $obj = new stdClass();
        $data = toJSON($res);
        $obj->articles = json_decode($data);
        $obj->category = $cateogry;
        
        return $obj;
    }
    
    
    public function loadArticle($id) {
        if (is_numeric($id)) {
            return R::findOne('articles', 'id = ?', [$id]) ?? abort();
        }
        return R::findOne('articles', 'url = ?', [$id]) ?? abort();
    }
    
    
    
    public function insert($params) {
        $page = R::dispense('articles');
        $page->import($params);
        return R::store($page);
    }
}