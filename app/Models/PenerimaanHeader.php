<?php

namespace App\Models;

use CodeIgniter\Model;

class PenerimaanHeader extends Model
{
    protected $table            = 'penerimaan_header';
    protected $allowedFields    = ['id', 'no_faktur', 'tanggal', 'sp', 'nama_supplier', 'keterangan'];
    protected $useTimestamps = true;
    
}