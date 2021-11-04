<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    protected $fillable = [
        'jenis_transaksi',
        'tanggal_transaksi',
        'nominal_transaksi',
        'keterangan_transaksi',
        'bukti_transaksi',
    ];
}
