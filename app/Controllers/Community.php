<?php

namespace App\Controllers;

use App\Models\FriendshipModel;
use App\Models\GroupMessagesModel;
use App\Models\NotificationModel;
use App\Models\UserModel;
use App\Models\GroupMembersModel;
use App\Models\GroupsModel;
use CodeIgniter\HTTP\RedirectResponse;

class Community extends BaseController {
    private $userModel;
    private $groupsModel;
    private $friendshipModel;
    private $groupMembersModel;
    private $groupMessageModel;
    private $notificationModel;

    public function __construct(){
        $this -> userModel = new UserModel();
        $this -> friendshipModel = new FriendshipModel();
        $this -> groupMembersModel = new GroupMembersModel();
        $this -> groupsModel = new GroupsModel();
        $this -> groupMessageModel = new GroupMessagesModel();
        $this -> notificationModel = new NotificationModel();
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
            'role'     => 'admin',
            'status'   => 1
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

    public function members(string $slug){
        $group = $this -> groupsModel -> where('slug', $slug) -> first();

        if (!$group) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $masterUserId = session('userId');
        $username = session('username'); 

        if (!$this -> groupMembersModel -> isMember( $masterUserId, $group['id'])) {
            return redirect()->to(base_url('community'))->with('error', 'Anda tidak memiliki akses ke pengaturan anggota grup ini.');
        }

        $currentUserRole = $this -> groupMembersModel -> getMemberRole($group['id'], $masterUserId);
        log_message('debug', 'Current user role: ' . print_r($currentUserRole, true));


        if ($currentUserRole != 'admin') {
            return redirect()->to(base_url('group/' . $slug))->with('error', 'Anda tidak memiliki izin untuk mengelola anggota grup.');
        }

        $members = $this -> groupMembersModel -> getMembersByGroupId($group['id']);
        $isCurrentUserAdmin = $this-> groupMembersModel -> getMemberRole($group['id'], $masterUserId) === 'admin';

        $data = [
            'group'         => $group,
            'currentUserRole' => $currentUserRole,
            'members'       => $members,
            'isCurrentUserAdmin' => $isCurrentUserAdmin
        ];

        return view('main/community/groupmember', $data);
    }

    public function inviteMembers($groupSlug){
        $group = $this-> groupsModel ->where('slug', $groupSlug)->first();

        if (!$group) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $masterUserId = session('userId');
        $username = session('username');

        if (!$this->groupMembersModel->isMember($masterUserId, $group['id'],)) {
            return redirect()->to(base_url('groups'))->with('error', 'Anda bukan anggota grup ini.');
        }
        $currentUserRole = $this->groupMembersModel->getMemberRole($group['id'], $masterUserId);
        if (!in_array($currentUserRole, ['admin', 'creator'])) {
            return redirect()->to(base_url('group/' . $groupSlug))->with('error', 'Anda tidak memiliki izin untuk mengundang anggota.');
        }

        $searchQuery = $this->request->getGet('q'); 
        $foundUsers = []; 

        if ($searchQuery && strlen($searchQuery) >= 3) {
            $usersQuery = $this->userModel->select('id, username, email, full_name, picture')
                                    ->groupStart()
                                        ->like('username', $searchQuery, 'after')
                                        ->orLike('email', $searchQuery, 'after')
                                    ->groupEnd()
                                    ->where('role', 'user');


            $existingMembers = $this->groupMembersModel->select('user_id')->where('group_id', $group['id'])->findAll();
            $memberIds = array_column($existingMembers, 'user_id');
            if (!empty($memberIds)) {
                $usersQuery->whereNotIn('id', $memberIds);
            }

            $existingInvitations = $this-> groupMembersModel
                                    ->select('user_id')
                                    ->where('group_id', $group['id'])
                                    ->where('status', GroupMembersModel::STATUS_PENDING)
                                    ->findAll();
            $invitedIds = array_column($existingInvitations, 'recipient_id');
            if (!empty($invitedIds)) {
                $usersQuery->whereNotIn('id', $invitedIds);
            }
            
            $foundUsers = $usersQuery->findAll(10); 
        }
        
        $data = [
            'title'         => 'Undang Anggota Grup',
            'group'         => $group,
            'masterUserId'  => $masterUserId,
            'searchQuery'   => $searchQuery, 
            'foundUsers'    => $foundUsers,
            'user' => [
                'id' => $masterUserId,
                'username' => $username,
                'picture' => session('picture')
            ]
        ];

        return view('main/community/groupinvite', $data);
    }

    public function sendInvitation(): RedirectResponse {
        $groupId = $this->request->getPost('group_id');
        $recipientId = $this->request->getPost('user_id');

        $group = $this->groupsModel->find($groupId);
        if (!$group) {
            return redirect()->back()->with('error', 'Grup tidak ditemukan.');
        }

        $masterUserId = session('userId');

        if (!$this-> groupMembersModel -> getMemberRole($groupId, $masterUserId)) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengundang anggota.');
        }

        $recipient = $this->userModel->find($recipientId);
        if (!$recipient) {
            return redirect()->back()->with('error', 'Pengguna tidak ditemukan.');
        }

        if ($this->groupMembersModel->isMember( $recipientId, $groupId)) {
            return redirect()->back()->with('error', 'Pengguna sudah menjadi anggota grup ini.');
        }

        $existingInvitation = $this->groupMembersModel
                                 ->where('group_id', $groupId)
                                 ->where('user_id', $recipientId)
                                 ->where('status', GroupMembersModel::STATUS_PENDING)
                                 ->first();

        if ($existingInvitation) {
            return redirect()->back()->with('error', 'Pengguna ini sudah memiliki undangan pending untuk grup ini.');
        }

        $this -> groupMembersModel -> insert([
            'group_id'      => $groupId,
            'user_id'       => $recipientId,
            'status'        => GroupMembersModel::STATUS_PENDING,
        ]);

        $this -> notificationModel->insert([
            'user_id'     => $recipientId, 
            'sender_id'   => $masterUserId,
            'type'        => 'group_invitation',
            'related_id'  => $groupId,
            'message'     => 'mengirimi Anda permintaan bergabung ke grup.'
        ]);

        return redirect()->back()->with('success', 'Undangan berhasil dikirim!');
    }

