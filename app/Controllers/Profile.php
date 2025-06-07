<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\BookCollectionModel;
use App\Models\FriendshipModel;
use CodeIgniter\Exceptions\PageNotFoundException;


class Profile extends BaseController {
    private $userModel;
    private $bookCollectionModel;
    private $friendshipModel;

    public function __construct() {
        $this -> userModel = new UserModel();
        $this -> bookCollectionModel = new BookCollectionModel();
        $this -> friendshipModel = new FriendshipModel();
    }

    public function index(string $username){
        if (!session() -> get('isLoggedIn')) {
            return redirect() -> to(base_url('auth/login'));
        }

        if ($username !== session()->get('username')){
            //untuk saat ini beri halaman error dulu karena rute other profile tidak ada
            throw new PageNotFoundException('User tidak ditemukan.');
        }

        $userId = session()->get('userId');

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