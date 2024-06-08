<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransaksiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('transaksi')->insert([
            [
                'barang_id' => 1,
                'stok' => 100,
                'jumlah_terjual' => 10,
                'tanggal_transaksi' => Carbon::create(2021, 5, 1),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'barang_id' => 2,
                'stok' => 100,
                'jumlah_terjual' => 19,
                'tanggal_transaksi' => Carbon::create(2021, 5, 5),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'barang_id' => 1,
                'stok' => 90,
                'jumlah_terjual' => 15,
                'tanggal_transaksi' => Carbon::create(2021, 5, 10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'barang_id' => 3,
                'stok' => 100,
                'jumlah_terjual' => 20,
                'tanggal_transaksi' => Carbon::create(2021, 5, 11),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'barang_id' => 4,
                'stok' => 100,
                'jumlah_terjual' => 30,
                'tanggal_transaksi' => Carbon::create(2021, 5, 11),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'barang_id' => 5,
                'stok' => 100,
                'jumlah_terjual' => 30,
                'tanggal_transaksi' => Carbon::create(2021, 5, 12),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'barang_id' => 2,
                'stok' => 81,
                'jumlah_terjual' => 5,
                'tanggal_transaksi' => Carbon::create(2021, 5, 12),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