    public function promote($groupId, $userId){
        $this->groupMembersModel
            ->where('group_id', $groupId)
            ->where('user_id', $userId)
            ->set(['role' => 'admin'])
            ->update();

        return redirect()->back()->with('success', 'Pengguna dipromosikan jadi admin.');
    }

    public function kick($groupId, $userId){
        $this->groupMembersModel
            ->where('group_id', $groupId)
            ->where('user_id', $userId)
            ->delete();

        return redirect()->back()->with('success', 'Anggota dikeluarkan dari grup.');
    }

    public function groupAccept($groupId){
        $userId = session('userId');

        $member = $this -> groupMembersModel
            ->where('group_id', $groupId)
            ->where('user_id', $userId)
            ->first();

        if (!$member || $member['status'] != GroupMembersModel::STATUS_PENDING) {
            return redirect()->back()->with('error', 'Undangan tidak valid.');
        }

        $this -> groupMembersModel
            ->where('group_id', $groupId)
            ->where('user_id', $userId)
            ->set(['status' => GroupMembersModel::STATUS_APPROVED])
            ->update();

            return redirect()->to(base_url('community'))->with('success', 'Berhasil bergabung!');
    }

    
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

    public function groupDecline($groupId){
        $userId = session('userId');

        $member = $this->groupMembersModel
            ->where('group_id', $groupId)
            ->where('user_id', $userId)
            ->first();

        if (!$member || $member['status'] != GroupMembersModel::STATUS_PENDING) {
            return redirect()->back()->with('error', 'Undangan tidak valid.');
        }

        $this->groupMembersModel
            ->where('group_id', $groupId)
            ->where('user_id', $userId)
            ->delete();

        return redirect()->to('/dashboard')->with('success', 'Undangan grup ditolak.');
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
    }

