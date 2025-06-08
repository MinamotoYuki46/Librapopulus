<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\MessageModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Message extends BaseController {

    private $userModel;
    private $messageModel;

    public function __construct() {
        $this -> userModel = new UserModel();
        $this -> messageModel = new MessageModel();
    }

    public function index(string $username) {
        $targetUser = $this -> userModel -> getDataUserByUsername($username);
        

        if (!$targetUser) {
            throw new PageNotFoundException('User tidak ditemukan.');
        }

        $targetUser['username'] = $username;
        $myUser = [
            'id' => session() -> get('userId'),
            'username' => session() -> get('username'),
            'picture' => session() -> get('picture')
        ];
        

        $data = [
            'recipient' => $targetUser,
            'messages' => $this -> messageModel -> getConversation($myUser['id'], $targetUser['id']),
            'currentUser' => $myUser
        ];

        return view("main/message", $data);
    }

    public function send(){
        $senderId = session()->get('userId');
        $receiverId = $this->request->getPost('receiverId');
        $messageText = $this->request->getPost('message');
        $targetUsername = $this->request->getPost('username');

        $this -> messageModel -> insert([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'message_text' => $messageText
        ]);

        return redirect()->to(base_url('/message/' . $targetUsername));
    }
}