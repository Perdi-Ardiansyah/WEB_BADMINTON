<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class User extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Validasi login admin
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Data Pengguna',
            'users' => $this->userModel->findAll()
        ];

        return view('admin/user/index', $data);
    }

    public function create()
    {
        // Validasi login admin
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Tambah Pengguna'
        ];

        return view('admin/user/create', $data);
    }

    public function store()
    {
        // Validasi login admin
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        // Validasi input
        if (!$this->validate([
            'nama' => 'required|min_length[3]',
            'username' => 'required|min_length[3]|is_unique[users.username]',
            'whatsapp' => 'required|numeric|min_length[10]|max_length[15]',
            'password' => 'required|min_length[6]',
            'role' => 'required|in_list[admin,client]'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Simpan user
        $this->userModel->insert([
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'whatsapp' => $this->request->getPost('whatsapp'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => $this->request->getPost('role'),
            'foto' => 'default.jpg'
        ]);

        return redirect()->to('/admin/pengguna')->with('success', 'Pengguna berhasil ditambahkan');
    }

    public function edit($id)
    {
        // Validasi login admin
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/admin/pengguna')->with('error', 'Pengguna tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Pengguna',
            'user' => $user
        ];

        return view('admin/user/edit', $data);
    }

    public function update($id)
    {
        // Validasi login admin
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/admin/pengguna')->with('error', 'Pengguna tidak ditemukan');
        }

        // Validasi input
        $rules = [
            'nama' => 'required|min_length[3]',
            'username' => 'required|min_length[3]',
            'whatsapp' => 'required|numeric|min_length[10]|max_length[15]',
            'role' => 'required|in_list[admin,client]'
        ];

        // Check unique username (exclude current user)
        if ($this->request->getPost('username') !== $user['username']) {
            $rules['username'] .= '|is_unique[users.username]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Update data
        $updateData = [
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'whatsapp' => $this->request->getPost('whatsapp'),
            'role' => $this->request->getPost('role')
        ];

        // Update password jika diisi
        if ($this->request->getPost('password')) {
            if (strlen($this->request->getPost('password')) < 6) {
                return redirect()->back()->withInput()->with('error', 'Password minimal 6 karakter');
            }
            $updateData['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $updateData);

        return redirect()->to('/admin/pengguna')->with('success', 'Pengguna berhasil diperbarui');
    }

    public function delete($id)
    {
        // Validasi login admin
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/admin/pengguna')->with('error', 'Pengguna tidak ditemukan');
        }

        // Prevent deleting own account
        if ($user['id_user'] == session()->get('id_user')) {
            return redirect()->to('/admin/pengguna')->with('error', 'Tidak dapat menghapus akun sendiri');
        }

        $this->userModel->delete($id);

        return redirect()->to('/admin/pengguna')->with('success', 'Pengguna berhasil dihapus');
    }
}
