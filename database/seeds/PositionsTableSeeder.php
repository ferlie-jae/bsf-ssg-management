<?php

use Illuminate\Database\Seeder;
use App\Models\Configuration\Position;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Position::insert([
            ['name' => 'Chairman', 'candidate_to_elect' => 1],
            ['name' => 'Vice-Chairman', 'candidate_to_elect' => 1],
            ['name' => 'Treasurer', 'candidate_to_elect' => 1],
            ['name' => 'Secretary', 'candidate_to_elect' => 1],
            ['name' => 'Auditor', 'candidate_to_elect' => 1],
            ['name' => 'PIO', 'candidate_to_elect' => 2],
            ['name' => 'Peace Officer', 'candidate_to_elect' => 2],
            /* ['name' => 'Grade 7 Representative', 'candidate_to_elect' => 1],
            ['name' => 'Grade 8 Representative', 'candidate_to_elect' => 1],
            ['name' => 'Grade 9 Representative', 'candidate_to_elect' => 1],
            ['name' => 'Grade 10 Representative', 'candidate_to_elect' => 1],
            ['name' => 'Grade 11 Representative', 'candidate_to_elect' => 1],
            ['name' => 'Grade 12 Representative', 'candidate_to_elect' => 1] */
        ]);
    }
}
