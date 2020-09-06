<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Role::insert([
        [
            'role_id'  => '1',
            'role_name' => 'Tata Usaha'
        ],[
            'role_id'  => '2',
            'role_name' => 'Siswa'
        ]
        ]);
    }
}
