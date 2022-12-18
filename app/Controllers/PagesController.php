<?php namespace App\Controllers;

use \R as R;

class PagesController {
    
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
        
        initModel('Pages');
        
        $page = R::findOne('page', 'url = ?', [$id]) ?? abort();
        
        return $res->render('page', [
            'page' => $page
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
        