<?php

use Illuminate\Database\Seeder;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Rooms::insert([[
            'room_id'  => '1',
            'room_name' => 'Kelas IPA-1'
        ],[
            'room_id'  => '2',
            'room_name' => 'Kelas IPS-1'
        ],[
            'room_id'  => '3',
            'room_name' => 'Laboratorium Komputer'
        ]]);
    }
}
