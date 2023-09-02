<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{

    public function data(Request $request)
    {
        $query = Kategori::latest()->get();

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('aksi', function ($query) {
                return '
                    <div class="btn-group">
                        <button onclick="editForm(`' . route('kategori.show', $query->id) . '`)" class="btn btn-sm btn-warning"><i class="fas fa-pencil-alt"></i> Edit</button>
                        <button onclick="deleteData(`' . route('kategori.destroy', $query->id) . '`, `' . $query->name . '`)" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                    </div>
                ';
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.kategori.index');
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
        $rules = [
            'name' => 'required|min:1'
        ];

        $message = [
            'name.required' => 'Kategori wajib diisi',
            'name.min' => 'Kategori minimal 1 karakter'
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Gagal disimpan, periksa kembali inputan anda'], 422);
        }

        $data = [
            'name' => trim($request->name),
            'slug' => trim(Str::slug($request->name)),
        ];

        Kategori::create($data);

        return response()->json(['message' => 'Data berhasil disimpan.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori)
    {
        return response()->json(['data' => $kategori]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategori $kategori)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kategori $kategori)
    {
        $rules = [
            'name' => 'required|min:1',
        ];

        $message = [
            'name.required' => 'Kategori wajib diisi',
            'name.min' => 'Kategori minimal 1 karakter'
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Gagal disimpan, periksa kembali inputan anda'], 422);
        }

        $data = [
            'name' => trim($request->name),
            'slug' => trim(Str::slug($request->name)),
        ];

        $kategori->update($data);

        return response()->json(['message' => 'Data berhasil disimpan.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        $kategori->delete();

        return response()->json(['message' => 'Data berhasil dihapus.']);
    }
}
