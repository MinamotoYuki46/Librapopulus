<?php

namespace App\Controllers;

class Profile extends BaseController {
    public function index(){
        return view("main/profile/selfprofile");
    }

    public function otherProfile() {
        return view("main/profile/otherprofile");
    }
}