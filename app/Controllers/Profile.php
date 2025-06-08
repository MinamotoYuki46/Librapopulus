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

    public function index(string $username) {
        if (!session() -> get('isLoggedIn')) {
            return redirect() -> to(base_url('auth/login'));
        }

        $currentUsername = session() -> get('username');

        if ($username === $currentUsername) {
            return $this -> selfProfile();
        } else {
            return $this -> otherProfile($username);
        }
    }

    private function selfProfile() {
        $userId = session() -> get('userId');
        $dataUser = $this -> userModel -> getDataUser($userId);
        $bookCount = $this -> bookCollectionModel -> getBookCount($userId);
        $friendCount = $this -> friendshipModel -> getFriendCount($userId);

        $data = [
            'username'          => $dataUser['username'],
            'fullname'          => $dataUser["full_name"],
            'city'              => $dataUser["city"],
            'province'          => $dataUser["province"],
            'description'       => $dataUser["description"],
            'favoriteGenres'    => $dataUser["favorite_genres"],
            'photoProfile'      => $dataUser["picture"],
            "friendCount"       => $friendCount,
            "bookCount"         => $bookCount,
        ];

        return view('main/profile/selfprofile', $data);
    }

    private function otherProfile(string $username) {
        $targetUser = $this -> userModel -> getDataUserByUsername($username);

        if (!$targetUser) {
            throw new PageNotFoundException('User tidak ditemukan.');
        }

        $bookCount = $this -> bookCollectionModel -> getBookCount($targetUser["id"]);
        $friendCount = $this -> friendshipModel -> getFriendCount($targetUser["id"]);

        $data = [
            'username'          => $targetUser['username'],
            'fullname'          => $targetUser["full_name"],
            'city'              => $targetUser["city"],
            'province'          => $targetUser["province"],
            'description'       => $targetUser["description"],
            'favoriteGenres'    => $targetUser["favorite_genres"],
            'photoProfile'      => $targetUser["picture"],
            "friendCount"       => $friendCount,
            "bookCount"         => $bookCount,
        ];

        return view('main/profile/otherprofile', $data);
    }


    public function message() {
        return view("main/profile/message");
    }

    public function friend() {
        return view("main/profile/friend");
    }
}