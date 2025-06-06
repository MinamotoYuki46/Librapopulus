<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class BookSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'title' => 'Wuthering Heights',
            'author'    => 'Emily Brontë',
            'slug' => 'wuthering-heights',
            'book_cover' => 'https://m.media-amazon.com/images/I/81-8dCuxEsL._SY466_.jpg',
            'published_date' =>'1847-12-01',
            'total_pages' => '416',
            'description' => 'Wuthering Heights is a classic novel of intense passion and revenge, 
                              set on the bleak Yorkshire moors. 
                              It tells the tragic story of Heathcliff and Catherine Earnshaw, 
                              and explores themes of love, class, and destiny.',
            'created_at' => Time::now(),
            'updated_at' => Time::now()
        ];

        $this->db->table('book')->insert($data);
    }
}
