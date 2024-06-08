<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'barang';
    protected $guarded = [];

    public function Transaksi() {
        return $this->hasMany(Transaksi::class, 'barang_id', 'id');
    }

    public function JenisBarang() {
        return $this->belongsTo(JenisBarang::class, 'jenis_id', 'id');
    }
}
