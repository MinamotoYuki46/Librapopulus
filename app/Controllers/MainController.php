<?php

namespace App\Controllers;

class MainController extends BaseController {
    public function index() {
        return view('main/home');
    }

    public function library() {
        return view('main/library/library');
    }

    public function search() {
        return view('main/search');
    }

    public function group() {
        return view("main/group");
    }

    public function groupMessage(){
        return view("main/group_message");
    }

    public function groupList(){
        return view("main/group_list");
    }
}
