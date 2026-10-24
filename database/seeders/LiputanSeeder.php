<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LiputanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_liputan')->insert([
            [
                'nama' => 'Yesna Steven',
                'email' => 'steve.selan@gmail.com',
                'phone' => '081380548093',
                'media' => 'hsp.com',
                'jabatan' => 'Jurnalis',
                'jenis_undangan' => 'PC',
                'undangan_id' => 1
            ],
            [
                'nama' => 'Helmi Sugara',
                'email' => 'helmisugara@gmail.com',
                'phone' => '081219194393',
                'media' => 'hsp.com',
                'jabatan' => 'Photographer',
                'jenis_undangan' => 'PC',
                'undangan_id' => 1
            ],
            [
                'nama' => 'Dodet',
                'email' => 'didoet@gmail.com',
                'phone' => '081219194393',
                'media' => 'hsp.com',
                'jabatan' => 'Photographer',
                'jenis_undangan' => 'PC',
                'undangan_id' => 1
            ],
            [
                'nama' => 'Noppiyah',
                'email' => 'noppi@gmail.com',
                'phone' => '081219194393',
                'media' => 'hsp.com',
                'jabatan' => 'Photographer',
                'jenis_undangan' => 'PC',
                'undangan_id' => 1
            ],
            [
                'nama' => 'Martha Serepina',
                'email' => 'martha@gmail.com',
                'phone' => '081219194393',
                'media' => 'hsp.com',
                'jabatan' => 'Photographer',
                'jenis_undangan' => 'PC',
                'undangan_id' => 1
            ]
        ]);
    }
}
