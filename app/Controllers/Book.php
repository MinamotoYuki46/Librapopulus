<?php 

namespace App\Controllers;

class Book extends BaseController {

    public function index(){
        return view("main/library/bookdetail");
    }

    public function focus() {
        return view("main/library/focusmode");
    }
}