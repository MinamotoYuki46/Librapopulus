<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BookCollectionModel;
use App\Models\UserModel;
use App\Models\BookModel;
use App\Models\NotificationModel;
use App\Models\BookLoanModel;
use App\Models\FriendshipModel;
use CodeIgniter\I18n\Time;
use CodeIgniter\Exceptions\PageNotFoundException;

class BookLoan extends BaseController{
    private $userModel;
    private $bookModel;
    private $bookLoanModel;
    private $notificationModel;
    private $bookCollectionModel; 
    private $friendshipModel;

    public function __construct(){
        $this -> bookCollectionModel = new BookCollectionModel();
        $this -> userModel = new UserModel();
        $this -> bookModel = new BookModel();
        $this -> notificationModel = new NotificationModel();
        $this -> bookLoanModel = new BookLoanModel();
        $this -> friendshipModel = new FriendshipModel();
    }

    public function requestLoanForm(string $username, $slug){
        if (!session() -> get('isLoggedIn')) {
            return redirect() -> to(base_url('auth/login'));
        }
        $owner = $this -> userModel -> getDataUserByUsername($username);

        $owner['username'] = $username; 
        $currentUser = $this -> userModel -> getDataUser(session() -> get("userId"));

        $friendship = $this->friendshipModel->getFriendshipStatus(session() -> get("userId"), $owner['id']);

        if ($friendship['status'] != FriendshipModel::STATUS_ACCEPTED){
            return redirect()->back()->with('error', 'Anda belum berteman dengan pengguna ini');
        }

        $book = $this -> bookModel -> where('slug', $slug) -> first();
        if (!$book) {
            throw new PageNotFoundException('Buku tidak ditemukan.');
        }

        $bookCollection = $this -> bookCollectionModel
            -> where('user_id', $owner['id'])
            -> where('book_id', $book['id'])
            -> first();

        if (!$bookCollection) {
            throw new PageNotFoundException('Koleksi buku tidak ditemukan untuk user ini.');
        }

        if ($slug !== $book['slug']) {
            return redirect() -> to(base_url('/library/' . $username . '/' . $book['slug']), 301);
        }

        $data = [
            "owner"             => $owner,
            'book' => [
                'id'            => $book['id'],
                'title'         => $book['title'],
                'author'        => $book['author'],
                'slug'          => $book['slug'],
                'book_cover'    => $book['book_cover'],
                'collection_id' => $bookCollection['id'],
            ],
            "currentUser"       => $currentUser,
            'date_now'          => Time::now()->format('Y-m-d')
        ];

        return view("main/library/requestloan", $data);
    }

    public function request() {
        $bookId = $this->request->getPost('book_id');
        $ownerId = $this->request->getPost('owner_id');
        $startDate = $this->request->getPost('start_date');
        $endDate = $this->request->getPost('end_date');
        $borrowerId = session()->get('userId');

        $loanData = [
            'book_id' => $bookId,
            'lender_id' => $ownerId,
            'borrower_id' => $borrowerId,
            'loan_start_date' => $startDate,
            'loan_end_date' => $endDate,
            'status' => BookLoanModel::STATUS_PENDING
        ];
        $loanId = $this->bookLoanModel->insert($loanData);

        $book = $this->bookModel->find($bookId);

        $this->notificationModel->insert([
            'user_id' => $ownerId,
            'sender_id' => $borrowerId,
            'type' => 'loan_request',
            'related_id' => $loanId,
            'message' => 'mengajukan permintaan untuk buku ' . esc($book['title'])
        ]);

        return redirect()->back();
    }

    public function ownerViewLoan(int $loanId){
        $loan = $this->bookLoanModel->getBookLoanDetail($loanId);

         if (!$loan || $loan['lender_id'] != session()->get('userId')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Permintaan peminjaman tidak ditemukan.');
        }

        $data = ['loan' => $loan];

        return view("main/library/acceptloan", $data); 
    }


    public function approve(int $loanId) {
        if (!session() -> get('isLoggedIn')) {
            return redirect() -> to(base_url('auth/login'));
        }

        $loan = $this->bookLoanModel->find($loanId);

        if (!$loan || $loan['lender_id'] != session()->get('userId') || $loan['status'] != BookLoanModel::STATUS_PENDING) {
            return redirect()->back()->with('error', 'Aksi tidak valid.');
        }

        $this->bookLoanModel->update($loanId, [
            'status' => BookLoanModel::STATUS_APPROVED,
            'approved_at' => date('Y-m-d H:i:s')
        ]);

        $this->notificationModel->insert([
            'user_id' => $loan['borrower_id'],
            'sender_id' => $loan['lender_id'],
            'type' => 'loan_approved',
            'related_id' => $loanId,
            'message' => 'telah menyetujui permintaan peminjaman Anda'
        ]);

        return redirect()->to(base_url());
    }

    public function decline(int $loanId) {
        $loan = $this->bookLoanModel->find($loanId);

        if (!$loan || $loan['lender_id'] != session()->get('userId') || $loan['status'] != BookLoanModel::STATUS_PENDING) {
            return redirect()->back()->with('error', 'Aksi tidak valid.');
        }

        $this->bookLoanModel->delete($loanId);

        $this->notificationModel->insert([
            'user_id' => $loan['borrower_id'],
            'sender_id' => $loan['lender_id'],
            'type' => 'loan_declined',
            'related_id' => $loanId,
            'message' => 'telah menolak permintaan peminjaman Anda'
        ]);

        return redirect()->to(base_url());
    }


    public function cancel(int $loanId) {
        $borrowerId = session()->get('userId'); 
        $loan = $this->bookLoanModel->find($loanId);

        if (!$loan || $loan['borrower_id'] != $borrowerId || $loan['status'] != BookLoanModel::STATUS_PENDING) {
            return redirect()->back()->with('error', 'Permintaan tidak dapat dibatalkan.');
        }

        $this->bookLoanModel->delete($loanId);
        
        $this->notificationModel->where('related_id', $loanId)
                        ->where('type', 'loan_request')
                        ->delete();
        
        return redirect()->back()->with('info', 'Permintaan peminjaman telah berhasil dibatalkan.');
    }
}