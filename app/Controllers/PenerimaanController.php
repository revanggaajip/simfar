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
            return redirect()->to(route_to('penerimaan.index'));

            // jika validasi gagal
        } else {
            // Meneruskan data error dari validasi ke view
            session()->setFlashdata('errors', $validation->getErrors());
            // Redirect + pesan gagal
            return redirect()->to(route_to('penerimaan.index'))->with('error', 'Data Penerimaan Obat Gagal Disimpan');
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

    public function edit($id)
    {
        $data['validation'] = $this->services::validation();
        $data['title'] = $this->title;
        $data['breadcrumb'] = $this->breadcrumb($this->title);
        $data['header'] = $this->header->find($id);
        $datap['listPenerimaan'] = $this->detail->findAll();
        $data['listPenerimaan'] = $this->detail->select('penerimaan_detail.id, penerimaan_detail.id_obat, obat.nama, obat.satuan, penerimaan_detail.quantity')->join('obat', 'obat.id = penerimaan_detail.id_obat')->where('id_penerimaan_header', $id)->findAll();
        return view('penerimaan/edit', $data);
    }

    public function update($id)
    {
         // Panggil library validation
        $validation = $this->services::validation();
        // Tangkap data dari inputan
        $data = array(
            'id' => $id,
            'no_faktur' => $this->request->getPost('no_faktur'),
            'sp' => $this->request->getVar('sp'),
            'nama_supplier' => $this->request->getVar('nama_supplier'),
            'tanggal' => $this->request->getVar('tanggal'),
            'keterangan' => $this->request->getVar('keterangan'),
        );
        // Lakukan validasi data yang diinput berdasarkan file app/Config/Validation.php
        $validationResult  = $validation->run($data, 'penerimaan');
        // Jika validasi sukses
        if ($validationResult) {
            // Simpan data ke tabel
            $this->header->save($data);
            // Redirect ke halaman index + Pesan
            return redirect()->to(route_to('penerimaan.index'))->with('success', 'Data Kategori Non Medis Berhasil Diedit');

            // jika validasi gagal
        } else {
            // Meneruskan data error dari validasi ke view
            session()->setFlashdata('errors', $validation->getErrors());
            // Redirect + pesan gagal
            return redirect()->to(route_to('penerimaan.index'))->with('error', 'Data Kategori Non Medis Gagal Diedit');
        }
    }

        public function delete($id)
        {
            $detail = $this->detail->where('id_penerimaan_header', $id)->findAll();
            // $obat = $this->obat->
            foreach ($detail as $key => $d) {
                $obat = $this->obat->where('id', $d['id_obat'])->first();
                $stok = $obat['stok'] - $d['quantity'];
                if ($stok < 0) {
                    return redirect()->to(route_to('penerimaan.index'))->with('error', 'Stok Obat '. $obat['nama'].  ' Tidak Mencukupi');
                }
                $this->riwayat->save([
                    'nama' => $obat['nama'],
                    'tanggal' => date('Y-m-d h:i:s'),
                    'stok_awal' => $obat['stok'],
                    'stok_perubahan' => $d['quantity'],
                    'stok_akhir' => $stok,
                    'status' => 'Pembatalan Penerimaan',
                    'id_header' => null
                ]);
                $this->obat->save(['id' => $obat['id'], 'stok' => $stok], ['id' => $obat['id']]);
                $this->detail->where('id', $d['id'])->delete();
            }
            $deleted = $this->header->delete(['id', $id]);
            if ($deleted) {
                // Redirect + pesan sukses
                return redirect()->to(route_to('penerimaan.index'))->with('success', 'Data Kategori Non Medis Berhasil Dihapus');
            } else {
                // Redirect + pesan gagal
                return redirect()->to(route_to('penerimaan.index'))->with('error', 'Data Kategori Non Medis Gagal Dihapus');
            }
        }

        public function updateDetail($id, $idHeader)
        {
            // Panggil library validation
            $validation = $this->services::validation();
            // Tangkap data dari inputan
            $quantity = $this->request->getPost('quantity');
            $data = array(
                'id' => $id,
                'quantity' => $quantity
            );
            // Lakukan validasi data yang diinput berdasarkan file app/Config/Validation.php
            $validationResult  = $validation->run($data, 'detailPenerimaan');
            // Jika validasi sukses
            if ($validationResult) {
                $detail = $this->detail->find($id);
                $obat = $this->obat->find($detail['id_obat']);
                $perubahanStok = $detail['quantity'] - $quantity;
                $stokAkhir = $obat['stok'] - $perubahanStok;
                // dd($obat['id']);
                if ($stokAkhir >= 0) {
                    $savedObat = $this->obat->save([
                        'id' => $obat['id'],
                        'stok' => $stokAkhir
                    ], ['id' => $obat['id']]);

                    $savedRiwayat = $this->riwayat->save([
                    'nama' => $obat['nama'],
                    'tanggal' => date('Y-m-d h:i:s'),
                    'stok_awal' => abs($obat['stok']),
                    'stok_perubahan' => abs($perubahanStok),
                    'stok_akhir' => abs($stokAkhir),
                    'status' => 'Perubahan Penerimaan',
                    'id_header' => $id
                    ]);

                    $this->detail->save($data);
                    // Redirect ke halaman index + Pesan
                    return redirect()->to(route_to('penerimaan.detail', $idHeader))->with('success', 'Data Penerimaan Obat Berhasil Diedit');
                }
                // Meneruskan data error dari validasi ke view
                session()->setFlashdata('errors', $validation->getErrors());
                // Redirect + pesan gagal
                return redirect()->to(route_to('penerimaan.index'))->with('error', 'Data Penerimaan Obat Gagal Diedit');
            }
        }

        public function deleteDetail($id, $idHeader)
        {
            $detail = $this->detail->find($id);
            $quantity = $this->request->getPost('quantity');
            $obat = $this->obat->find($detail['id_obat']);
            $perubahanStok = $detail['quantity'] - $quantity;
            $stokAkhir = $obat['stok'] - $perubahanStok;
            if ($stokAkhir >= 0) {
                $this->obat->save([
                    'id' => $obat['id'],
                    'stok' =>$stokAkhir
                ], ['id' => $obat['id']]);
                $this->riwayat->save([
                    'nama' => $obat['nama'],
                    'tanggal' => date('Y-m-d h:i:s'),
                    'stok_awal' => $obat['stok'],
                    'stok_perubahan' => $detail['quantity'],
                    'stok_akhir' => $stokAkhir,
                    'status' => 'Penghapusan Penerimaan',
                    'id_header' => null
                ]);
                $deleted = $this->detail->delete(['id', $id]);
                return redirect()->to(route_to('penerimaan.detail', $idHeader))->with('success', 'Data Penerimaan Obat Berhasil Dihapus');
            } else {
                // Redirect + pesan gagal
                return redirect()->to(route_to('penerimaan.detail', $idHeader))->with('error', 'Data Penerimaan Obat Gagal Dihapus');
            }
        }

    }