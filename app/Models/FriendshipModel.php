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
}