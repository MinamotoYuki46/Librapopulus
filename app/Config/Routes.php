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

    $routes -> get('logout', 'Auth::logout');
});


$routes -> get('/library', 'MainController::library');
$routes -> get('library/book/(:num)/(:segment)', 'Book::index/$1/$2');
$routes -> get('library/book/focus/(:num)/(:segment)', 'Book::focus/$1/$2');
$routes -> get('/library/book/loanrequest', "Book::loanRequest");
$routes -> get('library/book/acceptloan', "Book::acceptLoan");

$routes -> get("profile", "Profile::index");
$routes -> get("profile other", "Profile::otherProfile");
$routes -> get("profile/message", "Profile::message");
$routes -> get("profile/friend", "Profile::friend");

$routes -> get("search", "MainController::search");

$routes -> get("group", "MainController::group");
$routes -> get("group/message", "MainController::groupMessage");
$routes -> get("groups", "MainController::groupList");