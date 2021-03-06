<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserFaculty;
use App\Models\Faculty;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $system_admin_faculty = Faculty::create([
			'faculty_id' => 1234567001,
			'first_name' => "Ferlie Jae",
			'middle_name' => "D",
			'last_name' => "Bautista",
			'gender' => "male",
			'birth_date' => "1999-12-25",
			'contact_number' => "09123456001",
        ]);

        $admin_faculty = Faculty::create([
			'faculty_id' => 1234567890,
			'first_name' => "Apple Rose",
			'middle_name' => "D",
			'last_name' => "Corpuz",
			'gender' => "female",
			'birth_date' => "1999-07-27",
			'contact_number' => "09123456789",
        ]);

        $system_admin_user = User::create([
            'username' => 'master',
            'is_verified' => 1,
            'email' => 'bsfssgmanagement.2417@gmail.com',
            'password' => bcrypt('admin')
        ]);

        $admin_user = User::create([
            'username' => 'admin',
            'is_verified' => 1,
            'email' => 'ar.corpuz00@gmail.com',
            'password' => bcrypt('admin')
        ]);

        $system_admin_user->assignRole(1);
        $admin_user->assignRole(2);

        UserFaculty::create([
            'faculty_id' => $system_admin_faculty->id,
            'user_id' => $system_admin_user->id
        ]);

        UserFaculty::create([
            'faculty_id' => $admin_faculty->id,
            'user_id' => $admin_user->id
        ]);

    }
}
