<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Obat;
use App\Models\PenerimaanDetail;
use App\Models\PenerimaanHeader;
use App\Models\Riwayat;
use Config\Services;

class PenerimaanController extends BaseController
{
    public function __construct()
    {
        $this->title = 'Penerimaan Obat';
        $this->obat = new Obat();
        $this->header = new PenerimaanHeader();
        $this->detail = new PenerimaanDetail();
        $this->obat = new Obat();
        $this->riwayat = new Riwayat();
        $this->services = new Services();
    }

    public function index()
    {
        $data['validation'] = $this->services::validation();
        $data['title'] = $this->title;
        $data['listHeader'] = $this->header->findAll();
        $data['breadcrumb'] = $this->breadcrumb($this->title);
        return view('penerimaan/index', $data);
    }

    public function create()
    {
        $data['title'] = $this->title;
        $data['listObat'] = $this->obat->findAll();
        $data['breadcrumb'] = $this->breadcrumb($this->title);
        return view('penerimaan/create', $data);
    }

    public function store()
    {
        // Panggil library validation
        $validation = $this->services::validation();
        // Tangkap data dari inputan
        $data = [
            'no_faktur' => $this->request->getVar('no_faktur'),
            'tanggal' => $this->request->getVar('tanggal'),
            'sp' => $this->request->getVar('sp'),
            'nama_supplier' => $this->request->getVar('nama_supplier')
        ];
        // Lakukan validasi data yang diinput berdasarkan file app/Config/Validation.php
        // Jika validasi sukses
        if ($validation->run($data, 'penerimaan')) {
            // Simpan data ke tabel
            $this->header->save($data);
            $jumlah = count($this->request->getvar('id_obat'));
            for ($i=0; $i < $jumlah; $i++) { 
                $id_obat = $this->request->getVar('id_obat')[$i];
                $quantity = $this->request->getVar('quantity')[$i];
                if ($quantity == true) {
                    $data = [
                        'id_penerimaan_header' => $this->header->getInsertID(),
                        'id_obat' => $id_obat,
                        'quantity' => $quantity
                    ];
                    $this->detail->save($data);

                    $obat = $this->obat->find($id_obat);
                    $stok = $obat['stok'] + $quantity;
                    $this->obat->save([
                        'id' => $id_obat,
                        'stok' => $stok, ['id' => $id_obat]
                    ]);

                    $this->riwayat->save([
                        'nama' => $obat['nama'],
                        'tanggal' => date('Y-m-d h:i:s'),
                        'stok_awal' => $obat['stok'],
                        'stok_perubahan' => $quantity,
                        'stok_akhir' => $stok,
                        'status' => 'Penerimaan',
                        'id_header' => $this->detail->getInsertID()
                    ]);
                }
            }
            return redirect()->to(route_to('home.index'));

            // jika validasi gagal
        } else {
            // Meneruskan data error dari validasi ke view
            session()->setFlashdata('errors', $validation->getErrors());
            // Redirect + pesan gagal
            return redirect()->to(route_to('kategori.index'))->with('error', 'Data Kategori Obat Gagal Disimpan');
        }
    }

    public function detail($id)
    {
        $data['validation'] = $this->services::validation();
        $data['title'] = $this->title;
        // $data['listObat'] = $this->obat->where('stok >', 0)->get()->getResultArray();
        $data['breadcrumb'] = $this->breadcrumb($this->title);
        $data['header'] = $this->header->find($id);
        $data['listPenerimaan'] = $this->detail->select('penerimaan_detail.id, obat.nama, obat.satuan, penerimaan_detail.quantity')->join('obat', 'obat.id = penerimaan_detail.id_obat')->where('id_penerimaan_header', $id)->findAll();
        // dd($data);
        return view('penerimaan/detail', $data);
    }




}