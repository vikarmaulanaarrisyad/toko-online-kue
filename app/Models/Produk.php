<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'products';

    public function categories()
    {
        return $this->belongsToMany(Kategori::class, 'category_product', 'product_id', 'category_id')->withTimestamps();
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'unit_id');
    }
}
