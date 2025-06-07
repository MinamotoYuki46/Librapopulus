<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\BookCollectionModel;
use App\Models\FriendshipModel;


class Profile extends BaseController {
    private $userModel;
    private $bookCollectionModel;
    private $friendshipModel;

    public function __construct() {
        $this -> userModel = new UserModel();
        $this -> bookCollectionModel = new BookCollectionModel();
        $this -> friendshipModel = new FriendshipModel();
    }

    public function index(){
        if (!session() -> get('isLoggedIn')) {
            return redirect() -> to(base_url('auth/login'));
        }

        $userId = session()->get('user_id');

        $dataUser = $this->userModel->getDataUser($userId);
        $dataUser['book_count'] = $this->bookCollectionModel->getBookCount($userId);
        $dataUser['friend_count'] = $this->friendshipModel->getFriendCount($userId);

        $data = [
            'user' => $dataUser,
            'photoProfile' => $dataUser['picture'],
            'username' => $dataUser['username']
        ];

        return view("main/profile/selfprofile", $data);
    }


    public function message() {
        return view("main/profile/message");
    }

    public function friend() {
        return view("main/profile/friend");
    }
}