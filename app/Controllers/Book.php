<?php 

namespace App\Controllers;

class Book extends BaseController {

    public function index(){
        return view("main/bookdetail");
    }
}