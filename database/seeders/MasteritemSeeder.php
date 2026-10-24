<?php

namespace Database\Seeders;

use App\Models\Materitem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasteritemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
                $pilihan_items = [
                        ['nama_item' => 'IG Feed'],
                        ['nama_item' => 'IG Story'],
                        ['nama_item' => 'IG Reel'],
                        ['nama_item' => 'FB Feed'],
                        ['nama_item' => 'FB Story'],
                        ['nama_item' => 'FB Reel'],
                        ['nama_item' => 'X / Twitter'],
                        ['nama_item' => 'Tik Tok'],
                        ['nama_item' => 'Radio Spot - ROS'],
                        ['nama_item' => 'Radio Spot - PT'],
                        ['nama_item' => 'Radio Spot - RT'],
                        ['nama_item' => 'Web Banner'],
                        ['nama_item' => 'Online Artikel'],
                        ['nama_item' => 'Print Artikel'],
                        ['nama_item' => 'Print Ads'],
                    ];

                    foreach ($pilihan_items as $item) {
                        Materitem::create($item);
                    }
    }
}
