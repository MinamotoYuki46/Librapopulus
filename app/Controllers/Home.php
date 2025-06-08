<?php

namespace App\Controllers;

class Home extends BaseController {
    public function index(){
        if (session() -> get('isLoggedIn')) {
            $main = new MainController;

            return $main -> library();
        } else {
            return view('welcome');
        }
    }
}