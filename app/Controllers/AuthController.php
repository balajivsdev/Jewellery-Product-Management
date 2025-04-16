<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function register()
    {
        echo view('layouts/header');
        echo view('auth/register');
        echo view('layouts/footer');
    }

    public function register_save()
    {
        $rules_for_register = [
            'username' => 'required',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'password_confirm' => 'matches[password]'
        ];

        if (!$this->validate($rules_for_register)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // print_r($this->request->getPost());
        // exit;
        $model = new UserModel();
        $model->save([
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
        ]);

        return redirect()->to('login')->with('message', 'Registered successfully');
    }
    public function login()
    {
        echo view('layouts/header');
        echo view('auth/login');
        echo view('layouts/footer');
    }

    public function check_login()
    {
        $session = session();
        $model = new UserModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $model->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            $session->set('user_id', $user['id']);
            $session->set('user_name', $user['username']);
            $session->set('logged_in', true);
            return redirect()->to('product')->with('message', 'Logged in successfully');;
        }

        return redirect()->back()->with('error', 'Please check your email and password');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('login')->with('message', 'Logged out successfully');
        
    }
}
