<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Pengguna;

class AuthController extends BaseController
{

    public function __construct()
    {
        $this->pengguna = new Pengguna();
    }

    public function index()
    {
        if (session('id_pengguna') && session('nama_pengguna') && session('hak_akses_pengguna')) {
            return redirect()->to(base_url('/'));
        }
        return view('auth/login');
    }

    public function login()
    {
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $pengguna = $this->pengguna->where('username', $username)->first();
        if ($pengguna) {
            if (password_verify($password, $pengguna['password'])) {
                $session_data = [
                    'id_pengguna' => $pengguna['id'],
                    'nama_pengguna' => $pengguna['nama'],
                    'hak_akses_pengguna' => $pengguna['hak_akses']
                ];
                session()->set($session_data);
                return redirect()->to(base_url('/'));
            } else {
                return redirect()->to(base_url('login'))->withInput()->with('danger', 'Password tidak sesuai');
            }
        } else {
            return redirect()->to(base_url('login'))->withInput()->with('danger', 'Username tidak ditemukan');
        }

    }

    public function edit($id_pengguna)
    {
        $data['title'] = "Ubah Password";
        $data['breadcrumb'] = $this->breadcrumb($data['title']);
        return view('auth/password', $data);
    }

    public function update($id_pengguna)
    {
        $passwordLama = $this->request->getVar('password_lama');
        $passwordBaru = $this->request->getVar('password_baru');
        $konfirmPassword = $this->request->getVar('konfirmasi_password');

        $pengguna = $this->pengguna->where('id', $id_pengguna)->first();
        if(password_verify($passwordLama, $pengguna['password'])) {
            if ($passwordBaru == $konfirmPassword) {
                $this->pengguna->save([
                    'id' => $id_pengguna,
                    'password' => password_hash($this->request->getVar('password_baru'), PASSWORD_DEFAULT)
                ], ['id' => $id_pengguna]);
                return redirect()->to(base_url('/'))->with('success', 'Password berhasil diubah');
            } else {
                return redirect()->to(base_url('edit-password/'. $id_pengguna))->with('danger', 'Konfirmasi password tidak sesuai');
            }
        } else {
            return redirect()->to(base_url('edit-password/'. $id_pengguna))->with('danger', 'Password salah');
        }
    }

    public function logout() 
    {
        session()->remove('id_pengguna');
        session()->remove('nama_pengguna');
        session()->remove('hak_akses_pengguna');
        return redirect()->to(base_url('login'));
    }
}