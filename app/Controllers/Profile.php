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
            'photoProfile'      => $dataUser["picture"],
            "friendCount"       => $friendCount,
            "bookCount"         => $bookCount,
        ];

        return view('main/profile/selfprofile', $data);
    }

    public function editProfile() {
        $userId = session() -> get("userId");
        $dataUser = $this -> userModel -> getDataUser($userId);

        $user = [
            'username'          => $dataUser['username'],
            'fullname'          => $dataUser["full_name"],
            'city'              => $dataUser["city"],
            'province'          => $dataUser["province"],
            'description'       => $dataUser["description"],
            'photoProfile'      => $dataUser["picture"],
        ];

        return view("main/profile/editprofile", ['user' => $user]);
    }

    public function update() {
        $userId = session()->get('userId');
        $dataUser = $this->userModel->getDataUser($userId);

        if (!$dataUser) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pengguna tidak ditemukan.');
        }

        $rules = [
            'username' => 'required|min_length[3]|max_length[50]' . ($this->request->getPost('username') !== $dataUser['username'] ? '|is_unique[user.username]' : ''),
            'fullname' => 'required|min_length[3]|max_length[100]',
            'city' => 'permit_empty|max_length[100]',
            'province' => 'permit_empty|max_length[100]',
            'description' => 'permit_empty|max_length[500]',
            'photoProfile' => [
                'rules' => 'max_size[photoProfile,2048]|is_image[photoProfile]|mime_in[photoProfile,image/jpg,image/jpeg,image/png,image/webp]',
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'full_name' => $this->request->getPost('fullname'),
            'city' => $this->request->getPost('city'),
            'province' => $this->request->getPost('province'),
            'description' => $this->request->getPost('description'),
        ];

        $photoProfile = $this->request->getFile('photoProfile');
        if ($photoProfile && $photoProfile->isValid() && !$photoProfile->hasMoved()) {
            if ($dataUser['picture'] && file_exists('Uploads/' . $dataUser['picture'])) {
                unlink('Uploads/' . $dataUser['picture']);
            }

            $randomName = $photoProfile->getRandomName();
            $photoProfile->move('Uploads', $randomName);
            $data['picture'] = $randomName;
        }

        $this->userModel->update($userId, $data);

        $newSessionData = [
            'userId' => $userId,
            'username' => $data['username'],
            'picture' => $data['picture'] ?? $dataUser['picture'],
            'isLoggedIn' => true
        ];

        session()->set($newSessionData);

        return redirect()->to(base_url('profile/' . $data['username']))->with('success', 'Profil berhasil diperbarui.');
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
            'targetUsername'    => $username,
            'fullname'          => $targetUser["full_name"],
            'city'              => $targetUser["city"],
            'province'          => $targetUser["province"],
            'description'       => $targetUser["description"],
            'otherPhotoProfile' => $targetUser["picture"],
            "friendCount"       => $friendCount,
            "bookCount"         => $bookCount,
            'friendship'        => $friendships,
            'myId'              => $user1,
            'targetId'          => $user2,
        ];

        return view('main/profile/otherprofile', $data);
    }

    public function friend() {
        $myId = session()->get('userId');
        
        $friends = $this->friendshipModel->getFriendsWithLastMessage($myId);
        
        $data = ['friends' => $friends];

        return view("main/profile/friend", $data);
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