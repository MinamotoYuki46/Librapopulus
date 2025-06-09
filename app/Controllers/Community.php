<?php

namespace App\Controllers;

use App\Models\FriendshipModel;
use App\Models\UserModel;

class Community extends BaseController {
    private $userModel;
    private $friendshipModel;

    public function __construct(){
        $this -> userModel = new UserModel();
        $this -> friendshipModel = new FriendshipModel();
    }

    private function isLogin() {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('auth/login'));
        }
    }

    public function index(){
        $this -> isLogin();

        $userId = session() -> get('userId');

        $friends = $this -> friendshipModel -> getFriends($userId);

        $data = [
            "friends" => $friends
        ];

        return view("main/community/community", $data);
    }
}