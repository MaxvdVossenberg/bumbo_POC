<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Max van de Vossenberg',
            'department_id' => 1,
            'email' => 'maxvossenberg@gmail.com',
            'phone' => '06 11385321',
            'salary' => 9,
            'password' => bcrypt('dev'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        User::factory()->count(100)->create();
    }
}
