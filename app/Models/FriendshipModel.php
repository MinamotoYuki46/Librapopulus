<?php

namespace App\Models;

use CodeIgniter\Model;

class FriendshipModel extends Model
{
    protected $table = 'friendships';
    protected $allowedFields = [
        'user_one_id',
        'user_two_id',
        'status'
    ];
    protected $useTimestamps = true;

    const STATUS_NONE = 0;
    const STATUS_PENDING = 1;
    const STATUS_ACCEPTED = 2;
    const STATUS_DECLINED = 3;
    const STATUS_BLOCKED = 4;
    

    public function getFriends(int $userId){
        return $this->select('user.id, user.username')
        ->join('user', 'user.id = friendships.user_one_id OR user.id = friendships.user_two_id')
        ->where('status', self::STATUS_ACCEPTED)
        ->where("(user_one_id = $userId or user_two_id = $userId)")
        ->where('user.id !=', $userId)
        ->groupBy('user.id')
        ->findAll();
    }


    public function getFriendRequest(int $userId){
        return $this->select('friendships.id as request_id, user.id as user_id, user.username')
        ->join('user', 'user.id = friendships.user_one_id')
        ->where('friendships.user_two_id', $userId)
        ->where('friendships.status', self::STATUS_PENDING)
        ->findAll();
    }

    public function getFriendCount(int $userId){
        return $this->where('status', self::STATUS_ACCEPTED)
                    ->groupStart() 
                        ->where('user_one_id', $userId)
                        ->orWhere('user_two_id', $userId)
                    ->groupEnd()
                    ->countAllResults();
    }

    public function getFriendshipStatus(int $user1, int $user2) {
        return $this->groupStart()
                        ->where(['user_one_id' => $user1, 'user_two_id' => $user2])
                    ->orGroupStart()
                        ->where(['user_one_id' => $user2, 'user_two_id' => $user1])
                    ->groupEnd()
                ->groupEnd()
                ->first();
    }

    public function getFriendsWithLastMessage(int $userId) {
        $subQueryMessage = "(
            SELECT message_text FROM messages
            WHERE (sender_id = user.id AND receiver_id = $userId)
            OR (receiver_id = user.id AND sender_id = $userId)
            ORDER BY created_at DESC
            LIMIT 1
        )";

        $subQueryTime = "(
            SELECT created_at FROM messages
            WHERE (sender_id = user.id AND receiver_id = $userId)
            OR (receiver_id = user.id AND sender_id = $userId)
            ORDER BY created_at DESC
            LIMIT 1
        )";

        return $this->select("
                user.id, 
                user.username,
                user.picture,
                $subQueryMessage as last_message,
                $subQueryTime as last_message_time
            ")
            ->join('user', 'user.id = friendships.user_one_id OR user.id = friendships.user_two_id')
            ->where('friendships.status', self::STATUS_ACCEPTED)
            ->where("(friendships.user_one_id = $userId OR friendships.user_two_id = $userId)")
            ->where('user.id !=', $userId)
            ->groupBy('user.id')
            ->orderBy('last_message_time', 'DESC')
            ->findAll();
    }
}