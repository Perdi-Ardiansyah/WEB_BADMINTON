<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Profile extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $userId = session()->get('id_user');
        $user = $this->userModel->find($userId);

        return view('profile/index', ['user' => $user]);
    }

    public function edit()
    {
        $userId = session()->get('id_user');
        $user = $this->userModel->find($userId);

        return view('profile/edit', ['user' => $user]);
    }

    public function update()
    {
        $userId = session()->get('id_user');
        $user = $this->userModel->find($userId);

        // Validation rules
        $rules = [
            'nama' => 'required',
            'username' => 'required'
        ];

        $messages = [
            'nama' => [
                'is_unique' => 'Nama sudah digunakan'
            ],
            'username' => [
                'is_unique' => 'Username sudah digunakan'
            ]
        ];

        // Check unique nama (exclude current user)
        if ($this->request->getPost('nama') !== $user['nama']) {
            $rules['nama'] .= '|is_unique[users.nama]';
        }

        // Check unique username (exclude current user)
        if ($this->request->getPost('username') !== $user['username']) {
            $rules['username'] .= '|is_unique[users.username]';
        }

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $data = [
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        // Handle photo upload
        $file = $this->request->getFile('foto');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/profile', $newName);
            $data['foto'] = $newName;

            // Update session with new photo
            session()->set('foto', $newName);
        }

        $this->userModel->update($userId, $data);

        // Update session with new name
        session()->set('nama', $this->request->getPost('nama'));

        return redirect()->to('/profile')->with('success', 'Profile updated successfully');
    }
}
