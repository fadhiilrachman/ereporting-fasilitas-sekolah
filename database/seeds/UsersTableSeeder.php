<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::insert([
        [
            'role_id'  => '1',
            'name'  => 'Fadhiil Rachman',
            'email' => 'tatausaha@gmail.com',
            'password'  => bcrypt('tu1234')
        ],[
            'role_id'  => '2',
            'name'  => 'Devicka Karina',
            'email' => 'siswa1@gmail.com',
            'password'  => bcrypt('siswa123')
        ],[
            'role_id'  => '2',
            'name'  => 'Nathasya Dyarini',
            'email' => 'siswa2@gmail.com',
            'password'  => bcrypt('siswa123')
        ],[
            'role_id'  => '2',
            'name'  => 'Selfita Rarahayu Chandra',
            'email' => 'siswa3@gmail.com',
            'password'  => bcrypt('siswa123')
        ],[
            'role_id'  => '2',
            'name'  => 'Nabilah Valerie Hartanto',
            'email' => 'siswa4@gmail.com',
            'password'  => bcrypt('siswa123')
        ],[
            'role_id'  => '2',
            'name'  => 'Afrida Aprisilia',
            'email' => 'siswa5@gmail.com',
            'password'  => bcrypt('siswa123')
        ],[
            'role_id'  => '2',
            'name'  => 'Hizrian Setya',
            'email' => 'siswa6@gmail.com',
            'password'  => bcrypt('siswa123')
        ],[
            'role_id'  => '2',
            'name'  => 'Aliriza Muhamad Pemana',
            'email' => 'siswa7@gmail.com',
            'password'  => bcrypt('siswa123')
        ],[
            'role_id'  => '2',
            'name'  => 'Andhika Purwanto',
            'email' => 'siswa8@gmail.com',
            'password'  => bcrypt('siswa123')
        ],[
            'role_id'  => '2',
            'name'  => 'Amar Satrya Kurniansyah',
            'email' => 'siswa9@gmail.com',
            'password'  => bcrypt('siswa123')
        ],[
            'role_id'  => '2',
            'name'  => 'Miftachul Aliriza Azhari',
            'email' => 'siswa10@gmail.com',
            'password'  => bcrypt('siswa123')
        ]
        ]);
    }
}
