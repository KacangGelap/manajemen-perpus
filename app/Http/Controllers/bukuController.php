<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\buku;
class bukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = DB::select('CALL GetBuku()');
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
            'i' => 'required|numeric',
            'j' => 'required|string', 
            'p' => 'required|string',
            't' => 'required|numeric'
        ]);
        $book = DB::select('CALL createBuku('.
        $request->input("i").',\''.
        $request->input("j").'\',\''.
        $request->input("p").'\','.
        $request->input("t").')');
        
        return $book;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = DB::select('CALL GetBukuById('.$id.')');
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
    public function update(Request $request, string $isbn)
    {
        $data_old = buku::where('ISBN',$isbn)->first();
        // dd($data_old->ISBN);
        $data = DB::select('CALL updateBuku(\''.
        $data_old->ISBN
        .'\',\''.
        (null != $request->input("i") ? $request->input("i") : $data_old->ISBN )
        .'\',\''.
        (null != $request->input("j") ? $request->input("j") : $data_old->judul) 
        .'\',\''.
        (null != $request->input("p") ? $request->input("p") : $data_old->penulis) 
        .'\',\''.
        (null != $request->input("t") ? $request->input("t") : $data_old->tahun_terbit )
        .'\')');
        return response()->json(['message'=>$data]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $isbn)
    {
        try {
            $data = buku::where('ISBN',$isbn)->first();
            // dd($data);
            $data->delete();
        } catch (\Throwable $th) {
           return response()->json(['message'=>'Data tidak ditemukan atau sudah dihapus']);
        }
        
        return redirect('/api/anggota');
    }
}
