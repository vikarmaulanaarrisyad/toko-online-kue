<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{

    public function data(Request $request)
    {
        $query = Produk::latest()->get();

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('satuan', function ($query) {
                return $query->satuan->name;
            })
            ->editColumn('price', function ($query) {
                return format_uang($query->price);
            })
            ->addColumn('aksi', function ($query) {
                return '
                    <div class="btn-group">
                        <button onclick="editForm(`' . route('produk.show', $query->id) . '`)" class="btn btn-sm btn-warning"><i class="fas fa-pencil-alt"></i> Edit</button>
                        <button onclick="deleteData(`' . route('produk.destroy', $query->id) . '`, `' . $query->name . '`)" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
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
        return view('admin.produk.index');
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
            'name' => 'required|min:3',
            'short_description' => 'required',
            'description' => 'required|min:8',
            'unit' => 'required',
            'stock' => 'required|regex:/^[0-9.]+$/',
            'categories' => 'required|array',
            'price' => 'required|regex:/^[0-9.]+$/',
            'product_image' => 'required|mimes:png,jpg,jpeg|max:2048',
        ];

        $message = [
            'name.required' => 'Nama produk wajib diisi.',
            'name.min' => 'Nama produk minimal 3 karakter.',
            'short_description.required' => 'Deskripsi singkat wajib diisi.',
            'description.required' => 'Deskripsi wajib diisi.',
            'description.min' => 'Deskripsi minimal 8 karakter.',
            'unit.required' => 'Satuan wajib diisi.',
            'stock.required' => 'Stock wajib diisi.',
            'categories.required' => 'Kategori wajib diisi.',
            'price.required' => 'Harga produk wajib diisi.',
            'product_image.required' => 'Gambar wajib diisi.',
            'product_image.mimes' => 'File gambar harus jpg,png,jpeg.',
            'product_image.max' => 'File gambar tidak boleh lebih 2MB.',
            'product_image.min' => 'File gambar minimal 200kb.',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Gagal disimpan, periksa kembali inputan anda'], 422);
        }

        $data = [
            'name' => trim($request->name),
            'slug' => trim(Str::slug($request->name)),
            'short_description' => trim($request->short_description),
            'description' => trim($request->description),
            'unit_id' => $request->unit,
            'stock' => $request->stock,
            'price' => str_replace('.', '', $request->price),
            'product_image' =>  upload('products', $request->file('product_image'), 'product'),
        ];

        $products = Produk::create($data);

        $products->categories()->attach($request->categories);

        return response()->json(['message' => 'Data berhasil disimpan.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Produk $produk)
    {
        $produk->categories = $produk->categories;
        $produk->product_image = Storage::url($produk->product_image);
        $produk->price = format_uang($produk->price);
        $produk->unit = $produk->satuan->id;

        return response()->json(['data' => $produk]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|min:3',
            'short_description' => 'required',
            'description' => 'required|min:8',
            'unit' => 'required',
            'stock' => 'required|regex:/^[0-9.]+$/',
            'categories' => 'required|array',
            'price' => 'required|regex:/^[0-9.]+$/',
            'product_image' => 'nullable|mimes:png,jpg,jpeg|max:2048',
        ];

        $message = [
            'name.required' => 'Nama produk wajib diisi.',
            'name.min' => 'Nama produk minimal 3 karakter.',
            'short_description.required' => 'Deskripsi singkat wajib diisi.',
            'description.required' => 'Deskripsi wajib diisi.',
            'description.min' => 'Deskripsi minimal 8 karakter.',
            'unit.required' => 'Satuan wajib diisi.',
            'stock.required' => 'Stock wajib diisi.',
            'categories.required' => 'Kategori wajib diisi.',
            'price.required' => 'Harga produk wajib diisi.',
            'product_image.required' => 'Gambar wajib diisi.',
            'product_image.mimes' => 'File gambar harus jpg,png,jpeg.',
            'product_image.max' => 'File gambar tidak boleh lebih 2MB.',
            'product_image.min' => 'File gambar minimal 200kb.',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Gagal disimpan, periksa kembali inputan anda'], 422);
        }

        $produk = Produk::findOrfail($id);

        $data = $request->except('product_image', 'categories');
        $data['slug'] = trim(Str::slug($request->name));
        $data['unit_id'] = $request->unit;
        $data['price'] = str_replace('.', '', $request->price);

        if ($request->hasFile('product_image')) {
            if (Storage::disk('public')->exists($produk->product_image)) {
                Storage::disk('public')->delete($produk->product_image);
            }

            $data['product_image'] = upload('products', $request->file('product_image'), 'product');
        }

        $produk->update($data);

        $produk->categories()->sync($request->categories);

        return response()->json(['message' => 'Data berhasil disimpan.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        if (Storage::disk('public')->exists($produk->product_image)) {
            Storage::disk('public')->delete($produk->product_image);
        }

        $produk->delete();

        return response()->json(['data' => null, 'message' => 'Data berhasil dihapus']);
    }
}
