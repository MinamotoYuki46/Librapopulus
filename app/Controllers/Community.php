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

        $isAdmin = $this->groupMembersModel->where([
            'group_id' => $group['id'],
            'user_id' => session()->get('userId'),
            'role' => 'admin'
        ])->first() ? true : false;

        if (!$this -> groupMembersModel -> isMember(session() -> get("userId"), $group['id'])) {
            return redirect()->to('/community')->with('error', 'Anda tidak memiliki akses ke grup ini.');
        }

        $members = $this -> groupMembersModel -> getMembersByGroupId($group['id']);

        $latestMessages = $this->groupMessageModel
        ->select('group_messages.*, user.username as sender_username, user.picture as sender_picture')
        ->join('user', 'user.id = group_messages.sender_id')
        ->where('group_messages.group_id', $group['id'])
        ->orderBy('group_messages.id', 'DESC')
        ->findAll(20);

        $totalMessages = $this->groupMessageModel->where('group_id', $group['id'])->countAllResults();
        $hasMoreMessages = $totalMessages > 20;

        $messages = array_reverse($latestMessages);

        $data = [
            "group" => $group,
            "members" => $members,
            "messages" => $messages,
            "isAdmin" => $isAdmin,
            "hasMoreMessages" => $hasMoreMessages
        ];

        return view("main/community/group", $data);
    }

    public function editGroup($slug){
        $this->isLogin();

        $group = $this->groupsModel->getGroupBySlug($slug);
        if (!$group) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Grup tidak ditemukan.');
        }

        $isAdmin = !empty($this->groupMembersModel->where([
            'group_id' => $group['id'],
            'user_id' => session()->get('userId'),
            'role' => 'admin'
        ])->first());

        if (!$isAdmin) {
            return redirect()->to('/community')->with('error', 'Anda tidak memiliki izin untuk mengedit grup ini.');
        }

        $data = [
            'group' => $group
        ];

        return view("main/community/editgroup", $data);
    }

    public function proceedEditGroup($slug){
                $group = $this->groupsModel->getGroupBySlug($slug);
        if (!$group) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Grup tidak ditemukan.');
        }

        $isAdmin = !empty($this->groupMembersModel->where([
            'group_id' => $group['id'],
            'user_id' => session()->get('userId'),
            'role' => 'admin'
        ])->first());

        if (!$isAdmin) {
            return redirect()->to('/community')->with('error', 'Anda tidak memiliki izin untuk mengedit grup ini.');
        }

        $rules = [
            'group_name' => 'required|min_length[3]|max_length[100]' . ($this->request->getPost('group_name') !== $group['name'] ? '|is_unique[groups.name]' : ''),
            'description' => 'permit_empty|max_length[500]',
            'group_icon' => [
                'rules' => 'max_size[group_icon,2048]|is_image[group_icon]|mime_in[group_icon,image/jpg,image/jpeg,image/png,image/webp]',
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $newSlug = $this->request->getPost('group_name') !== $group['name'] ? url_title($this->request->getPost('group_name'), '-', true) : $group['slug'];

        $groupData = [
            'id' => $group['id'],
            'name' => $this->request->getPost('group_name'),
            'slug' => $newSlug,
            'description' => $this->request->getPost('description'),
        ];

        $iconFile = $this->request->getFile('group_icon');
        if ($iconFile && $iconFile->isValid() && !$iconFile->hasMoved()) {
            if ($group['icon'] && file_exists('uploads/groups/' . $group['icon'])) {
                unlink('Uploads/groups/' . $group['icon']);
            }

            $uploadPath = 'Uploads/groups/' . $newSlug;
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $randomName = $iconFile->getRandomName();
            $iconFile->move($uploadPath, $randomName);
            $groupData['icon'] = $newSlug . '/' . $randomName;
        }

        $this->groupsModel->save($groupData);

        return redirect()->to('/group/' . $newSlug)->with('success', 'Grup berhasil diperbarui!');
    }

    public function groupSendMessage(){
        $groupId = $this->request->getPost('group_id');
        $groupSlug = $this->request->getPost('group_slug');

        if (!$this->groupMembersModel->isMember(session()->get("userId"), $groupId)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => false, 'error' => 'Akses ditolak.'])->setStatusCode(403);
            }
            return redirect()->to('/community')->with('error', 'Akses ditolak.');
        }

        $rules = ['message_text' => 'required|max_length[4096]'];   
        if (!$this->validate($rules)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => false, 'error' => 'Pesan tidak boleh kosong.'])->setStatusCode(400);
            }
            return redirect()->to('/group/' . $groupSlug)->withInput();
        }

        $data = [
            'group_id'     => $groupId,
            'sender_id'    => session() -> get("userId"),
            'message_text' => $this->request->getPost('message_text') 
        ];

        if ($this->groupMessageModel->save($data)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success'   => true,
                    'csrf_hash' => csrf_hash()
                ]);
            }
        
            return redirect()->to('/group/' . $groupSlug);
        }
    }

    public function deleteGroup($groupId){
        $isAdmin = $this->groupMembersModel->where([
            'group_id' => $groupId,
            'user_id' => session()->get('userId'),
            'role' => 'admin'
        ])->first();

        if (!$isAdmin) {
            return redirect()->to('/community')->with('error', 'Anda tidak memiliki izin untuk menghapus grup tersebut.');
        }

        $group = $this->groupsModel->find($groupId);
        if ($group && !empty($group['icon'])) {
            $iconPath = FCPATH . 'uploads/groups/' . $group['icon'];
            if (file_exists($iconPath)) {
                unlink($iconPath);
                $groupFolder = dirname($iconPath);
                if (is_dir($groupFolder) && count(scandir($groupFolder)) == 2) {
                    rmdir($groupFolder);
                }
            }
        }

        $this->groupMembersModel->where('group_id', $groupId)->delete();

        $this->groupsModel->delete($groupId);

        return redirect()->to('/community')->with('success', 'Grup berhasil dihapus.');
    }

