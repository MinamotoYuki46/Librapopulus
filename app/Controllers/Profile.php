<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\BookCollectionModel;
use App\Models\FriendshipModel;
use App\Models\MessageModel;
use CodeIgniter\Exceptions\PageNotFoundException;


class Profile extends BaseController {
    private $userModel;
    private $bookCollectionModel;
    private $friendshipModel;
    private $messageModel;

    public function __construct() {
        $this -> userModel = new UserModel();
        $this -> bookCollectionModel = new BookCollectionModel();
        $this -> friendshipModel = new FriendshipModel();
        $this -> messageModel = new MessageModel();
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
        $user1 = session() -> get('userId');
        $user2 = $targetUser['id'];
        $friendships = $this -> friendshipModel -> getFriendshipStatus($user1, $user2);

        $data = [
            'username'          => $username,
            'fullname'          => $targetUser["full_name"],
            'city'              => $targetUser["city"],
            'province'          => $targetUser["province"],
            'description'       => $targetUser["description"],
            'favoriteGenres'    => $targetUser["favorite_genres"],
            'otherPhotoProfile' => $targetUser["picture"],
            "friendCount"       => $friendCount,
            "bookCount"         => $bookCount,
            'friendship'        => $friendships,
            'myId'              => $user1,
            'targetId'          => $user2,
        ];

        return view('main/profile/otherprofile', $data);
    }


    public function message(string $username) {
        $targetUser = $this -> userModel -> getDataUserByUsername($username);
        

        if (!$targetUser) {
            throw new PageNotFoundException('User tidak ditemukan.');
        }

        $targetUser['username'] = $username;
        $myUser = [
            'id' => session()->get('userId'),
            'username' => session()->get('username'),
            'picture' => session()->get('picture')
        ];
        

        $data = [
            'recipient' => $targetUser,
            'messages' => $this->messageModel->getConversation($myUser['id'], $targetUser['id']),
            'currentUser' => $myUser
        ];

        return view("main/profile/message", $data);
    }

    public function friend() {
        return view("main/profile/friend");
    }

    public function send(){
        $senderId = session()->get('userId');
        $receiverId = $this->request->getPost('receiverId');
        $messageText = $this->request->getPost('message');
        $targetUsername = $this->request->getPost('username');

        $this->messageModel->insert([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'message_text' => $messageText
        ]);

        return redirect()->to(base_url('profile/message/' . $targetUsername));
    }
}