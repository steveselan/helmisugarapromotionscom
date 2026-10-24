<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NeweventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_newevent')->insert([
            [
                'judul_event' => '30 Tahun Berkarya - UNGU - Waktu Yang Dinanti - Final Chapter',
                'artis' => 'UNGU',
                'lokasi' => 'Tennis Indoor Senayan, Jakarta',
                'tanggal' => '2026-10-30',
                'link_tiket' => 'tiptip.com',
                'promotor' => 'TipTip',
                'status' => 'New',
            ],[
                'judul_event' => 'KAHITNA 40 TAHUN',
                'artis' => 'Kahitna',
                'lokasi' => 'Hall A, NICE, PIK 2',
                'tanggal' => '2026-09-05',
                'link_tiket' => 'guehadir.id',
                'promotor' => 'Enjoy Live Experience',
                'status' => 'New'
            ],[
                'judul_event' => 'Fia Rallycross World Cup Indonesia 2026',
                'artis' => 'FIA',
                'lokasi' => 'International E-PRIX Circuit Ancol Jakarta',
                'tanggal' => '2026-12-05',
                'link_tiket' => 'loket.com',
                'promotor' => 'Sarga Motor Sport',
                'status' => 'New'
            ],[
                'judul_event' => 'Westlive 25 The Anniversary World Tour',
                'artis' => 'Westlife',
                'lokasi' => 'Gelora Bung Karno Stadium',
                'tanggal' => '2027-01-27',
                'link_tiket' => 'loket.com',
                'promotor' => 'Folagopro & SoundRhythm',
                'status' => 'New',
            ]
        ]);
    }
}
