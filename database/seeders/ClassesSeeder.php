<?php

namespace Database\Seeders;

use App\Models\Classes;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
// use Illuminate\Support\Facades\DB;

class ClassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // foreach (range(1, 10) as $index) {
        //     DB::table('t_classes')->insert([
        //         'class_title' => generateCourseName(),
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ]);
        // }
        Classes::factory()->count(10)->create();
    }
}
