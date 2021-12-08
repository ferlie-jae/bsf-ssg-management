<?php

use Illuminate\Database\Seeder;
use App\Models\Partylist;

class PartylistsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Partylist::insert([
            ['name' => 'Andromeda', 'color' => '#dc3545'],
            ['name' => 'Magellanic', 'color' => '#28a745'],
            ['name' => 'Milky Way', 'color' => '#007bff'],
        ]);
    }
}
