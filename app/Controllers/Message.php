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
            'messages' => [],
            'currentUser' => $myUser
        ];

        return view("main/message", $data);
    }

    public function send(){
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        $this->messageModel->insert([
            'sender_id'   => session()->get('userId'),
            'receiver_id' => $this->request->getPost('receiverId'),
            'message_text'=> $this->request->getPost('message')
        ]);

        return $this->response->setJSON(['status' => 'success']);
    }

    public function fetch($withUserId) {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        $offset = (int) $this->request->getGet('offset') ?? 0;

        $currentUserId = session()->get('userId');
        $message = $this->messageModel->getConversation($currentUserId, $withUserId, 20, $offset);

        $data = [
        'messages' => $message,
        'csrf_hash' => csrf_hash()
    ];

        return $this->response->setJSON($data);
    }

    public function fetchNew($withUserId) {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }
        
        $sinceId = (int) $this->request->getGet('since') ?? 0;
        $currentUserId = session()->get('userId');
        $messages = $this->messageModel->getNewMessages($currentUserId, $withUserId, $sinceId);

        return $this->response->setJSON([
            'messages' => $messages,
            'csrf_hash' => csrf_hash()
        ]);
    }
}