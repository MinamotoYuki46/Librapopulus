<?php

namespace App\Controllers;

use App\Models\BookCollectionModel;
use App\Models\BookModel;
use App\Models\UserModel;

class MainController extends BaseController {
    private $bookModel;
    private $bookCollectionModel;
    private $userModel;

    public function __construct() {
        $this -> bookModel = new BookModel();
        $this -> bookCollectionModel = new BookCollectionModel();
        $this -> userModel = new UserModel();
    }

    public function index() {
        if (!session() -> get('isLoggedIn')) {
            return redirect() -> to(base_url('auth/login'));
        }

        $userId = session() -> get('user_id');
        $user = $this -> userModel -> find($userId);

        $data = [
            'userId'         => $userId,
            'username'       => $user['username'] ?? 'Guest',
            'photoProfile'   => $user['picture'] ?? null,
            'userCollection' => $this -> bookCollectionModel -> getBookCollectionByUserId($userId)
        ];

        return view('main/home', $data);
    }

    public function library() {
        if (!session() -> get('isLoggedIn')) {
            return redirect() -> to(base_url('auth/login'));
        }

        $userId = session() -> get('user_id');
        $user = $this -> userModel -> find($userId);

        $data = [
            'user_id' => $userId,
            'username' => $user['username'] ?? null,
            'photoProfile'   => $user['picture'] ?? null,
            'userCollection' => $this -> bookCollectionModel -> getBookCollectionByUserId($userId)
        ];

        return view('main/library/library', $data);
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
