<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes -> get('/', 'Home::index');

$routes -> get('/admin', 'Admin::index');

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
});

$routes -> post("notification/mark-read", "Notification::markRead");


$routes -> group('library', function($routes) {
    $routes -> get('/', 'MainController::library'); 

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

});


$routes -> group('profile', function($routes) {
    $routes -> get('edit', 'Profile::editProfile');
    $routes -> post("update", "Profile::update");
    $routes -> get('friend', 'Profile::friend');
    $routes -> get('(:segment)', 'Profile::index/$1');
});

$routes -> post('friends/add/(:num)', 'Friendship::add/$1');
$routes -> post('friends/accept/(:num)', 'Friendship::accept/$1');
$routes -> post('friends/decline/(:num)', 'Friendship::decline/$1');
$routes -> post('friends/cancel/(:num)', 'Friendship::cancel/$1');

$routes -> group("message", function($routes) {
    $routes -> get('(:segment)', 'Message::index/$1');
    $routes -> post('send', 'Message::send');
});



$routes -> get("search", "MainController::search");

$routes -> get("group", "MainController::group");
$routes -> get("group/message", "MainController::groupMessage");
$routes -> get("groups", "MainController::groupList");

$routes -> get("community", "Community::index");