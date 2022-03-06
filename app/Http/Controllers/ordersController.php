<?php

namespace App\Http\Controllers;

use App\orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ordersController extends Controller
{
    public function show(){
        $data = DB::table('orders')
        ->join('customers','orders.id_pelanggan','=','customers.id_pelanggan')
        ->join('officer','orders.id_petugas','=','officer.id_petugas')
        ->select('orders.id_transaksi','orders.tgl_transaksi','customers.id_pelanggan','officer.id_petugas')
        ->get();
        return Response()->json($data);
    }
    public function detail($id){
        if(orders::where('id_transaksi', $id)->exists()){
            $data_orders = DB::table('orders')
            ->join('customers','orders.id_pelanggan','=','customers.id_pelanggan')
            ->join('officer','orders.id_petugas','=','officer.id_petugas')
            ->select('orders.id_transaksi','orders.tgl_transaksi','customers.id_pelanggan','officer.id_petugas')
            ->where('orders.id_transaksi','=',$id)
            ->get();
            return Response()->json($data_orders);
        }else{
            return Response()->json(['message' => 'Tidak Ditemukan']);
        }
    }
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),
            [
            'id_pelanggan' => 'required',
            'id_petugas' => 'required',
            ]
        );
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }
        $simpan = orders::create([
            'id_pelanggan' => $request->id_pelanggan,
            'id_petugas' => $request->id_petugas,
            'tgl_transaksi' => date("Y-m-d")
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
            'id_pelanggan'=>'required',
            'id_petugas'=>'required',
            'tgl_transaksi'=>'required'
            ]
        );

        if($validator->fails()) {
            return Response()->json($validator->errors());
        }

        $ubah = orders::where('id_transaksi', $id)->update([
            'id_pelanggan'=> $request->id_pelanggan,
            'id_petugas'=> $request->id_petugas,
            'tgl_transaksi'=> $request->tgl_transaksi
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
        $hapus = orders::where('id_transaksi', $id)->delete();
        if($hapus) {
            return Response()->json(['status' => 1]);
        }
        else {
            return Response()->json(['status' => 0]);
        }
    }
}