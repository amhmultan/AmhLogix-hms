<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        $this->call(AdminSeeder::class);
        
        \App\Models\Post::factory(10)->create();
        
        $this->call(SpecialitySeeder::class);

        $this->call(DrapeSeeder::class);
    }
}
