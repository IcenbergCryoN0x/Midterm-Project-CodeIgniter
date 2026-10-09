<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    public function attemptLogin()
    {
        $session = session();
        $model = new UserModel();

        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');

        $user = $model->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            $session->regenerate();

            $session->set([
                'user_id'   => $user['id'],
                'username'  => $user['username'],
                'full_name' => $user['full_name'],
                'isLoggedIn' => true,
            ]);

            return redirect()->to('/dashboard');
        }

        return redirect()->to('/login')
            ->with('error', 'Invalid username or password.');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/login');
    }
}