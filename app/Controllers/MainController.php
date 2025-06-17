<?php

namespace App\Controllers;

use App\Models\BookCollectionModel;
use App\Models\BookModel;
use App\Models\UserModel;
use App\Models\GroupsModel;

class MainController extends BaseController {
    private $bookModel;
    private $bookCollectionModel;
    private $userModel;
    private $groupModel;
    private $db;

    public function __construct() {
        $this -> bookModel = new BookModel();
        $this -> bookCollectionModel = new BookCollectionModel();
        $this -> userModel = new UserModel();
        $this -> groupModel = new GroupsModel();
        $this -> db = \Config\Database::connect();
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
        $query = $this->request->getGet('query');

        $bookResults = [];
        $userResults = [];
        $groupResults = [];

        if(!empty($query)){
            $bookResults = $this -> bookModel
                ->like('title', $query)
                ->orLike('author', $query)
                ->findAll();
            
            log_message('info', 'Book search result for "{query}": {result}', [
                'query' => $query,
                'result' => json_encode($bookResults),
            ]);

            $userResults = $this->userModel
                ->groupStart()
                    ->like('full_name', $query)
                    ->orLike('username', $query)
                ->groupEnd()
                ->where('role', 'user')
                ->findAll();

            
            log_message('info', 'User search result for "{query}": {result}', [
                'query' => $query,
                'result' => json_encode($userResults),
            ]);

            $groupResults = $this-> db ->table('groups')
                ->select('groups.*, COUNT(group_members.user_id) as member_count')
                ->like('groups.name', $query)
                ->orLike('groups.slug', $query)
                ->join('group_members', 'group_members.group_id = groups.id', 'left')
                ->groupBy('groups.id')
                ->get()
                ->getResultArray();

            
            log_message('info', 'Group search result for "{query}": {result}', [
                'query' => $query,
                'result' => json_encode($groupResults),
            ]);

        }

        return view('main/search', [
            'query'        => $query,
            'bookResults'  => $bookResults,
            'userResults'  => $userResults,
            'groupResults' => $groupResults,
        ]);
    }


}
