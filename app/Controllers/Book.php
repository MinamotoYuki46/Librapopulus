<?php 

namespace App\Controllers;

use App\Models\BookModel;
use App\Models\BookCollectionModel;
use App\Models\BookGenreModel;
use App\Models\GenreModel;

use CodeIgniter\Exceptions\PageNotFoundException;

class Book extends BaseController {
    private $bookCollectionModel;
    private $bookModel;
    private $bookGenreModel;
    private $genreModel;

    public function __construct() {
        $this -> bookModel = new BookModel();
        $this -> bookCollectionModel = new BookCollectionModel();
        $this -> bookGenreModel = new BookGenreModel();
        $this -> genreModel = new GenreModel();
    }


    public function index(int $collectionId, string $slug){
        if (!session() -> get('isLoggedIn')) {
            return redirect() -> to(base_url('auth/login'));
        }

        $book = $this -> bookCollectionModel -> findBookCollectionDetail($collectionId);

        if (!$book) {
            throw new PageNotFoundException('Buku tidak ditemukan.');
        }

        if ($slug !== $book['slug']) {
            return redirect()->to(base_url('/library/book/' . $book['collection_id'] . '/' . $book['slug']), 301);
        }

        $data = ['book' => $book];
        
        return view("main/library/bookdetail", $data);
    }

    public function addBook(){
        $data['genres'] = $this -> genreModel->findAll();
        return view('main/library/add', $data);
    }

    public function proceedAddBook(){
        $request = $this->request;
        $cover = $request->getFile('cover');

        $slug = url_title($request->getPost('title'), '-', true);

        if (!$cover -> isValid() || $cover -> hasMoved()) {
            return redirect() -> back() -> withInput() -> with('error', 'Gagal upload cover');
        }

        $extension = $cover -> getClientExtension();
        $coverFileName = $slug . '.' . $extension;
        $cover -> move(FCPATH . 'uploads/bookcover', $coverFileName);

        $bookData = [
            'title' => $request -> getPost('title'),
            'author' => $request -> getPost('author'),
            'slug' => $slug,
            'book_cover' => $coverFileName,
            'published_date' => $request -> getPost('published_date'),
            'total_pages' => $request -> getPost('total_pages'),
            'description' => $request -> getPost('description'),
        ];

        $bookId = $this->bookModel->insert($bookData, true); // true = return inserted ID

        $userId = session() -> get('userId');

        $this->bookCollectionModel->insert([
            'user_id' => $userId,
            'book_id' => $bookId,
            'read_page' => $request -> getPost('pages_read'),
            'rating' => $request -> getPost('rating'),
            'review' => $request -> getPost('review'),
            'read_duration' => 0, 
        ]);

        $this -> bookGenreModel -> insert([
            'book_id' => $bookId,
            'genre_id' => $request->getPost('genre_id'),
        ]);

        return redirect()->to('/library')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function focus(int $collectionId, string $slug) {
        if (!session() -> get('isLoggedIn')) {
            return redirect() -> to(base_url('auth/login'));
        }

        $book = $this -> bookCollectionModel->findBookCollectionDetail($collectionId);

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