<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\officer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class officerController extends Controller
{
    //
    public function show()
    {
        return officer::all();
    }
    public function detail($id)
    {
        if(officer::where('id_petugas', $id)->exists()){
            $data_officer = DB::table('officer')->where('officer.id_petugas', '=', $id)->get();
            return Response()->json($data_officer);
        } else{
            return Response() ->json(['message' => 'Tidak ditemukan']);
        }
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(),
            [
                'nama_petugas'=>'required',
                'username'=>'required',
                'password'=>'required',
                'level'=>'required'
            ]
        );

        if($validator->fails()) {
            return Response()->json($validator->errors());
        }

        $simpan = officer::create([
            'nama_petugas'=>$request->nama_petugas,
            'username'=>$request->username,
            'password'=>$request->password,
            'level'=>$request->level
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
            'nama_petugas'=>'required',
            'username'=>'required',
            'password'=>'required',
            'level'=>'required'
            ]
        );

        if($validator->fails()) {
            return Response()->json($validator->errors());
        }

        $ubah = officer::where('id_petugas', $id)->update([
            'nama_petugas'=> $request->nama_petugas,
            'username'=> $request->username,
            'password'=> $request->password,
            'level'=>$request->level
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
        $hapus = officer::where('id_petugas', $id)->delete();
        if($hapus) {
            return Response()->json(['status' => 1]);
        }
        else {
            return Response()->json(['status' => 0]);
        }
    }
}

