<?php

namespace App\Models;

use CodeIgniter\Model;

class PenerimaanDetail extends Model
{
    protected $table            = 'penerimaan_detail';
    protected $allowedFields    = ['id', 'id_penerimaan_header', 'id_obat', 'quantity'];

    // Dates
    protected $useTimestamps = true;
    
}