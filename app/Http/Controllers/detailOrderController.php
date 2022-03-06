<?php

namespace App\Http\Controllers;

use App\detailOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class detailOrderController extends Controller
{
    public function show()
    {
        $data = DB::table('detail_order')
            ->join('orders', 'detail_order.id_transaksi', '=', 'orders.id_transaksi')
            ->join('product', 'detail_order.id_produk', '=', 'product.id_produk')
            ->select('orders.id_transaksi', 'orders.tgl_transaksi', 'product.nama_produk', 'detail_order.qty', 'detail_order.subtotal')
            ->get();
        return Response()->json($data);
    }
    
    public function detail($id)
    {
        if(detailOrder::where('id_detail_transaksi', $id)->exists()) { 
            $data = DB::table('detail_order')
            ->where('id_detail_transaksi', '=', $id) 
            ->select('detail_order.*')
            ->get();

            return Response()->json($data);
        } 
        else { 
            return Response()->json(['message' => 'Tidak ditemukan' ]); 
        }
    }
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),
            [
            'id_transaksi' => 'required',
            'id_produk' => 'required',
            'qty' => 'required'
            ]
        );
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }
        $id_produk = $request->id_produk;
        $qty = $request->qty;
        $harga = DB::table('product')->where('id_produk', $id_produk)->value('harga');
        $subtotal = $harga * $qty;
        
        $simpan = detailOrder::create([
            'id_transaksi' => $request->id_transaksi,
            'id_produk' => $id_produk,
            'qty' => $qty,
            'subtotal' => $subtotal
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
            'id_transaksi'=>'required',
            'id_produk'=>'required',
            'qty'=>'required',
            'subtotal'=>'required'
            ]
        );

        if($validator->fails()) {
            return Response()->json($validator->errors());
        }

        $ubah = detailOrder::where('id_detail_transaksi', $id)->update([
            'id_transaksi'=> $request->id_transaksi,
            'id_produk'=> $request->id_produk,
            'qty'=> $request->qty,
            'subtotal'=> $request->subtotal
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
        $hapus = detailOrder::where('id_detail_transaksi', $id)->delete();
        if($hapus) {
            return Response()->json(['status' => 1]);
        }
        else {
            return Response()->json(['status' => 0]);
        }
    }
}