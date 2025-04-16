<?php 

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session()->get('user_id')) {
            return redirect()->to(base_url('login'));
        }

        echo view('layouts/header');
        echo view('dashboard');
        echo view('layouts/footer');
       
    }

}
