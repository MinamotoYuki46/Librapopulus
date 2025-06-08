<?php

namespace App\Models;

use CodeIgniter\Model;

class MessageModel extends Model
{
    protected $table = 'messages';
    protected $allowedFields = [
        'sender_id', 
        'receiver_id', 
        'message_text'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';


    public function getConversation(int $userId1, int $userId2) {
        return $this->whereIn('sender_id', [$userId1, $userId2])
                    ->whereIn('receiver_id', [$userId1, $userId2])
                    ->orderBy('created_at', 'ASC')
                    ->findAll();
    }
}