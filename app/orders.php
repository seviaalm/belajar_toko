<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    //
    protected $table = 'orders';
    public $timestamps = false;

    protected $fillable = ['id_pelanggan', 'id_petugas', 'tgl_transaksi'];
}
