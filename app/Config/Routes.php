<?php

use App\Controllers\Message;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes -> get('/', 'Home::index');

$routes -> get('/admin', 'Admin::userReport', ['filter' => 'adminauth']);

$routes -> get('/admin/userreport', 'Admin::userReport', ['filter' => 'adminauth']);
$routes -> get('/admin/user-report/export-excel', 'Admin::printUserReportExcel', ['filter' => 'adminauth']);
$routes -> get('/admin/user-report/export-pdf', 'Admin::printUserReportPdf', ['filter' => 'adminauth']);

$routes -> get('/admin/bookdata', 'Admin::bookData', ['filter' => 'adminauth']);
$routes -> get('/admin/book-data/export-excel', 'Admin::printBookDataExcel', ['filter' => 'adminauth']);
$routes -> get('/admin/book-data/export-pdf', 'Admin::printBookDataPdf', ['filter' => 'adminauth']);

$routes -> get('admin/book-data/importExcelForm', 'Admin::importBookExcelForm');
$routes -> post('admin/book-data/importExcel', 'Admin::importBookExcel');


$routes -> group('auth', function($routes) {
    $routes -> get('/', 'Auth::index');
    $routes -> get('login', 'Auth::login');
    $routes -> get('register', 'Auth::register');
    $routes -> get('detail', 'Auth::detail');
    $routes -> get('success', 'Auth::success');

    $routes -> post('processLogin', 'Auth::processLogin');
    $routes -> post('processRegister', 'Auth::processRegister');
    $routes -> post('processProfileSetup', 'Auth::processProfile');

    $routes -> delete('logout', 'Auth::logout');

    $routes->get('forgot-password', 'Auth::forgotPasswordForm');
    $routes->post('forgot-password', 'Auth::processForgotPassword');
    $routes->get('reset-password/(:segment)', 'Auth::resetPassword/$1');
    $routes->post('reset-password', 'Auth::processResetPassword');

});

$routes -> post("notification/mark-read", "Notification::markRead", ['filter' => 'userauth'], );


$routes -> group('library',['filter' => 'userauth'],  function($routes) {
    $routes -> get('/', 'MainController::library'); 
    $routes -> get('api/search-book', 'Book::searchBook');
    $routes -> get('book/(:segment)', 'Book::book/$1');

    $routes -> get('add', 'Book::addBook');
    $routes -> post('proceedAddBook', 'Book::proceedAddBook');

    $routes -> get('(:segment)', 'MainController::Library/$1');
    $routes -> get('requested-loan/(:num)', 'BookLoan::ownerViewLoan/$1');
    $routes -> get('(:segment)/(:segment)', 'Book::index/$1/$2');


    $routes -> get('(:segment)/(:segment)/edit', 'Book::editMyBook/$1/$2');
    $routes -> post('proceedEditBook/(:num)', 'Book::proceedEditBook/$1');

    $routes -> post('(:segment)/(:segment)/delete', 'Book::deleteBook/$1/$2');

    $routes -> get('(:segment)/(:segment)/focus', 'Book::focus/$1/$2');
    $routes -> post('(:segment)/(:segment)/focus/update', 'Book::focusSend/$1/$2');

    $routes -> get('(:segment)/(:segment)/requestloan', 'BookLoan::requestLoanForm/$1/$2');
    $routes -> post('loan/request', 'BookLoan::request');
    $routes -> post('loan/approve/(:num)', 'BookLoan::approve/$1');
    $routes -> post('loan/decline/(:num)', 'BookLoan::decline/$1');
    $routes -> post('loan/cancel/(:num)', 'BookLoan::cancel/$1');
    $routes -> post('loan/return/(:num)', 'BookLoan::markAsReturned/$1');
    $routes -> post('loan/report/(:num)', 'BookLoan::report/$1');

});


$routes -> group('profile', ['filter' => 'userauth'],  function($routes) {
    $routes -> get('edit', 'Profile::editProfile');
    $routes -> post("update", "Profile::update");
    $routes -> get('friend', 'Profile::friend');
    $routes -> get('(:segment)', 'Profile::index/$1');
});

$routes -> post('friends/add/(:num)', 'Friendship::add/$1', ['filter' => 'userauth']);
$routes -> post('friends/accept/(:num)', 'Friendship::accept/$1', ['filter' => 'userauth']);
$routes -> post('friends/decline/(:num)', 'Friendship::decline/$1', ['filter' => 'userauth']);
$routes -> post('friends/cancel/(:num)', 'Friendship::cancel/$1', ['filter' => 'userauth']);

$routes -> group("message", ['filter' => 'userauth'],  function($routes) {
    $routes -> post('send', 'Message::send');
    $routes -> get('fetch/(:num)', 'Message::fetch/$1');
    $routes -> get('fetch_new/(:num)', 'Message::fetchNew/$1');
    $routes -> get('(:segment)', 'Message::index/$1');
});



$routes -> get("search", "MainController::search", ['filter' => 'userauth']);


$routes -> get("community", "Community::index", ['filter' => 'userauth']);
$routes -> get("group/create", "Community::createGroup", ['filter' => 'userauth'], );
$routes -> post("group/proceedCreateGroup", "Community::proceedCreateGroup", ['filter' => 'userauth']);
$routes -> get("group/(:segment)", "Community::group/$1", ['filter' => 'userauth']);
$routes -> post("group/send", "Community::groupSendMessage", ['filter' => 'userauth']);

$routes -> get("loans", "BookLoan::loanList", ['filter' => 'userauth']);
$routes -> get("borrowed", "BookLoan::borrowList", ['filter' => 'userauth']);