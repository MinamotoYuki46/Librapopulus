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

    public function library($username = null){
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to(base_url('auth/login'));
        }

        $loggedInUserId = $session->get('userId');
        $loggedInUser = $this->userModel->find($loggedInUserId);

        if ($username === null) {
            $user = $loggedInUser;
        } else {
            $user = $this->userModel->where('username', $username)->first();

            if (!$user) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("User $username not found.");
            }

            // Jika username sama dengan yang login, redirect ke /library tanpa username
            if ($user['username'] === $loggedInUser['username']) {
                return redirect()->to(base_url('library'));
            }
        }

        $data = [
            'userId'         => $user['id'],
            'username'       => $user['username'],
            'photoProfile'   => $user['picture'] ?? null,
            'userCollection' => $this->bookCollectionModel->getBookCollectionByUserId($user['id'])
        ];

        $data['isOwnProfile'] = ($user['id'] == $loggedInUserId);
        $data['fullname'] = $user['full_name'];

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
