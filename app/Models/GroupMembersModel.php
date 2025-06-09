<?php

namespace App\Models;

use CodeIgniter\Model;

class GroupMembersModel extends Model
{
    protected $table            = 'group_members';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "user_id",
        "group_id",
        "role",
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'joined_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getGroupsByUserId($userId) {
        return $this -> select(
            'group_members.group_id, 
                    groups.name as group_name, 
                    groups.icon, groups.slug, 
                    groups.description, 
                    (SELECT COUNT(*) FROM group_members WHERE group_members.group_id = groups.id) as member_count'
        )
                    -> join('groups', 'groups.id = group_members.group_id')
                    -> where('group_members.user_id', $userId)
                    -> findAll();
    }

    public function getMembersByGroupId(int $groupId) {
        return $this->select('user.id, user.username, user.picture')
                    ->join('user', 'user.id = group_members.user_id')
                    ->where('group_members.group_id', $groupId)
                    ->findAll();
    }

    public function isMember($userId, $groupId) {
        if (!$userId || !$groupId) {
            return false;
        }

        $result = $this->where('user_id', $userId)
                       ->where('group_id', $groupId)
                       ->first();
        
        return $result !== null;
    }
}
