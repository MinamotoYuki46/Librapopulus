<?php

namespace App\Models;

use CodeIgniter\Model;

class MessageModel extends Model
{
    protected $table = 'messages';
    protected $allowedFields = [
        'sender_id', 
        'receiver_id', 
        'message_text',
        'deleted_at'
    ];
    protected $useSoftDeletes = true;
    protected $useTimestamps  = true;
    protected $createdField   = 'created_at';
    protected $updatedField   = '';
    protected $deletedField   = 'deleted_at';


    public function getConversation(int $userId1, int $userId2, int $limit, int $offset) {
        $messages = $this->select('
                                messages.*, 
                                user.username as sender_username, 
                                user.picture as sender_picture, 
                                user.id as sender_real_id
                            ')
                    ->join('user', 'user.id = messages.sender_id')
                    ->whereIn('messages.sender_id', [$userId1, $userId2])
                    ->whereIn('messages.receiver_id', [$userId1, $userId2])
                    ->orderBy('messages.created_at', 'DESC')
                    ->findAll($limit, $offset);

        return array_reverse($messages);
    }

    public function getNewMessages(int $userId1, int $userId2, int $sinceId) {
        if ($sinceId == 0) {
            return [];
        }
        
        return $this->select('messages.*, user.username as sender_username, user.picture as sender_picture, user.id as sender_real_id')
            ->join('user', 'user.id = messages.sender_id')
            ->whereIn('messages.sender_id', [$userId1, $userId2])
            ->whereIn('messages.receiver_id', [$userId1, $userId2])
            ->where('messages.id >', $sinceId) 
            ->orderBy('messages.created_at', 'ASC')
            ->findAll();
    }
}