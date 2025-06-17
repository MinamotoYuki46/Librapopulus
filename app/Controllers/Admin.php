<?php

namespace App\Controllers;

use App\Models\ReportModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;
use Dompdf\Options;

class Admin extends BaseController {
    private $reportModel;
    private $spreadSheet;

    public function __construct(){
        $this -> reportModel = new ReportModel();
        $this -> spreadSheet = new Spreadsheet();
    }
    public function index(){
        $reports = $this -> reportModel -> getReportDetail();

        log_message('debug', 'Isi reports: ' . print_r($reports, true));
        
        return view("admin", ['reports' => $reports]);
    }

    public function printReportExcel(){
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

    public function printReportPdf(){
        $reports = $this -> reportModel -> getReportDetail();

        $html = view('pdf_template', ['reports' => $reports]);

        $options = new Options();
        $options -> set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);
        $dompdf -> loadHtml($html);

        $dompdf -> setPaper('A4', 'landscape');
        $dompdf -> render();

        $filename = 'Laporan_Pengguna_' . date('Ymd_His') . '.pdf';

        $dompdf->stream($filename, ['Attachment' => true]);
    }


}