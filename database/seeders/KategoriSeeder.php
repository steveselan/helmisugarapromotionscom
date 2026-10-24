<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
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
    }
}
