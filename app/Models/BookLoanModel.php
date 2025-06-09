<?php

namespace App\Models;

use CodeIgniter\Model;

class BookLoanModel extends Model
{
    protected $table            = 'book_loans';
    protected $allowedFields    = [
        'book_id',
        'lender_id',
        'borrower_id',
        'loan_start_date',
        'loan_end_date',
        'status',
        'approved_at',
        'returned_at'
    ];
    protected $useTimestamps = false;

    const STATUS_PENDING = 0;
    const STATUS_APPROVED = 1;
    const STATUS_DECLINED = 2;
    const STATUS_RETURNED = 3;


    public function getBookLoanDetail(int $loanId) {
        return $this->select('
            book_loans.*,
            book.id as book_id,
            book.title as book_title,
            books.author as book_author, 
            books.book_cover,
            borrower.username as borrower_name,
            owner.username as owner_name
        ')
        ->join('book', 'book.id = book_loans.book_id')
        ->join('user as borrower', 'borrower.id = book_loans.borrower_id')
        ->join('user as owner', 'owner.id = book_loans.lender_id')
        ->where('book_loans.id', $loanId)
        ->asArray()
        ->first();
    }
}
