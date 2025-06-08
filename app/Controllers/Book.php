<?php 

namespace App\Controllers;

use App\Models\BookModel;
use App\Models\BookCollectionModel;
use App\Models\BookGenreModel;
use App\Models\GenreModel;
use App\Models\UserModel;

use CodeIgniter\Exceptions\PageNotFoundException;

class Book extends BaseController {
    private $bookCollectionModel;
    private $bookModel;
    private $bookGenreModel;
    private $genreModel;
    private $userModel;

    public function __construct() {
        $this -> bookModel = new BookModel();
        $this -> bookCollectionModel = new BookCollectionModel();
        $this -> bookGenreModel = new BookGenreModel();
        $this -> genreModel = new GenreModel();
        $this -> userModel = new UserModel();
    }


    public function index(string $username, string $slug) {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('auth/login'));
        }

        $user = $this -> userModel -> where('username', $username) -> first();
        if (!$user) {
            throw new PageNotFoundException('User tidak ditemukan.');
        }

        $book = $this -> bookModel -> where('slug', $slug) -> first();
        if (!$book) {
            throw new PageNotFoundException('Buku tidak ditemukan.');
        }

        $bookCollection = $this -> bookCollectionModel
            -> where('user_id', $user['id'])
            -> where('book_id', $book['id'])
            -> first();

        if (!$bookCollection) {
            throw new PageNotFoundException('Koleksi buku tidak ditemukan untuk user ini.');
        }

        if ($slug !== $book['slug']) {
            return redirect()->to(base_url('/library/book/' . $username . '/' . $book['slug']), 301);
        }

        $genre = $this -> bookGenreModel
                    -> select('genres.genre_name')
                    -> join('genres', 'genres.id = book_genres.genre_id')
                    -> where('book_genres.book_id', $book['id'])
                    -> first();

        $data = [
            'book' => [
                'id'            => $book['id'],
                'title'         => $book['title'],
                'author'        => $book['author'],
                'slug'          => $book['slug'],
                'book_cover'    => $book['book_cover'],
                'published_date'=> $book['published_date'],
                'total_pages'   => $book['total_pages'],
                'description'   => $book['description'],
                'added_at'    => $book['created_at'],
                'updated_at'    => $book['updated_at'],
                'genres'        => $genre['genre_name'],

                'collection_id' => $bookCollection['id'],
                'read_page'     => $bookCollection['read_page'],
                'rating'        => $bookCollection['rating'],
                'review'        => $bookCollection['review'],
            ],
            'user' => $user,
        ];
        return view('main/library/bookdetail', $data);
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

        $bookId = $this -> bookModel->insert($bookData, true); // true = return inserted ID

        $userId = session() -> get('userId');

        $this -> bookCollectionModel->insert([
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

        return redirect() -> to('/library')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function editMyBook($username, $slug){
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('auth/login'));
        }

        $user = $this -> userModel -> where('username', $username) -> first();
        if (!$user) {
            throw new PageNotFoundException('User tidak ditemukan.');
        }

        $book = $this -> bookModel -> where('slug', $slug) -> first();
        if (!$book) {
            throw new PageNotFoundException('Buku tidak ditemukan.');
        }

        $bookCollection = $this -> bookCollectionModel
            -> where('user_id', $user['id'])
            -> where('book_id', $book['id'])
            -> first();

        if (!$bookCollection) {
            throw new PageNotFoundException('Koleksi buku tidak ditemukan untuk user ini.');
        }

        if ($slug !== $book['slug']) {
            return redirect()->to(base_url('/library/book/' . $username . '/' . $book['slug']), 301);
        }

        $genre = $this -> bookGenreModel
                    -> select('genres.genre_name')
                    -> join('genres', 'genres.id = book_genres.genre_id')
                    -> where('book_genres.book_id', $book['id'])
                    -> first();
        
        $genres = $this -> bookGenreModel
                    -> select('genres.genre_name')
                    -> join('genres', 'genres.id = book_genres.genre_id')
                    -> where('book_genres.book_id', $book['id'])
                    -> findAll();

        $data = [
            'book' => [
                'id'            => $book['id'],
                'title'         => $book['title'],
                'author'        => $book['author'],
                'slug'          => $book['slug'],
                'book_cover'    => $book['book_cover'],
                'published_date'=> $book['published_date'],
                'total_pages'   => $book['total_pages'],
                'description'   => $book['description'],
                'added_at'    => $book['created_at'],
                'updated_at'    => $book['updated_at'],
                'genres'        => $genre['genre_name'],

                'collection_id' => $bookCollection['id'],
                'read_page'     => $bookCollection['read_page'],
                'rating'        => $bookCollection['rating'],
                'review'        => $bookCollection['review'],
            ],
            'user' => $user,
            'genres' => $genres
        ];
        return view('main/library/edit', $data);
    }

    public function proceedEditBook($collectionId) {
        if (!session() -> get('isLoggedIn')) {
            return redirect() -> to(base_url('auth/login'));
        }

        $bookCollection = $this -> bookCollectionModel -> find($collectionId);

        if (!$bookCollection || $bookCollection['user_id'] !== session()->get('userId')) {
            throw new PageNotFoundException('Koleksi tidak ditemukan atau bukan milik Anda.');
        }

        $this -> bookCollectionModel->update($collectionId, [
            'read_page' => $this -> request -> getPost('read_page'),
            'rating' => $this -> request -> getPost('rating'),
            'review' => $this -> request -> getPost('review'),
        ]);

        return redirect() -> to(base_url('/library'))->with('success', 'Koleksi buku berhasil diperbarui.');
    }

    public function deleteBook($username, $slug){
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('auth/login'));
        }

        $user = $this -> userModel -> where('username', $username) -> first();
        if (!$user) {
            throw new PageNotFoundException('User tidak ditemukan.');
        }

        $book = $this -> bookModel -> where('slug', $slug) -> first();
        if (!$book) {
            throw new PageNotFoundException('Buku tidak ditemukan.');
        }

        $bookCollection = $this -> bookCollectionModel
                                -> where('user_id', $user['id'])
                                -> where('book_id', $book['id'])
                                -> first();

        if (!$bookCollection) {
            return redirect()->back()->with('error', 'Koleksi buku tidak ditemukan.');
        }

        // Hapus dari koleksi
        $this-> bookCollectionModel -> delete($bookCollection['id']);

        return redirect() -> to(base_url('/library/' . $username))
                        -> with('success', 'Buku berhasil dihapus dari katalogmu.');
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