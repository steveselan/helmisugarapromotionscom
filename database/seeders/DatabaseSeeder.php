<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Newevent;
use App\Models\Undangan;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call(KategoriSeeder::class);
        $this->call(NeweventSeeder::class);
        $this->call(LiputanSeeder::class);
        $this->call(MasteritemSeeder::class);
        // \App\Models\Liputan::factory(30)->create();
    }
}
