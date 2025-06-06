<?php 

namespace App\Controllers;

class Book extends BaseController {

    public function index(){
        return view("main/library/bookdetail");
    }

    public function focus() {
        return view("main/library/focusmode");
    }

    public function loanRequest(){
        return view("main/library/loanrequest");
    }

    public function acceptLoan() {
        return view("main/library/acceptloan");
    }
}