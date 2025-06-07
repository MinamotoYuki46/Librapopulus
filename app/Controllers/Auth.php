<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\TmpRegisterProcessModel;

class Auth extends BaseController {
    private $userModel;
    private $tmpRegisterModel;
    
    public function __construct() {
        $this -> userModel = new UserModel();
        $this -> tmpRegisterModel = new TmpRegisterProcessModel();
    }
    
    public function index(){
        $this -> destroyRegisterSession();
        return redirect() -> to(base_url('auth/login'));
    }
    
    public function login() {
        if (session() -> get('isLoggedIn')) {
            return redirect() -> to(base_url('dashboard'));
        }
        
        $this -> destroyRegisterSession();
        return view('auth/login');
    }
    
    public function register() {
        if (session() -> get('isLoggedIn')) {
            return redirect() -> to(base_url('dashboard'));
        }
        
        $this -> destroyRegisterSession();

        return view('auth/register');
    }

    public function detail() {
        if (session() -> get('isLoggedIn')) {
            return redirect() -> to(base_url('dashboard'));
        }

        $registerData = session() -> get('register_data');

        if(!$registerData || $registerData['step'] !== 'detail') {
            return redirect() -> to(base_url('auth/register'));
        }

        return view('auth/detail');
    }

    public function success() {
        if (session() -> get('isLoggedIn')) {
            return redirect() -> to(base_url('dashboard'));
        }

        $registerData = session() -> get('register_data');

        if(!$registerData || $registerData['step'] !== 'success') {
            return redirect() -> to(base_url('auth/register'));
        }

        
        $tmpId = $registerData['tmp_id'];

        $tmp = $this -> tmpRegisterModel -> find($tmpId);

        if (!$tmp) {
            return redirect() -> to(base_url('auth/register'))->with('error', 'Data registrasi tidak ditemukan.');
        }

        $userData = [
            'username' => $tmp['username'],
            'email'    => $tmp['email'],
            'password' => $tmp['password'],
            'full_name' => $tmp['full_name'],
            'city' => $tmp['city'],
            'province' => $tmp['province'],
            'description' => $tmp['description'],
            'favorite_genres' => $tmp['favorite_genres'],
            'picture' => $tmp['picture']
        ];

        $this -> userModel -> insert($userData);
        $userId = $this -> userModel -> getInsertID();

        $this -> destroyRegisterSession();

        session() -> set([
            'isLoggedIn' => true,
            'user_id'    => $userId, 
            'username'   => $tmp['username']
        ]);

        return view('auth/success');
    }
    
    public function processLogin() {
        $session = session();
        $identity = $this -> request -> getPost('identity'); 
        $password = $this -> request -> getPost('password');

        $user = $this -> userModel
            -> where('username', $identity)
            -> orWhere('email', $identity)
            -> first();

        if ($user && password_verify($password, $user['password'])) {
            $session -> set([
                'isLoggedIn' => true,
                'userId'    => $user['id']
            ]);
            return redirect() -> to(base_url());
        } else {
            return redirect() -> back() -> with('error', 'Username/email atau password salah!');
        }
    }
    
    public function processRegister() {
        $username = $this -> request -> getPost('username');
        $email = $this -> request -> getPost('email');
        $password = $this -> request -> getPost('password');
        $confirmPassword = $this -> request -> getPost('confirmPassword');

        $rules = $this -> userModel -> getValidationRules();
        $messageValidate = $this -> userModel -> getValidationMessages();

        if(!$this -> validate($rules, $messageValidate)){
            return redirect() -> back() -> with('errors', $this -> validator -> getErrors());
        }

        if($password != $confirmPassword){
            return redirect() -> back() -> with('error', 'konfirmasi Password Gagal');
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $userData = [
            'username' => $username,
            'email' => $email,
            'password' => $hashedPassword
        ];

        $this -> tmpRegisterModel -> insert($userData);
        $newTmpId = $this -> tmpRegisterModel -> getInsertID();

        session() -> set('register_data', [
            'step' => 'detail',
            'tmp_id' => $newTmpId,
            'username' => $username
        ]);

        return redirect() -> to(base_url('auth/detail'));
    }

    public function processProfile(){
        $registerData = session()->get('register_data');

        if(!$registerData || $registerData['step'] !== 'detail') {
            return redirect()->to(base_url('auth/register'));
        }

        $newTmpId = $registerData['tmp_id'];
        $username = $registerData['username'];

        $file = $this->request->getFile('profile_picture');
        $picture = null;
        if($file && $file->isValid() && !$file->hasMoved()) {
            $folderPath = FCPATH . 'uploads/' . $username . '/profile_picture/';

            if (is_dir($folderPath)) {
                delete_files($folderPath);
            }
            
            if (!is_dir($folderPath)) {
                mkdir($folderPath, 0755, true);
            }
            
            $newFileName = $file->getRandomName();
            $file->move($folderPath, $newFileName);

            $picture = $username . '/profile_picture/' . $newFileName;
        }


        $fullName = $this -> request -> getPost('full_name') ?? null;
        $location = $this -> request -> getPost('city') ?? null;
        $province = null;
        $city = null;
        if ($location && substr_count($location, ',') === 1) {
            [$city, $province] = array_map('trim', explode(',', $location));
        } else {
            return redirect() -> back() -> with('error', 'Format lokasi harus "Kota, Provinsi" dan hanya boleh satu koma.');
        }
        $bio = $this -> request -> getPost('bio') ?? null;
        $favoriteGenresArray = $this -> request -> getPost('genres'); 
        $favoriteGenresJson = $favoriteGenresArray ? json_encode($favoriteGenresArray) : null;

        $profileData = [
            'full_name' => $fullName,
            'city' => $city,
            'province' => $province,
            'description' => $bio,
            'favorite_genres' => $favoriteGenresJson,
            'picture' => $picture
        ];

        $this -> tmpRegisterModel->update($newTmpId, $profileData);

        $registerData['step'] = 'success';
        session() -> set('register_data', $registerData);

        return redirect() -> to(base_url('auth/success'));
    }
    
    public function logout() {
        session() -> destroy();
        
        return redirect() -> to(base_url());
    }

    private function destroyRegisterSession(){
        if(session()->has('register_data')) {
            $registerData = session()->get('register_data');
            $tmpId = $registerData['tmp_id'];

            if($tmpId || $this->tmpRegisterModel->find($tmpId)){
                $this->tmpRegisterModel->delete($tmpId);
            }
            session()->remove('register_data');
        }
    }
}