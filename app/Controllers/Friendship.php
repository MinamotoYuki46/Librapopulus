<?php

namespace App\Controllers;

use App\Models\FriendshipModel;
use App\Models\NotificationModel;
use App\Models\UserModel;

class Friendship extends BaseController {
    private $userModel;
    private $friendshipModel;
    private $notificationModel;

    public function __construct() {
        $this -> userModel = new UserModel();
        $this -> friendshipModel = new FriendshipModel();
        $this -> notificationModel = new NotificationModel();
    }

    public function add(int $receiverId) {
        $senderId = session()->get('userId');
        $senderUsername = session()->get('username');

        $existing = $this -> friendshipModel -> getFriendshipStatus($senderId, $receiverId);
        if ($existing && $existing['status'] == FriendshipModel::STATUS_PENDING) {
            return redirect()->back()->with('error', 'Anda sudah memiliki relasi dengan pengguna ini.');
        }

        $friendshipId = $this->friendshipModel->insert([
            'user_one_id' => $senderId,   // Pengirim
            'user_two_id' => $receiverId,  // Penerima
            'status'      => FriendshipModel::STATUS_PENDING
        ]);

        $this->notificationModel->insert([
            'user_id'     => $receiverId, // Notifikasi untuk si penerima
            'sender_id'   => $senderId,
            'type'        => 'friend_request',
            'related_id'  => $friendshipId,
            'message'     => esc($senderUsername) . ' mengirimi Anda permintaan pertemanan.'
        ]);

        return redirect()->back()->with('success', 'Permintaan pertemanan berhasil dikirim.');
    }


    public function accept(int $requestId) {
        $receiverId = session()->get('userId');
        $receiverUsername = session()->get('username');

        $request = $this->friendshipModel->find($requestId);

        if (!$request || $request['user_two_id'] != $receiverId || $request['status'] != FriendshipModel::STATUS_PENDING) {
            return redirect()->back()->with('error', 'Permintaan tidak valid atau sudah tidak tersedia.');
        }

        $this->friendshipModel->update($requestId, ['status' => FriendshipModel::STATUS_ACCEPTED]);

        $this->notificationModel->insert([
            'user_id'     => $request['user_one_id'], // Notifikasi untuk si pengirim
            'sender_id'   => $receiverId,
            'type'        => 'request_accepted',
            'related_id'  => $requestId,
            'message'     => esc($receiverUsername) . ' menerima permintaan pertemanan Anda.'
        ]);

        $this->notificationModel->where('related_id', $requestId)
                                ->where('type', 'friend_request')
                                ->where('user_id', $receiverId)
                                ->delete();

        return redirect()->back()->with('success', 'Anda sekarang berteman!');
    }


    public function decline(int $requestId) {
        $receiverId = session()->get('userId');

        $request = $this->friendshipModel->find($requestId);

        if (!$request || $request['user_two_id'] != $receiverId || $request['status'] != FriendshipModel::STATUS_PENDING) {
            return redirect()->back()->with('error', 'Permintaan tidak valid atau sudah tidak tersedia.');
        }

        $this->friendshipModel->delete($requestId);

        $this->notificationModel->where('related_id', $requestId)
                                ->where('type', 'friend_request')
                                ->where('user_id', $receiverId)
                                ->delete();

        return redirect()->back()->with('info', 'Permintaan pertemanan telah ditolak.');
    }

    public function cancel(int $requestId) {
        $senderId = session()->get('userId');

        $request = $this->friendshipModel->find($requestId);

        if (!$request || $request['user_one_id'] != $senderId || $request['status'] != FriendshipModel::STATUS_PENDING) {
            return redirect()->back()->with('error', 'Permintaan tidak dapat dibatalkan.');
        }

         $this->friendshipModel->delete($requestId);

        $this->notificationModel->where('related_id', $requestId)
                                ->where('type', 'friend_request')
                                ->delete();

        return redirect()->back()->with('info', 'Permintaan pertemanan telah dibatalkan.');
    }
}