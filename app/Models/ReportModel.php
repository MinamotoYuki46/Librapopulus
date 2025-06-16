<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportModel extends Model
{
    protected $table            = 'report';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'book_loan_id',
        'message',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = ''; 

    protected $validationRules      = [
        'book_loan_id' => 'required|integer',
        'message'      => 'required|string',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    public function getReportDetail(){
        return $this->select('
                report.id,
                report.message,
                report.created_at,
                report.updated_at,

                book.title AS book_title,

                borrower.username AS borrower_username,
                owner.username AS owner_username
            ')
            ->join('book_loans', 'book_loans.id = report.book_loan_id')
            ->join('book_collection', 'book_collection.id = book_loans.book_collection_id')
            ->join('book', 'book.id = book_collection.book_id')
            ->join('user AS borrower', 'borrower.id = book_loans.borrower_id')
            ->join('user AS owner', 'owner.id = book_collection.user_id')
            ->findAll();
    }
}
