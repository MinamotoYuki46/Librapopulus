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

    public function library($ownerUsername = null){
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to(base_url('auth/login'));
        }

        $loggedInUserId = $session->get('userId');
        $loggedInUser = $this->userModel->find($loggedInUserId);

        if ($ownerUsername === null) {
            $user = $loggedInUser;
        } else {
            $user = $this->userModel->where('username', $ownerUsername)->first();

            if (!$user) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("User $ownerUsername not found.");
            }

            if ($user['username'] === $loggedInUser['username']) {
                return redirect()->to(base_url('library'));
            }
        }

        $data = [
            'isOwnProfile' => $user['id'] == $loggedInUserId,
            'fullname' => $user['full_name'],
            'otherUsername' => $user['username'],
            'userCollection' => $this -> bookCollectionModel -> getBookCollectionByUserId($user['id'])
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
