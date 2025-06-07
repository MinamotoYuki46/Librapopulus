<?php 

namespace App\Controllers;

use App\Models\BookCollectionModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Book extends BaseController {
    private $bookCollectionModel;

    public function __construct() {
        $this -> bookCollectionModel = new BookCollectionModel();
    }


    public function index(int $collectionId, string $slug){
        if (!session() -> get('isLoggedIn')) {
            return redirect() -> to(base_url('auth/login'));
        }

        $book = $this->bookCollectionModel->findBookCollectionDetail($collectionId);

        if (!$book) {
            throw new PageNotFoundException('Buku tidak ditemukan.');
        }

        if ($slug !== $book['slug']) {
            return redirect()->to(base_url('/library/book/' . $book['collection_id'] . '/' . $book['slug']), 301);
        }

        $data = ['book' => $book];
        
        return view("main/library/bookdetail", $data);
    }

    public function focus(int $collectionId, string $slug) {
        if (!session() -> get('isLoggedIn')) {
            return redirect() -> to(base_url('auth/login'));
        }

        $book = $this->bookCollectionModel->findBookCollectionDetail($collectionId);

        if (!$book) {
            throw new PageNotFoundException('Buku tidak ditemukan.');
        }

        $data = ['book' => $book];

        return view("main/library/focusmode", $data);
    }

    public function loanRequest(){
        if (!session() -> get('isLoggedIn')) {
            return redirect() -> to(base_url('auth/login'));
        }

        return view("main/library/loanrequest");
    }

    public function acceptLoan() {
        if (!session() -> get('isLoggedIn')) {
            return redirect() -> to(base_url('auth/login'));
        }

        return view("main/library/acceptloan");
    }
}