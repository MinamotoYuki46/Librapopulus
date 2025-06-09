<?php

namespace App\Controllers;

use App\Models\FriendshipModel;
use App\Models\GroupMessagesModel;
use App\Models\UserModel;
use App\Models\GroupMembersModel;
use App\Models\GroupsModel;

class Community extends BaseController {
    private $userModel;
    private $groupsModel;
    private $friendshipModel;
    private $groupMembersModel;
    private $groupMessageModel;

    public function __construct(){
        $this -> userModel = new UserModel();
        $this -> friendshipModel = new FriendshipModel();
        $this -> groupMembersModel = new GroupMembersModel();
        $this -> groupsModel = new GroupsModel();
        $this -> groupMessageModel = new GroupMessagesModel();
    }

    private function isLogin() {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('auth/login'));
        }
    }

    public function index(){
        $this -> isLogin();

        $userId = session() -> get('userId');

        $friends = $this -> friendshipModel -> getFriends($userId);
        $groups = $this -> groupMembersModel -> getGroupsByUserId($userId);

        $data = [
            "friends" => $friends,
            "groups"  => $groups
        ];

        return view("main/community/community", $data);
    }

    public function createGroup(){
        return view("main/community/creategroup");
    }

    public function proceedCreateGroup() {
        $rules = [
            'group_name' => 'required|min_length[3]|max_length[100]|is_unique[groups.name]',
            'description' => 'permit_empty|max_length[500]',
            'group_icon' => [
                'rules' => 'max_size[group_icon,2048]|is_image[group_icon]|mime_in[group_icon,image/jpg,image/jpeg,image/png,image/webp]',
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $slug = url_title($this-> request -> getPost('group_name'), '-', true);
        
        $groupData = [
            'name'        => $this -> request -> getPost('group_name'),
            'slug'        => $slug,
            'description' => $this -> request -> getPost('description'),
            'created_by'  => session() -> get('userId'),
        ];

        $iconFile = $this->request->getFile('group_icon');

        if ($iconFile && $iconFile->isValid() && !$iconFile->hasMoved()) {
            helper('url');
            

            $uploadPath = 'uploads/groups/' . $slug;

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $randomName = $iconFile->getRandomName();

            $iconFile->move($uploadPath, $randomName);

            $groupData['icon'] = $slug . '/' . $randomName;
        }

        $this -> groupsModel -> save($groupData);

        $newGroupId = $this -> groupsModel -> getInsertId();
        $this -> groupMembersModel -> save([
            'group_id' => $newGroupId,
            'user_id'  => session() -> get("userId"),
            'role'     => 'admin'
        ]);

        return redirect()->to('/community') -> with('success', 'Grup berhasil dibuat!');

    }

    public function group(string $slug) {
        $this -> isLogin();

        $group = $this -> groupsModel -> getGroupBySlug($slug);
        if (!$group) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Grup tidak ditemukan.');
        }

        if (!$this -> groupMembersModel -> isMember(session() -> get("userId"), $group['id'])) {
            return redirect()->to('/community')->with('error', 'Anda tidak memiliki akses ke grup ini.');
        }

        $members = $this -> groupMembersModel -> getMembersByGroupId($group['id']);
        $messages = $this -> groupMessageModel -> getMessagesByGroup($group['id']);

        $data = [
            "group" => $group,
            "members" => $members,
            "messages" => $messages
        ];

        return view("main/community/group", $data);
    }

    public function groupSendMessage(){
        $groupId = $this->request->getPost('group_id');
        $groupSlug = $this->request->getPost('group_slug');

        if (!$this -> groupMembersModel -> isMember(session() -> get("userId"), $groupId)) {
            return redirect()->to('/community') -> with('error', 'Akses ditolak.');
        }

        $rules = ['message_text' => 'required|max_length[4096]'];
        if (!$this->validate($rules)) {
            return redirect()->to('/group/' . $groupSlug) -> withInput();
        }

        $data = [
            'group_id'     => $groupId,
            'sender_id'    => session() -> get("userId"),
            'message_text' => $this->request->getPost('message_text') 
        ];

        $logMessage = "Preparing to save group message. Data types: " .
                  "group_id => " . gettype($data['group_id']) . ", " .
                  "sender_id => " . gettype($data['sender_id']) . ", " .
                  "message_text => " . gettype($data['message_text']);
    
        log_message('debug', $logMessage);

        $this -> groupMessageModel -> save($data);
        return redirect()->to('/group/' . $groupSlug);
    }
}