<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        DB::table('tb_kategori')->insert([
            [
                'nama_kategori' => 'Music Concert',
                'deskripsi' => 'Music Concert'
            ],
            [
                'nama_kategori' => 'Music Festival',
                'deskripsi' => 'Music Festival'
            ],
            [
                'nama_kategori' => 'Music & Exhibition',
                'deskripsi' => 'Music & Exhibition'
            ],
            [
                'nama_kategori' => 'Lifestyle & Exhibition',
                'deskripsi' => 'Lifestyle & Exhibition'
            ],
            [
                'nama_kategori' => 'Sport Event',
                'deskripsi' => 'Sport Event'
            ],
            [
                'nama_kategori' => 'Traditional & Culture Event',
                'deskripsi' => 'Traditional & Culture Event'
            ],
            [
                'nama_kategori' => 'Family Entertainment',
                'deskripsi' => 'Family Entertainment'
            ]
        ]);

        // query untuk menabah data
        DB::table('tb_produk')->insert([
            [
            'kode_produk' => 'A001',
            'nama_produk' => 'Smart TV Samsung 24 Inch',
            'harga' => 15000000,
            'deskripsi_produk' => 'Ini adalah sebuah deskripsi dummy',
            'kategori_id' => '1',
            'stok'=>100,
            'created_at' =>now()
        ],[
            'kode_produk' => 'A002',
            'nama_produk' => 'Charger Aplle',
            'harga' => 2000000,
            'deskripsi_produk' => 'Ini adalah sebuah deskripsi dummy',
            'kategori_id' => '1',
            'stok'=>50,
            'created_at' =>now()
        ],[
            'kode_produk' => 'A003',
            'nama_produk' => 'Sapu Ijuk',
            'harga' => 600000,
            'deskripsi_produk' => 'Ini adalah sebuah deskripsi dummy',
            'kategori_id' => '2',
            'stok'=>50,
            'created_at' =>now()
        ]
        ]);
    }
}
