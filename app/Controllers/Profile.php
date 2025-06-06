<?php

namespace App\Controllers;

class Profile extends BaseController {
    public function index(){
        return view("main/profile/selfprofile");
    }

    public function otherProfile() {
        return view("main/profile/otherprofile");
    }

    public function message() {
        return view("main/profile/message");
    }

    public function friend() {
        return view("main/profile/friend");
    }
}