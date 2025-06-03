<?php

namespace App\Controllers;


class Auth extends BaseController {
    public function index()    {
        return redirect() -> to(base_url('auth/login'));
    }
    
    public function login() {
        if (session() -> get('isLoggedIn')) {
            return redirect() -> to(base_url('dashboard'));
        }
        
        return view('auth/login');
    }
    
    public function register() {
        if (session() -> get('isLoggedIn')) {
            return redirect() -> to(base_url('dashboard'));
        }
        
        return view('auth/register');
    }
    
    public function processLogin() {
        // TODO
    }
    
    public function processRegister() {
       // TODO
    }
    
    public function logout() {
        session() -> destroy();
        
        return redirect() -> to(base_url());
    }
}