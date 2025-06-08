<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table = 'notifications';
    protected $allowedFields = [
        'user_id', 
        'sender_id', 
        'type', 
        'related_id', 
        'message', 
        'read_at'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    public function getNotifications(int $userId, int $limit = 10){
        return $this->select('notifications.*, user.username as sender_username, user.picture as sender_picture')
            ->join('user', 'user.id = notifications.sender_id')
            ->where('notifications.user_id', $userId)
            ->orderBy('notifications.created_at', 'DESC')
            ->findAll($limit);
    }


    public function getUnreadCount(int $userId) {
        return $this->where('user_id', $userId)
                    ->where('read_at', null)
                    ->countAllResults();
    }

    public function markAllAsRead(int $userId) {
        return $this->where('user_id', $userId)
                    ->where('read_at', null)
                    ->set(['read_at' => date('Y-m-d H:i:s')])
                    ->update();
    }
}