<?php

namespace App\Controllers;

use App\Models\ReportModel;

class Admin extends BaseController {
    private $reportModel;

    public function __construct(){
        $this -> reportModel = new ReportModel();
    }
    public function index(){
        $reports = $this -> reportModel -> getReportDetail();

        log_message('debug', 'Isi reports: ' . print_r($reports, true));
        
        return view("admin", ['reports' => $reports]);
    }


}