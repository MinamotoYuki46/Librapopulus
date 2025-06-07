<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\FriendshipModel;
Use App\Models\BookCollectionModel;

class Profile extends BaseController {
    private $userModel;
    private $friendshipModel;
    private $bookCollectionModel;

    public function __construct() {
        $this -> userModel = new UserModel();
    }
    public function index($username) {
        $userId = session() -> get('userId');
        $user = $this -> userModel -> find($userId);

        $data = [
            "username"      => $user["username"],
            "fullname"      => $user["fullname"],
            'city'          => $user["city"],
            'province'      => $user["province"],
            'friend_count'  => $user[],
            'book_count'    => 17,
            'photo_url' => 'https://i.pravatar.cc/200?u=alice123',
            'biodata' => "Penggembar buku klasik"
        ]


        if ($username === $user["username"]) {
            return view("main/profile/selfprofile", $data);
        } else {
            return view("main/profile/otherprofile", $data);
        }
    }


    public function message() {
        return view("main/profile/message");
    }

    public function friend() {
        return view("main/profile/friend");
    }
}