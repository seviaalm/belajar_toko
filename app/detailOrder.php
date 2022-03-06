<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detailOrder extends Model
{
    //
    protected $table = 'detail_Order';
    public $timestamps = false;

    protected $fillable = ['id_transaksi', 'id_produk', 'qty', 'subtotal'];
}
