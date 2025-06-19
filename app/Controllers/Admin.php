<?php

namespace App\Controllers;

use App\Models\BookGenreModel;
use App\Models\BookModel;
use App\Models\GenreModel;
use App\Models\ReportModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;
use CodeIgniter\Exceptions\PageNotFoundException;

class Admin extends BaseController {
    private $reportModel;
    private $spreadSheet;
    private $bookModel;
    private $db;
    private $bookGenreModel;
    private $genreModel;

    public function __construct(){
        $this -> reportModel = new ReportModel();
        $this -> spreadSheet = new Spreadsheet();
        $this -> bookModel = new BookModel();
        $this -> bookGenreModel = new BookGenreModel();
        $this -> genreModel = new GenreModel();
        $this -> db = \Config\Database::connect();
    }
    public function userReport(){
        $reports = $this -> reportModel -> getReportDetail();

        log_message('debug', 'Isi reports: ' . print_r($reports, true));
        
        return view("admin/userreport", ['reports' => $reports]);
    }

    public function printUserReportExcel(){
        $sheet = $this -> spreadSheet -> getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Judul Buku');
        $sheet->setCellValue('C1', 'Email Peminjam');
        $sheet->setCellValue('D1', 'Email Pemilik');
        $sheet->setCellValue('E1', 'Keterangan');
        $sheet->setCellValue('F1', 'Tanggal Laporan');

        $reports = $this -> reportModel -> getReportDetail();

        $row = 2;
        foreach ($reports as $report) {
            $sheet->setCellValue('A' . $row, $report['id']);
            $sheet->setCellValue('B' . $row, $report['book_title']);
            $sheet->setCellValue('C' . $row, $report['borrower_email']);
            $sheet->setCellValue('D' . $row, $report['owner_email']);
            $sheet->setCellValue('E' . $row, $report['message']);
            $sheet->setCellValue('F' . $row, date('d M Y, H:i', strtotime($report['created_at'])));
            $row++;
        }

        $filename = 'Laporan_Pengguna_' . date('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($this -> spreadSheet);
        $writer -> save('php://output');
        exit();
    }

    public function printUserReportPdf(){
        $reports = $this -> reportModel -> getReportDetail();

        $html = view('admin/pdf/user_report_template', ['reports' => $reports]);

        $options = new Options();
        $options -> set('defaultFont', 'Arial');
        // $options->set('isRemoteEnabled', true); 
        $dompdf = new Dompdf($options);
        $dompdf -> loadHtml($html);

        $dompdf -> setPaper('A4', 'landscape');
        $dompdf -> render();

        $filename = 'Laporan_Pengguna_' . date('Ymd_His') . '.pdf';

        $dompdf->stream($filename, ['Attachment' => true]);
    }

    public function bookData(){
        $books = $this->db->table('book')
            ->select('book.*, GROUP_CONCAT(genres.genre_name) as genres')
            ->join('book_genres', 'book_genres.book_id = book.id')
            ->join('genres', 'genres.id = book_genres.genre_id')
            ->groupBy('book.id')
            ->get()
            ->getResultArray();
        
        return view("admin/bookdata", ['books' => $books]);
    }

    public function printBookDataExcel() {
        $sheet = $this -> spreadSheet -> getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Judul');
        $sheet->setCellValue('C1', 'Penulis');
        $sheet->setCellValue('D1', 'Tanggal Terbit');
        $sheet->setCellValue('E1', 'Total Halaman');
        $sheet->setCellValue('F1', 'Deskripsi');
        $sheet->setCellValue('G1', 'Genre');
        $sheet->setCellValue('H1', 'Cover');
        $sheet->setCellValue('I1', 'Ditambahkan');
        $sheet->setCellValue('J1', 'Diubah');

        $books = $this->db->table('book')
            ->select('book.*, GROUP_CONCAT(genres.genre_name) as genres')
            ->join('book_genres', 'book_genres.book_id = book.id')
            ->join('genres', 'genres.id = book_genres.genre_id')
            ->groupBy('book.id')
            ->get()
            ->getResultArray();
        
        $row = 2;
        foreach ($books as $book) {
            $sheet->setCellValue('A' . $row, $book['id']);
            $sheet->setCellValue('B' . $row, $book['title']);
            $sheet->setCellValue('C' . $row, $book['author']);
            $sheet->setCellValue('D' . $row, $book['published_date']);
            $sheet->setCellValue('E' . $row, $book['total_pages']);
            $sheet->setCellValue('F' . $row, $book['description']);
            $sheet->setCellValue('G' . $row, $book['genres'] ?? '-');
            $sheet->setCellValue('I' . $row, date('d M Y, H:i', strtotime($book['created_at'] ?? '')));
            $sheet->setCellValue('J' . $row, date('d M Y, H:i', strtotime($book['updated_at'] ?? '')));
            
            $coverPath = FCPATH . 'uploads/bookcover/' . $book['book_cover'];
            if (file_exists($coverPath) && is_file($coverPath)) {
                $drawing = new Drawing();
                $drawing->setName('Cover');
                $drawing->setDescription('Book Cover');
                $drawing->setPath($coverPath);
                $drawing->setHeight(80); // sesuaikan tinggi gambar
                $drawing->setCoordinates('H' . $row);
                $drawing->setWorksheet($sheet);
            } else {
                $sheet->setCellValue('H' . $row, 'Tidak Ada');
            }
            
            $row++;
        }

        $filename = 'Daftar_Buku_' . date('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($this->spreadSheet);
        $writer->save('php://output');
        exit();
    }

    public function printBookDataPdf(){
        $books = $this->db->table('book')
            ->select('book.*, GROUP_CONCAT(genres.genre_name) as genres')
            ->join('book_genres', 'book_genres.book_id = book.id')
            ->join('genres', 'genres.id = book_genres.genre_id')
            ->groupBy('book.id')
            ->get()
            ->getResultArray();

        $html = view('admin/pdf/book_data_template', ['books' => $books]);

        $options = new Options();
        $options -> set('defaultFont', 'Arial');
        // $options -> set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf -> loadHtml($html);

        $dompdf -> setPaper('A4', 'landscape');
        $dompdf -> render();

        $filename = 'Daftar_Buku_' . date('Ymd_His') . '.pdf';

        $dompdf->stream($filename, ['Attachment' => true]);
    }

    public function importBookExcelForm(){
        return view('admin/book_data_form');
    }

    public function importBookExcel(){
        $file = $this->request->getFile('excel_file');
        if (!$file->isValid()) {
            return redirect()->back()->with('error', 'File tidak valid.');
        }

        $spreadsheet = IOFactory::load($file->getTempName());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        $drawings = $sheet->getDrawingCollection();

        $imageMap = [];

        foreach ($drawings as $drawing) {
            $coordinates = $drawing->getCoordinates();
            $rowNumber = preg_replace('/[^\d]/', '', $coordinates);
            $imageContents = null;
            $ext = 'jpg';

            if ($drawing instanceof MemoryDrawing) {
                ob_start();
                call_user_func($drawing->getRenderingFunction(), $drawing->getImageResource());
                $imageContents = ob_get_contents();
                ob_end_clean();
                $mimeType = $drawing->getMimeType();
                switch ($mimeType) {
                    case 'image/png':
                        $ext = 'png';
                        break;
                    case 'image/jpeg':
                        $ext = 'jpg';
                        break;
                    case 'image/gif':
                        $ext = 'gif';
                        break;
                    default:
                        $ext = 'jpg';
                        break;
                }
            } elseif ($drawing instanceof Drawing) {
                $zipPath = $drawing->getPath();
                $imageContents = file_get_contents($zipPath);
                $pathInfo = pathinfo($zipPath);
                if (isset($pathInfo['extension'])) {
                    $ext = strtolower($pathInfo['extension']);
                }
            }

            if ($imageContents) {
                $imageMap[$rowNumber] = [
                    'extension' => $ext,
                    'contents' => $imageContents
                ];
            }
        }

        for ($i = 1; $i < count($rows); $i++) {
            $row = $rows[$i];
            if (count($row) < 6) continue;

            $dateRaw = $row[2];
            $formattedDate = null;

            if (is_numeric($dateRaw)) {
                $timestamp = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($dateRaw);
                $formattedDate = date('Y-m-d', $timestamp);
            } else {
                $dt = \DateTime::createFromFormat('Y-m-d', $dateRaw)
                    ?: \DateTime::createFromFormat('d/m/Y', $dateRaw);
                if ($dt) {
                    $formattedDate = $dt->format('Y-m-d');
                }
            }

            if (!$formattedDate) continue;

            $title = trim($row[0]);
            $slug = url_title($title, '-', true);
            $bookCoverFilename = null;

            $excelRowNumber = $i + 1;
            if (isset($imageMap[$excelRowNumber])) {
                $coverData = $imageMap[$excelRowNumber];
                $ext = strtolower($coverData['extension']);
                $bookCoverFilename = $slug . '.' . $ext;
                $savePath = WRITEPATH . '../public/uploads/bookcover/' . $bookCoverFilename;
                file_put_contents($savePath, $coverData['contents']);
            }

            $data = [
                'title'         => $title,
                'author'        => $row[1],
                'slug'          => $slug,
                'published_date'=> $formattedDate,
                'total_pages'   => $row[3],
                'description'   => $row[4],
                'book_cover'    => $bookCoverFilename ?? null,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ];

            $existing = $this->bookModel
                ->where('title', $title)
                ->where('author', $row[1])
                ->where('published_date', $formattedDate)
                ->first();

            if ($existing) {
                $this->bookModel->update($existing['id'], $data);
                $bookId = $existing['id'];
            } else {
                $this->bookModel->insert($data);
                $bookId = $this->bookModel->getInsertID();
            }

            $genreNames = array_map('trim', explode(',', $row[5]));
            foreach ($genreNames as $genreName) {
                if ($genreName === '') continue;
                
                $genre = $this->db->table('genres')->where('genre_name', $genreName)->get()->getFirstRow();

                if ($genre) {
                    $genreId = $genre -> id; 
                } else {
                    $this->db->table('genres')->insert(['genre_name' => $genreName]);
                    $genreId = $this->db->insertID();
                }

                $exists = $this->db->table('book_genres')
                    ->where('book_id', $bookId)
                    ->where('genre_id', $genreId)
                    ->get()
                    ->getFirstRow();

                if (!$exists) {
                    $this->db->table('book_genres')->insert([
                        'book_id'  => $bookId,
                        'genre_id' => $genreId,
                    ]);
                }
            }
        }

        return redirect()->to('/admin/bookdata')->with('success', 'Impor data buku berhasil!');
    }

    public function addBook(){
        $data['genres'] = $this -> genreModel->findAll();
        return view('/admin/add', $data);
    }



    public function processAdd(){
        $request = $this -> request;
        $title = $request->getPost('title');
        $author = $request->getPost('author');
        $publishedDate = $request->getPost('published_date');
        $totalPages = $request -> getPost('total_pages');
        $description = $request -> getPost('description');
        
        $existingBook = $this->bookModel
                ->where('title', $title)
                ->where('author', $author)
                ->where('published_date', $publishedDate)
                ->first();
        
        
        if ($existingBook) {
            return redirect()->to('/admin/bookdata')->with('error', 'Kamu sudah menambahkan buku ini ke data sistem.');
            
        } 
        
        $cover = $request->getFile('cover');

        $slug = url_title($request->getPost('title'), '-', true);

        if (!$cover -> isValid() || $cover -> hasMoved()) {
            return redirect() -> back() -> withInput() -> with('error', 'Gagal upload cover');
        }

        $extension = $cover -> getClientExtension();
        $coverFileName = $slug . '.' . $extension;
        $cover -> move(FCPATH . 'uploads/bookcover', $coverFileName);

        $bookData = [
            'title' => $title,
            'author' => $author,
            'slug' => $slug,
            'book_cover' => $coverFileName,
            'published_date' => $publishedDate,
            'total_pages' => $totalPages,
            'description' => $description,
        ];

        $bookId = $this -> bookModel->insert($bookData, true);

        $genreIds = $this->request->getPost('genres');
        if ($genreIds) {
            foreach ($genreIds as $genreId) {
                $this-> bookGenreModel -> insert([
                    'book_id' => $bookId,
                    'genre_id' => $genreId
                ]);
            }
        }

        return redirect() -> to('/admin/bookdata')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function editBook(int $bookId){
        $book = $this -> bookModel->find($bookId);
        $bookGenreIds = $this -> bookGenreModel->where('book_id', $bookId)->findColumn('genre_id');

        return view('admin/edit', [
            'book' => $book,
            'genres' => $this-> genreModel->findAll(),
            'bookGenreIds' => $bookGenreIds,
        ]);
    }

    public function processEdit(int $bookId){
        $book = $this -> bookModel;

        $validation = \Config\Services::validation();

        $rules = [
            'title'         => 'required',
            'author'        => 'required',
            'total_pages'   => 'required|integer|greater_than_equal_to[1]',
            'published_date'=> 'permit_empty|valid_date',
            'description'   => 'permit_empty',
            'cover'         => 'permit_empty|uploaded[cover]|is_image[cover]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'title'         => $this->request->getPost('title'),
            'author'        => $this->request->getPost('author'),
            'total_pages'   => $this->request->getPost('total_pages'),
            'published_date'=> $this->request->getPost('published_date'),
            'description'   => $this->request->getPost('description'),
        ];

        $cover = $this->request->getFile('cover');
        if ($cover && $cover->isValid() && !$cover->hasMoved()) {
            $newName = $cover->getRandomName();
            $cover->move('uploads/bookcover', $newName);
            $data['cover'] = $newName;

            $oldData = $book -> find($bookId);
            if (!empty($oldData->book_cover) && file_exists(FCPATH . 'uploads/bookcover/' . $oldData->book_cover)) {
                unlink(FCPATH . 'uploads/bookcover/' . $oldData->book_cover);
            }
        }

        $book -> update($bookId, $data);

        $selectedGenres = $this->request->getPost('genres') ?? [];
        $this -> bookGenreModel ->where('book_id', $bookId)->delete();
        foreach ($selectedGenres as $genreId) {
            $this -> bookGenreModel->insert([
                'book_id' => $bookId,
                'genre_id' => $genreId
            ]);
        }
        return redirect()->to(base_url('/admin/bookdata'))->with('success', 'Data buku berhasil diperbarui.');
    }

    public function deleteBook(int $bookId){
        if (!$bookId) {
            throw new PageNotFoundException('Buku tidak ditemukan.');
        }

        $this -> bookModel -> delete('id', $bookId);
        return redirect() -> to(base_url('/admin/bookdata'))
                        -> with('success', 'Buku berhasil dihapus dari data sistem.');
    }

}