<?php

namespace App\Models;

use CodeIgniter\Model;

class BookLoanModel extends Model
{
    protected $table            = 'book_loans';
    protected $allowedFields    = [
        'book_collection_id',
        'borrower_id',
        'loan_start_date',
        'loan_end_date',
        'status',
        'approved_at',
        'returned_at'
    ];
    protected $useTimestamps = true;

    const STATUS_PENDING = 0;
    const STATUS_APPROVED = 1;
    const STATUS_DECLINED = 2;
    const STATUS_RETURNED = 3;


    public function getBookLoanDetail(int $loanId) {
        return $this->select('
            book_loans.id,
            book_loans.book_collection_id,
            book_loans.borrower_id,
            book_loans.loan_start_date,
            book_loans.loan_end_date,
            book_loans.status,
            book_loans.approved_at,
            book_loans.returned_at,
            book_loans.created_at,
            book_loans.updated_at,

            book.id as book_id,
            book.title as book_title,
            book.author as book_author, 
            book.book_cover,

            borrower.username as borrower_name,
            borrower.id as borrower_id,
            
            owner.id as lender_id,
            owner.username as owner_name
        ')
        ->join('book_collection', 'book_collection.id = book_loans.book_collection_id')
        ->join('book', 'book.id = book_collection.book_id')
        ->join('user as borrower', 'borrower.id = book_loans.borrower_id')
        ->join('user as owner', 'owner.id = book_collection.user_id')
        ->where('book_loans.id', $loanId)
        ->asArray()
        ->first();
    }


    public function getDataLender(int $lenderId) {
        return $this->select('
                book_loans.id as id,
                book_loans.created_at,
                book_loans.loan_start_date,
                book_loans.loan_end_date,
                book_loans.returned_at,
                book_loans.approved_at,
                book_loans.updated_at,
                book_loans.status,

                book.title as book_title,
                book.author as book_author,
                book.book_cover as book_cover,
                book.slug as book_slug,

                borrower.username as borrower_name
            ')
            ->join('book_collection', 'book_collection.id = book_loans.book_collection_id')
            ->join('book', 'book.id = book_collection.book_id')
            ->join('user as borrower', 'borrower.id = book_loans.borrower_id')
            ->where('book_collection.user_id', $lenderId)
            ->orderBy('book_loans.updated_at', 'DESC')
            ->asArray()
            ->findAll();
    }

    public function getDataBorrower(int $borrowerId) {
        return $this->select('
                book_loans.id as id,
                book_loans.created_at,
                book_loans.loan_start_date,
                book_loans.loan_end_date,
                book_loans.returned_at,
                book_loans.approved_at,
                book_loans.updated_at,
                book_loans.status,

                book.title as book_title,
                book.author as book_author,
                book.book_cover as book_cover,
                book.slug as book_slug,

                owner.username as owner_name
            ')
            ->join('book_collection', 'book_collection.id = book_loans.book_collection_id')
            ->join('book', 'book.id = book_collection.book_id')
            ->join('user as owner', 'owner.id = book_collection.user_id')
            ->where('book_loans.borrower_id', $borrowerId)
            ->orderBy('book_loans.updated_at', 'DESC')
            ->asArray()
            ->findAll();
    }

}
