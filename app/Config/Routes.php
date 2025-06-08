<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes -> get('/', 'Home::index');

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


$routes -> group('library', function($routes) {
    $routes -> get('/', 'MainController::library'); 
    $routes -> get('user/(:segment)', 'MainController::userLibrary/$1');

    $routes -> get('(:segment)/(:segment)', 'Book::index/$1/$2');

    $routes -> get('add', 'Book::addBook');
    $routes -> post('proceedAddBook', 'Book::proceedAddBook');

    $routes -> get('book/user/(:num)/(:segment)/edit', 'Book::editMyBook/$1/$2');

    $routes -> get('book/focus/(:num)/(:segment)', 'Book::focus/$1/$2');

    $routes -> get('book/loanrequest', 'Book::loanRequest');
    $routes -> get('book/acceptloan', 'Book::acceptLoan');
});


$routes -> group('profile', function($routes) {
    $routes -> get('message', 'Profile::message');
    $routes -> get('friend', 'Profile::friend');
    $routes -> get('edit', 'Profile::edit');
    $routes -> get('(:segment)', 'Profile::index/$1');
});


$routes -> get("search", "MainController::search");

$routes -> get("group", "MainController::group");
$routes -> get("group/message", "MainController::groupMessage");
$routes -> get("groups", "MainController::groupList");