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
        $dbResults = $this->select('notifications.*, user.username as sender_username, user.picture as sender_picture')
            ->join('user', 'user.id = notifications.sender_id')
            ->where('notifications.user_id', $userId)
            ->orderBy('notifications.created_at', 'DESC')
            ->findAll($limit);

        if (empty($dbResults)) {
            return [];
        }

        $formattedNotifications = [];
        $bookModel = new \App\Models\BookModel(); 

        foreach ($dbResults as $row) {
            $notificationData = [
                'id' => $row['id'],
                'related_id' => $row['related_id'], 
                'type' => $row['type'],
                'read' => ($row['read_at'] !== null), 
                'timestamp' => strtotime($row['created_at']),
                'sender' => [
                    'name' => $row['sender_username'],
                    'picture' => base_url('uploads/' . $row['sender_picture']) 
                ],
                'details' => [] // Defaultnya array kosong
            ];

            if ($row['type'] === 'loan_request') {
                $book = $bookModel->find($row['related_id']);
                if ($book) {
                    $notificationData['details']['book_title'] = $book['title'];
                }
            }
            
            $formattedNotifications[] = $notificationData;
        }

        return $formattedNotifications;
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