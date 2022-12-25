<?php
        
class Model_Categories extends RedBean_SimpleModel {

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
    
    
    public function loadCategory($catUrl, $title = null) {
        
        //R::fancyDebug();
        
        
        $sql = $title ? " AND a.title LIKE ? " : '';
        $argsArray = [$catUrl];
        if (!is_null($title)) $argsArray[] = "%{$title}%";
        
        $category = R::findOne('categories', 'url = ?', [$catUrl]) ?? abort();
        $totalPages = !is_null($title) ? $category->withCondition("title LIKE ?", ["%{$title}%"])->countShared('articles') : $category->countShared('articles');
        $currentPage = $_GET["page"] ?? 1;
        if ($currentPage < 1 OR $currentPage > $totalPages) $currentPage = 1;
        $limit = 16;
        $offset = ($currentPage - 1) * $limit;  
        $pagingData = pager([
            'total' => $totalPages,
            'limit' => $limit,
            'current' => $currentPage
        ]); 
        
        $res = R::getAll("with groups_gr as 
(SELECT  a.title, a.id, a.url, a.thumbnail, a.timestamp, a.description,
group_concat(c.title) as categories, 
group_concat(c.id) as cat_id,
group_concat(c.url) as cat_url 
FROM categories c 
INNER join articles_categories ac on c.id=ac.categories_id
INNER join articles a  on a.id=ac.articles_id 
GROUP BY a.title, a.id, a.url, a.thumbnail, a.timestamp, a.description 
)
select a.title, a.id, a.url, a.thumbnail, a.timestamp, a.description,g.categories,g.cat_id, g.cat_url 
FROM categories c 
INNER join articles_categories ac on c.id=ac.categories_id
INNER join articles a  on a.id=ac.articles_id 
INNER JOIN groups_gr g on g.id = a.id
WHERE c.url=?
{$sql}
group by a.title, a.id, a.url, a.thumbnail, a.timestamp, a.description,g.categories,g.cat_id 
ORDER BY a.id DESC 
limit $limit offset $offset", $argsArray);
        
        $data = toJSON($res);
        $data = json_decode($data);
        $obj = new stdClass();
        $obj->pager = $totalPages > $limit ? $pagingData : "";
        $obj->data = $data;
        $obj->title = $category->title;
        
        return $obj;
    }
    
    
    public function categoryList()
    {
        $data = R::getAll('SELECT id, title FROM categories ORDER BY id DESC');
        return json_decode(json_encode($data));
    }
}