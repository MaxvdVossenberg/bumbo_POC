<?php

namespace Database\Seeders;

use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::create([
            'title' => 'Kassa',
            'color' => '#9a3bbf',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        Department::create([
            'title' => 'Groente',
            'color' => '#3cb55c',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        Department::create([
            'title' => 'Brood',
            'color' => '#c4ad27',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        Department::create([
            'title' => 'Vulploeg',
            'color' => '#c92e2e',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
