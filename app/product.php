<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    //
    protected $table = 'product';
    public $timestamps = false;

    protected $fillable = ['nama_produk', 'deskripsi', 'harga', 'foto_produk'];
}

