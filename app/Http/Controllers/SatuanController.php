<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SatuanController extends Controller
{
    public function data(Request $request)
    {
        $query = Satuan::latest()->get();

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('aksi', function ($query) {
                return '
                    <div class="btn-group">
                        <button onclick="editForm(`' . route('satuan.show', $query->id) . '`)" class="btn btn-sm btn-warning"><i class="fas fa-pencil-alt"></i> Edit</button>
                        <button onclick="deleteData(`' . route('satuan.destroy', $query->id) . '`, `' . $query->name . '`)" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
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
        return view('admin.satuan.index');
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
            'name' => 'required',
        ];

        $message = [
            'name.required' => 'Satuan wajib diisi.'
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Gagal disimpan, periksa kembali inputan anda'], 422);
        }

        $data = [
            'name' => trim($request->name),
            'slug' => trim(Str::slug($request->name)),
        ];

        Satuan::create($data);

        return response()->json(['message' => 'Data berhasil disimpan.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Satuan $satuan)
    {
        return response()->json(['data' => $satuan]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Satuan $satuan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Satuan $satuan)
    {
        $rules = [
            'name' => 'required',
        ];

        $message = [
            'name.required' => 'Satuan wajib diisi.'
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Gagal disimpan, periksa kembali inputan anda'], 422);
        }

        $data = [
            'name' => trim($request->name),
            'slug' => trim(Str::slug($request->name)),
        ];

        $satuan->update($data);

        return response()->json(['message' => 'Data berhasil disimpan.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Satuan $satuan)
    {
        $satuan->delete();

        return response()->json(['message' => 'Data berhasil dihapus.']);
    }

    public function ajaxSearch(Request $request)
    {
        $keyword = $request->get('q');

        $result = Satuan::where("name", "LIKE", "%$keyword%")->get();

        return $result;
    }
}
