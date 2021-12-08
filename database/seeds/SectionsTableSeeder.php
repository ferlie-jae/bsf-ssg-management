<?php

use Illuminate\Database\Seeder;
use App\Models\Configuration\Section;

class SectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Section::insert([
            ['grade_level' => '7', 'name' => 'Section A'],
            ['grade_level' => '7', 'name' => 'Section B'],
            ['grade_level' => '7', 'name' => 'Section C'],
            ['grade_level' => '8', 'name' => 'Section A'],
            ['grade_level' => '8', 'name' => 'Section B'],
            ['grade_level' => '8', 'name' => 'Section C'],
            ['grade_level' => '9', 'name' => 'Section A'],
            ['grade_level' => '9', 'name' => 'Section B'],
            ['grade_level' => '9', 'name' => 'Section C'],
            ['grade_level' => '10', 'name' => 'Section A'],
            ['grade_level' => '10', 'name' => 'Section B'],
            ['grade_level' => '10', 'name' => 'Section C'],
            ['grade_level' => '11', 'name' => 'ICT A'],
            ['grade_level' => '11', 'name' => 'ICT B'],
            ['grade_level' => '11', 'name' => 'STEM A'],
            ['grade_level' => '11', 'name' => 'STEM B'],
            ['grade_level' => '12', 'name' => 'ICT A'],
            ['grade_level' => '12', 'name' => 'ICT B'],
            ['grade_level' => '12', 'name' => 'STEM A'],
            ['grade_level' => '12', 'name' => 'STEM B'],
        ]);
    }
}
