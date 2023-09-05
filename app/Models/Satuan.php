<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Satuan extends Model
{
    use HasFactory;

    protected $table = 'units';

    public function user()
    {
        return $this->hasOne(Produk::class, 'unit_id', 'id');
    }
}