    public function requestJoin($groupId){
        $userId = session()->get('userId');

        $existing = $this->groupMembersModel
                        ->where('group_id', $groupId)
                        ->where('user_id', $userId)
                        ->first();

        if ($existing) {
            return redirect()->back()->with('warning', 'Kamu sudah mengirim permintaan atau sudah menjadi anggota.');
        }

        $this -> groupMembersModel -> insert([
            'group_id' => $groupId,
            'user_id' => $userId,
            'status' => GroupMembersModel::STATUS_PENDING
        ]);

        $admins = $this->groupMembersModel
                    ->select('user_id')
                    ->where('group_id', $groupId)
                    ->where('role', 'admin')
                    ->findAll();

        foreach ($admins as $admin) {
            $this->notificationModel->insert([
                'user_id'    => $admin['user_id'],
                'sender_id'  => $userId,
                'type'       => 'group_join_request',
                'related_id' => $groupId,
                'message'    => 'meminta bergabung ke grup.'
            ]);
        }

        return redirect()->back()->with('success', 'Permintaan bergabung berhasil dikirim. Menunggu persetujuan admin.');
    }

    public function requestAccept(int $groupId){
        $currentUserId = session()->get('userId');

        $notification = $this->notificationModel
                    ->where('user_id', $currentUserId)
                    ->where('related_id', $groupId)
                    ->where('type', 'group_join_request')
                    ->orderBy('created_at', 'DESC')
                    ->first();

        if (!$notification) {
            return redirect()->back()->with('error', 'Permintaan tidak ditemukan.');
        }

        $senderId = $notification['sender_id'];

        $updated = $this->groupMembersModel
            ->where('group_id', $groupId)
            ->where('user_id', $senderId)
            ->set('status', GroupMembersModel::STATUS_APPROVED)
            ->update();

        if ($updated) {
            $this->notificationModel
                ->where('user_id', $currentUserId)
                ->where('related_id', $groupId)
                ->where('sender_id', $senderId)
                ->where('type', 'group_join_request')
                ->delete();

            return redirect()->to(base_url())->with('success', 'Permintaan telah disetujui.');

        }

        return redirect()->back()->with('error', 'Gagal menyetujui permintaan.');
    }

    public function requestDecline($groupId){
        $currentUserId = session()->get('userId');

        $notification = $this->notificationModel
            ->where('user_id', $currentUserId)
            ->where('related_id', $groupId)
            ->where('type', 'group_join_request')
            ->orderBy('created_at', 'DESC')
            ->first();

        if (!$notification) {
            return redirect()->back()->with('error', 'Permintaan tidak ditemukan.');
        }

        $senderId = $notification['sender_id'];

        $this->groupMembersModel
            ->where('group_id', $groupId)
            ->where('user_id', $senderId)
            ->delete();

        $this->notificationModel
            ->where('user_id', $currentUserId)
            ->where('related_id', $groupId)
            ->where('sender_id', $senderId)
            ->where('type', 'group_join_request')
            ->delete();

        return redirect()->to(base_url())->with('success', 'Permintaan telah ditolak.');
    }

    public function deleteMessage($messageId) {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403, 'Forbidden');
        }

        $userId = session()->get('userId');
        $message = $this->groupMessageModel->find($messageId);

    
        if (!$message) {
            return $this->response->setStatusCode(404, 'Pesan tidak ditemukan.');
        }
        
        $isAdmin = !empty($this->groupMembersModel->where([
            'group_id' => $message['group_id'],
            'user_id'  => $userId,
            'role'     => 'admin'
        ])->first());

        $isSender = ($message['sender_id'] == $userId);

    
        if (!$isAdmin && !$isSender) {
            return $this->response->setStatusCode(403, 'Anda tidak memiliki izin untuk menghapus pesan ini.');
        }

        if ($this->groupMessageModel->delete($messageId)) {
            return $this->response->setJSON([
                'success'   => true,
                'csrf_hash' => csrf_hash()
            ]);
        } else {
            return $this->response->setStatusCode(500, 'Gagal menghapus pesan');
        }
    }
}