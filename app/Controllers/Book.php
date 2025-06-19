<?php 

namespace App\Controllers;

use App\Models\BookModel;
use App\Models\BookCollectionModel;
use App\Models\BookGenreModel;
use App\Models\GenreModel;
use App\Models\UserModel;
use App\Models\FriendshipModel;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;

class Book extends BaseController {
    private $bookCollectionModel;
    private $bookModel;
    private $bookGenreModel;
    private $genreModel;
    private $userModel;
    private $friendshipModel;

    private $db;

    public function __construct() {
        $this -> bookModel = new BookModel();
        $this -> bookCollectionModel = new BookCollectionModel();
        $this -> bookGenreModel = new BookGenreModel();
        $this -> genreModel = new GenreModel();
        $this -> userModel = new UserModel();
        $this -> friendshipModel = new FriendshipModel();
        $this -> db = \Config\Database::connect();
    }


    public function index(string $username, string $slug) {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('auth/login'));
        }

        $user = $this -> userModel -> where('username', $username) -> first();
        if (!$user) {
            throw new PageNotFoundException('User tidak ditemukan.');
        }

        $isFriend = null;
        if($user['id'] !== session()->get('userId')){
            $isFriend = $this->friendshipModel->getFriendshipStatus(session()->get('userId'), $user['id']);
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
                'genres'        => $genres,

                'collection_id' => $bookCollection['id'],
                'read_page'     => $bookCollection['read_page'],
                'rating'        => $bookCollection['rating'],
                'review'        => $bookCollection['review'],
            ],
            'user' => $user,
            'isFriend' => $isFriend
        ];
        return view('main/library/bookdetail', $data);
    }

    public function booklist(){
        $books = $this -> bookModel -> findAll();

        return view('main/library/booklist', ['books' => $books]);

    }

    public function addBook(){
        $data['genres'] = $this -> genreModel->findAll();
        return view('main/library/add', $data);
    }

    public function searchBook(): ResponseInterface {
        $query = $this->request->getGet('q');

        if (!$query || strlen($query) < 2) {
            return $this->response->setJSON([]);
        }

        $books = $this -> bookModel
            ->like('title', $query)
            ->orLike('author', $query)
            ->select('id, title, author, published_date, total_pages, description, book_cover')
            ->findAll(10);
        
        foreach ($books as &$book) {
            $genreRows = $this -> bookGenreModel ->where('book_id', $book['id'])->findAll();
            $book['genre_ids'] = array_column($genreRows, 'genre_id');
        }

        return $this -> response -> setJSON($books);
    }

    public function proceedAddBook(){
        $request = $this->request;
        $bookId = $request -> getPost('existing_book_id');

        $userId = session() -> get('userId');
        
        $this -> bookCollectionModel->insert([
            'user_id' => $userId,
            'book_id' => $bookId,
            'read_page' => $request -> getPost('pages_read'),
            'rating' => $request -> getPost('rating'),
            'review' => $request -> getPost('review'),
            'read_duration' => 0, 
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
                'added_at'      => $book['created_at'],
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

        if (!$bookCollection || $bookCollection['user_id'] != session()->get('userId')) {
            throw new PageNotFoundException('Koleksi tidak ditemukan atau bukan milik Anda.');
        }

        $this -> bookCollectionModel->update($collectionId, [
            'read_page' => $this -> request -> getPost('read_page'),
            'rating' => $this -> request -> getPost('rating'),
            'review' => $this -> request -> getPost('review'),
        ]);

        $book = $this -> bookModel -> find($bookCollection['book_id']);
        $user = $this -> userModel -> find($bookCollection['user_id']);
        $username = $user['username'];
        $slug = $book['slug'];

        return redirect() -> to(base_url('/library/' . $username . '/' . $slug ))->with('success', 'Koleksi buku berhasil diperbarui.');
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

        $this-> bookCollectionModel -> delete($bookCollection['id']);

        return redirect() -> to(base_url('/library/' . $username))
                        -> with('success', 'Buku berhasil dihapus dari katalogmu.');
    }



    public function focus(string $username, string $slug) {
        if (!session() -> get('isLoggedIn')) {
            return redirect() -> to(base_url('auth/login'));
        }

        $user = $this -> userModel -> getDataUserByUsername($username);
        $book = $this -> bookModel -> where("slug", $slug) -> first();

        $bookCollection = $this -> bookCollectionModel
                                -> where('user_id', $user['id'])
                                -> where('book_id', $book['id'])
                                -> first();

        if (!$bookCollection) {
            throw new PageNotFoundException('Buku tidak ditemukan.');
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
                'id'                    => $book['id'],
                'title'                 => $book['title'],
                'author'                => $book['author'],
                'slug'                  => $book['slug'],
                'book_cover'            => $book['book_cover'],
                'published_date'        => $book['published_date'],
                'total_pages'           => $book['total_pages'],
                'description'           => $book['description'],
                'added_at'              => $book['created_at'],
                'updated_at'            => $book['updated_at'],
                'genres'                => $genre['genre_name'],
                'total_read_duration'   => $bookCollection['read_duration'],

                'collection_id'         => $bookCollection['id'],
                'read_page'             => $bookCollection['read_page'],
                'rating'                => $bookCollection['rating'],
                'review'                => $bookCollection['review'],
            ],
            'user'                      => $user,
            'genres'                    => $genres
        ];

        return view("main/library/focusmode", $data);
    }

    public function focusSend(string $username, string $slug){
        if(!session() -> get("isLoggedIn")){
            return redirect() -> to(base_url('auth/login'));
        }

        $user = $this -> userModel -> getDataUserByUsername($username);
        $book = $this -> bookModel -> where("slug", $slug) -> first();
        $bookCollection = $this -> bookCollectionModel
                                -> where('user_id', $user['id'])
                                -> where('book_id', $book['id'])
                                -> first();

        if (!$bookCollection) {
            throw new PageNotFoundException('Buku tidak ditemukan.');
        }

        $jsonData = $this -> request -> getJSON();
        $duration = $jsonData -> duration ?? null;
        $pagesRead = $jsonData -> pagesRead ?? null;

        if (!is_numeric($duration) || !is_numeric($pagesRead)) {
            return $this -> response -> setStatusCode(400) -> setJSON(['error' => 'Invalid data provided.']);
        }

        $success = $this -> bookCollectionModel -> updateReadingSession($bookCollection["id"], $duration, $pagesRead); 

        if ($success) {
            $updatedBook = $this -> bookCollectionModel -> find($bookCollection["id"]);
            $newReadPage = $updatedBook['read_page'];
            $newDuration = $updatedBook['read_duration'];

            $response = [
                'success'       => true,
                'message'       => 'Progress updated!',
                'csrf_token'    => csrf_hash(),
                'new_read_page' => (int)$newReadPage,
                'new_total_duration' => (int)$newDuration
            ];
            return $this -> response -> setJSON($response);
        } else {
            $response = [
                'success'       => false,
                'error'         => 'Failed to update progress in the database.',
                'csrf_token'    => csrf_hash()
            ];
            return $this -> response -> setStatusCode(500) -> setJSON($response);
        }
    }

    public function requestLoan(string $username, $slug){
        if (!session() -> get('isLoggedIn')) {
            return redirect() -> to(base_url('auth/login'));
        }
        $owner = $this -> userModel -> getDataUserByUsername($username); 
        $currentUser = $this -> userModel -> getDataUser(session() -> get("userId"));

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
            "owner" => [
                "username"      => $username
            ],
            'book' => [
                'id'            => $book['id'],
                'title'         => $book['title'],
                'author'        => $book['author'],
                'slug'          => $book['slug'],
                'book_cover'    => $book['book_cover'],
                'collection_id' => $bookCollection['id'],
            ],
            "currentUser"       => $currentUser
        ];

        return view("main/library/requestloan", $data);
    }

    public function acceptLoan() {
        if (!session() -> get('isLoggedIn')) {
            return redirect() -> to(base_url('auth/login'));
        }

        return view("main/library/acceptloan");
    }

    public function book(string $slug){
        $book = $this -> bookModel
        ->where('slug', $slug)
        ->first();

        if (!$book) {
            throw PageNotFoundException::forPageNotFound("Buku dengan slug '$slug' tidak ditemukan.");
        }

        $owners = $this->bookCollectionModel
                ->select('user.id, user.username, user.full_name, user.picture, book_collection.rating, book_collection.review')
                ->join('user', 'user.id = book_collection.user_id')
                ->where('book_collection.book_id', $book['id'])
                ->findAll();
        
        $ratings = $this->db->table('book_collection')
                ->select('user.full_name, user.username, book_collection.rating, book_collection.review')
                ->join('user', 'user.id = book_collection.user_id')
                ->join('book', 'book.id = book_collection.book_id')
                ->where('book.slug', $slug)
                ->where('book_collection.rating IS NOT NULL')
                ->orderBy('book_collection.rating', 'DESC')
                ->get()
                ->getResultArray();

        $averageRating = $this->db->table('book_collection')
                ->selectAvg('rating')
                ->join('book', 'book.id = book_collection.book_id')
                ->where('book.slug', $slug)
                ->get()
                ->getRow()
                ->rating;
        
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
            'genres'        => $genres,
        ],
        'owners'        => $owners,
        'ratings'       => $ratings,
        'averageRating' => $averageRating,
    ];

    log_message('debug', 'Data: ' . print_r($data, true));


    return view('main/library/book', $data);
    }
}