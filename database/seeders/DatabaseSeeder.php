<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Gender;
use App\Models\Department;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Gender::truncate();
        Department::truncate();
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // $gender = Gender::factory(2)->create();
        // Gender
        $male = Gender::create([
            'gender' => 'Male',
        ]);

        $female = Gender::create([
            'gender' => 'Female',
        ]);

        // Department
        $department = Department::factory(8)->create();

        $user_janedoe = User::factory(1)->janeDoe()->create(); // Create one user with janeDoe state
        // dd('JANE DOE', $user_janedoe);
        $user = User::factory(9)->create();
    }
}
