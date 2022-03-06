<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\customers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class customersController extends Controller
{
    public function show()
    {
        return customers::all();
    }
    public function detail($id)
    {
        if(customers::where('id_pelanggan', $id)->exists()){
            $data_customers = DB::table('customers')->where('customers.id_pelanggan', '=', $id)->get();
            return Response()->json($data_customers);
        } else{
            return Response() ->json(['message' => 'Tidak ditemukan']);
        }
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(),
            [
                'nama'=>'required',
                'alamat'=>'required',
                'telp'=>'required'
            ]
        );

        if($validator->fails()) {
            return Response()->json($validator->errors());
        }

        $simpan = customers::create([
            'nama'=>$request->nama,
            'alamat'=>$request->alamat,
            'telp'=>$request->telp
        ]);

        if($simpan)
        {
            return Response()->json(['status'=>1]);
        }
        else
        {
            return Response()->json(['status'=>0]);
        }
    }
    public function update($id, Request $request)
    {
        $validator=Validator::make($request->all(),
            [
            'nama'=>'required',
            'alamat'=>'required',
            'telp'=>'required'
            ]
        );

        if($validator->fails()) {
            return Response()->json($validator->errors());
        }

        $ubah = customers::where('id_pelanggan', $id)->update([
            'nama'=> $request->nama,
            'alamat'=> $request->alamat,
            'telp'=> $request->telp
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
        $hapus = customers::where('id_pelanggan', $id)->delete();
        if($hapus) {
            return Response()->json(['status' => 1]);
        }
        else {
            return Response()->json(['status' => 0]);
        }
    }
}