<?php

namespace App\Controllers;
use App\Models\UserModel;

class Auth extends BaseController
{
    protected $user;

    public function __construct()
    {
        $this->user = new UserModel();
    }

    public function login()
    {
        return view('auth/login');
    }

    public function prosesLogin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->user->where('username', $username)->first();

        session()->regenerate();
        
        if ($user && password_verify($password, $user['password'])) {

            session()->set([
                'id_user' => $user['id_user'],
                'nama' => $user['nama'],
                'role' => $user['role'],
                'foto' => $user['foto'] ?? null,
                'logged_in' => true
            ]);

            return $this->redirectByRole();
        }

        return redirect()->back()->with('error', 'Username atau password salah');
    }


    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    public function register()
    {
        return view('auth/register');
    }

    public function prosesRegister()
    {
        $rules = [
            'nama' => 'required|is_unique[users.nama]',
            'username' => 'required|is_unique[users.username]',
            'whatsapp' => 'required|numeric|min_length[9]|max_length[15]',
            'password' => 'required|min_length[6]',
        ];

        $messages = [
            'nama' => [
                'is_unique' => 'Nama sudah digunakan'
            ],
            'username' => [
                'is_unique' => 'Username sudah digunakan'
            ],
            'whatsapp' => [
                'required' => 'Nomor WhatsApp harus diisi',
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()
                ->withInput()
                ->with('error', $this->validator->getErrors());
        }

        $this->user->insert([
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'whatsapp' => '+62' . $this->request->getPost('whatsapp'),
            'password' => password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            ),
            'role' => 'client'
        ]);

        return redirect()->to('/login')
            ->with('success', 'Registrasi berhasil, silakan login');

    }

    private function redirectByRole()
    {
        if (session()->get('role') === 'admin') {
            return redirect()->to('/admin/dashboard');
        }

        return redirect()->to('/client/dashboard');
    }
}
