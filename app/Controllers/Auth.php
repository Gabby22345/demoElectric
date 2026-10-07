<?php

namespace App\Controllers;

use App\Models\User;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        $data = [
            'title' => 'Login - Puihaha Electric',
            'error' => session()->getFlashdata('error'),
        ];

        if (strtolower($this->request->getMethod()) !== 'post') {
            return view('auth/login', $data);
        }

        $login = trim((string) $this->request->getPost('email'));
        $password = (string) $this->request->getPost('password');

        if ($login === '' || $password === '') {
            return view('auth/login', array_merge($data, ['error' => 'Enter your email/username and password.']));
        }

        // Accept the normal email address and simple username-style values
        // such as "admin" used by some existing databases.
        $userModel = new User();
        $matchingUsers = $userModel->groupStart()
            ->where('email', $login)
            ->orWhere('first_name', $login)
            ->orWhere('last_name', $login)
            ->groupEnd()
            ->findAll();

        // Check every matching record so duplicate existing email rows do not
        // prevent a valid password from being accepted.
        $user = null;
        foreach ($matchingUsers as $candidate) {
            if ((bool) ($candidate['is_active'] ?? true)
                && !empty($candidate['password'])
                && password_verify($password, $candidate['password'])) {
                $user = $candidate;
                break;
            }
        }

        if (!$user) {
            return view('auth/login', array_merge($data, ['error' => 'The email or password is incorrect.']));
        }

        session()->regenerate(true);
        session()->set([
            'user_id' => $user['id'],
            'user_name' => trim($user['first_name'] . ' ' . $user['last_name']),
            'user_email' => $user['email'],
            'isLoggedIn' => true,
        ]);

        return redirect()->to('/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'You have been logged out.');
    }
}
