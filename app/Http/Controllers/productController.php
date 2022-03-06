<?php

namespace App\Http\Controllers;

use App\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class productController extends Controller
{
    public function show()
    {
        return product::all();
    }
    public function detail($id)
    {
        if(product::where('id_produk', $id)->exists()){
            $data_product = DB::table('product')->where('product.id_produk', '=', $id)->get();
            return Response()->json($data_product);
        } else{
            return Response() ->json(['message' => 'Tidak ditemukan']);
        }
    }
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),
            [
            'nama_produk' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required',
            'foto_produk' => 'required'
            ]
        );
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }
        $simpan = product::create([
            'nama_produk' => $request->nama_produk,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'foto_produk' => $request->foto_produk
        ]);
        if($simpan) {
            return Response()->json(['status'=>1]);
        }
        else {
            return Response()->json(['status'=>0]);
        }
    }
    public function update($id, Request $request)
    {
        $validator=Validator::make($request->all(),
            [
            'nama_produk'=>'required',
            'deskripsi'=>'required',
            'harga'=>'required',
            'foto_produk'=>'required',
            ]
        );

        if($validator->fails()) {
            return Response()->json($validator->errors());
        }

        $ubah = product::where('id_produk', $id)->update([
            'nama_produk'=> $request->nama_produk,
            'deskripsi'=> $request->deskripsi,
            'harga'=> $request->harga,
            'foto_produk'=> $request->foto_produk
        ]);

        if($ubah) {
            return Response()->json(['status' => 1]);
        }
        else {
            return Response()->json(['status' => 0]);
        }
    }
    public function destroy ($id)
    {
        $hapus = product::where('id_produk', $id)->delete();
        if($hapus) {
            return Response()->json(['status' => 1]);
        }
        else {
            return Response()->json(['status' => 0]);
        }
    }
}