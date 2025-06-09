<?php

namespace App\Models;

use CodeIgniter\Model;

class BookCollectionModel extends Model
{
    protected $table = 'book_collection';
    protected $allowedFields = [
        'user_id',
        'book_id',
        'read_page',
        'rating',
        'review',
        'read_duration',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;


    public function getBookCollectionByUserId(int $userId) {
        return $this->db->table($this->table)
            ->select('
                book.id as book_id, 
                book.title, 
                book.author,
                book.slug,
                book.book_cover,
                book.published_date,
                book.total_pages,
                book.description,
                book_collection.read_page,
                book_collection.rating, 
                book_collection.review,
                book_collection.id as collection_id'
            )
            ->join('book', 'book.id = book_collection.book_id')
            ->where('book_collection.user_id', $userId)
            ->get()
            ->getResultArray();
    }


    public function findBookCollectionDetail(int $collectionId){
        return $this->db->table($this->table)
            ->select("
                book_collection.id as collection_id,
                book_collection.user_id,
                book_collection.book_id,
                book_collection.read_page,
                book_collection.rating,
                book_collection.review,
                book_collection.created_at as added_at,
                book.title,
                book.author,
                book.book_cover,
                book.slug,
                book.published_date,
                book.total_pages,
                book.description,
                GROUP_CONCAT(genres.genre_name SEPARATOR ', ') as genres
            ")
            ->join('book', 'book.id = book_collection.book_id')
            ->join('book_genres', 'book_genres.book_id = book.id', 'left')
            ->join('genres', 'genres.id = book_genres.genre_id', 'left')
            ->where('book_collection.id', $collectionId)
            ->groupBy('book_collection.id')
            ->get()
            ->getFirstRow('array');
    }

    function getBookCount(int $userId) {
        return $this->where('user_id', $userId)->countAllResults();
    }

    public function findBookByUserAndSlug($userId, $bookId){
        return $this -> where('user_id', $userId)
                     -> where('slug', $bookId)
                     -> first();
    }

    public function updateReadingSession(int $bookCollectionId, int $newDuration, int $newPagesRead): bool {
        $this   -> where ("id", $bookCollectionId)
                -> set("read_duration", "read_duration + " . (int)$newDuration, false)
                -> set("read_page", "read_page +" . (int)$newPagesRead, false)
                -> update();

        $dbError = $this -> db -> error();
        if (!empty($dbError['message'])) {
            log_message('error', 'DB Error on updating progress: ' . print_r($dbError, true));
            return false;
        }

        return true;
    }

}