<<<<<<< HEAD
    public function members(string $slug){
        $group = $this -> groupsModel -> where('slug', $slug) -> first();

        if (!$group) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $masterUserId = session('userId');
        $username = session('username'); 

        if (!$this -> groupMembersModel -> isMember($group['id'], $masterUserId)) {
            return redirect()->to(base_url('groups'))->with('error', 'Anda tidak memiliki akses ke pengaturan anggota grup ini.');
        }

        $currentUserRole = $this -> groupMembersModel -> getMemberRole($group['id'], $masterUserId);
=======
    public function fetchMessages($groupId, $lastMessageId){
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403, 'Forbidden');
        }

        $newMessages = $this->groupMessageModel
        ->select('group_messages.*, user.username as sender_username, user.picture as sender_picture')
        ->join('user', 'user.id = group_messages.sender_id')
        ->where('group_messages.group_id', $groupId)
        ->where('group_messages.id >', $lastMessageId)
        ->orderBy('group_messages.id', 'ASC')
        ->findAll();

        return $this->response->setJSON($newMessages);
    }

    public function fetchPrevMessages($groupId, $oldestMessageId){
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403, 'Forbidden');
        }

        $previousMessages = $this->groupMessageModel
        ->select('group_messages.*, user.username as sender_username, user.picture as sender_picture')
        ->join('user', 'user.id = group_messages.sender_id')
        ->where('group_messages.group_id', $groupId)
        ->where('group_messages.id <', $oldestMessageId)
        ->orderBy('group_messages.id', 'DESC')
        ->findAll(20);

        $oldestIdInBatch = !empty($previousMessages) ? end($previousMessages)['id'] : 0;
        $moreMessagesCount = 0;
        if($oldestIdInBatch > 0){
            $moreMessagesCount = $this->groupMessageModel->where('group_id', $groupId)
                                                        ->where('id <', $oldestIdInBatch)
                                                        ->countAllResults();
        }

        return $this->response->setJSON(['messages' => array_reverse($previousMessages), 'hasMore' => $moreMessagesCount > 0]);
>>>>>>> 2b9a2478a6df02f3f55c98b862695b9622300221
    }
}