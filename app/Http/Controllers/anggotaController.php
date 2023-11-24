<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\anggota;
class anggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = DB::select('SELECT * FROM anggotaAll');
        return response()->json(['data'=>$data], 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fn' => 'required|string',
            'ls' => 'required|string', 
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:13'
        ]);
        $anggota = DB::select('CALL createAnggota(\''.
        $request->input("fn").'\',\''.
        $request->input("ls").'\',\''.
        $request->input("alamat").'\',\''.
        $request->input("no_telepon").'\')');
        return response()->json(['message'=>$anggota]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = DB::select('SELECT * FROM anggotaAll WHERE id ='.$id);
        return response()->json(['data'=>$data], 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $anggota_old = anggota::findOrFail($id);
        $anggota = DB::select('CALL updateAnggota(\''.
        $anggota_old->id
        .'\',\''.
        (null != $request->input("fn") ? $request->input("fn") : $anggota_old->fn )
        .'\',\''.
        (null != $request->input("ls") ? $request->input("ls") : $anggota_old->ls) 
        .'\',\''.
        (null != $request->input("alamat") ? $request->input("alamat") : $anggota_old->alamat) 
        .'\',\''.
        (null != $request->input("no_telepon") ? $request->input("no_telepon") : $anggota_old->no_telepon )
        .'\')');
        return response()->json(['message'=>$anggota]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $anggota = anggota::findOrFail($id);
            $anggota->delete();
        } catch (\Throwable $th) {
           return response()->json(['message'=>'Data tidak ditemukan atau sudah dihapus']);
        }
        
        return redirect('/api/anggota');
    }
}
