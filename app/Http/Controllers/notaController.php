<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\models\peminjaman;
use App\Models\nota;
class notaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nota = DB::select('SELECT * FROM allnota');
        return response()->json(['data'=>$nota], 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $peminjaman = DB::select('');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'i' => 'required|numeric',
            'tp' => 'required|date',
            'tk' => 'date',
            'td' => 'required|date',
            'jd' => 'numeric',
            'jr' => 'numeric',
            'isbn' =>'required'
            
        ]);
        $books = $request->input('isbn');
        $bookArr = explode(',',$books);
        
        $layer = DB::select('CALL createPeminjaman('.
        $request->input("i")
        .',\''.
        $request->input("tp")
        .'\','.
        (null != $request->input("tk") ? '\''.$request->input("tk").'\'' : null)
        .',\''.
        $request->input("td")
        .'\','.
        (null != $request->input("jd") ? $request->input("jd") : null)
        .','.
        (null != $request->input("jr") ? $request->input("jr") : null)
        .',\''.
        now()
        .'\')');
        
        
        foreach ($bookArr as $book) {
            $dataBaru = peminjaman::where('created_at',now())->first();
            $nota = DB::select('CALL createNota('.
            $dataBaru->id
            .',\''.
            $book
            .'\')');
        }
        return $nota;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $nota = DB::select('CALL GetAllData('.$id.')');
        return response()->json(['data'=>$nota], 200, [], JSON_PRETTY_PRINT);
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

        $request->validate([
            'i' => 'numeric',
            'tp' => 'date',
            'tk' => 'date',
            'td' => 'date',
            'jd' => 'numeric',
            'jr' => 'numeric',
            'isbn' =>'string'
            
        ]);
        $data_old = peminjaman::findOrFail($id);
        $books = $request->input('isbn');
        $bookArr = explode(',',$books);
        
        $layer = DB::select('CALL updatePeminjaman('.
        (null != $request->input("i") ? $request->input("i") : $data_old->anggota_id)
        .','.
        (null != $request->input("tp") ? '\''.$request->input("tp").'\'' :  '\''.$data_old->tanggal_pinjam.'\'')
        .','.
        (null != $request->input("tk") ? '\''.$request->input("tk").'\'' :  '\''.$data_old->tanggal_kembali.'\'')
        .','.
        (null != $request->input("td") ? '\''.$request->input("td").'\'' :  '\''.$data_old->tanggal_pinjam.'\'')
        .','.
        (null != $request->input("jd") ? $request->input("jd") : $data_old->jumlah_denda)
        .','.
        (null != $request->input("jr") ? $request->input("jr") : $data_old->jumlah_dibayar)
        .',\''.
        now()
        .'\')');
        $nota_old = nota::where('pembayaran_id',$data_old->id)->get();
        
        for ($i=0; $i < $nota_old->count(); $i++) { 
            $nota = DB::select('CALL updateNota('.
            $nota_old[$i]->id
            .','.
            $data_old->id
            .',\''.
            (null != $bookArr[$i] ?$bookArr[$i] : $nota_old[$i]->ISBN)
            .'\')');
        }
        return $nota;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = peminjaman::findOrFail($id);
        // dd($data);
        $data->delete();
        return redirect('api/nota');
    }
}
