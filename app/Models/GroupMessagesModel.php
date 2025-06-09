<?php

namespace App\Models;

use CodeIgniter\Model;

class GroupMessagesModel extends Model
{
    protected $table            = 'group_messages';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "group_id",
        "sender_id",
        "message_text",
        "created_at"
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
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

    public function getMessagesByGroup(int $groupId) {
        return $this->select('group_messages.*, user.username as sender_username, user.picture as sender_picture')
                    ->join('user', 'user.id = group_messages.sender_id')
                    ->where('group_messages.group_id', $groupId)
                    ->orderBy('group_messages.created_at', 'ASC')
                    ->findAll();
    }
}
