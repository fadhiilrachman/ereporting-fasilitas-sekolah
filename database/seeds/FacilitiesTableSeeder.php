<?php

use Illuminate\Database\Seeder;

class FacilitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Facilities::insert([
        [
            'facilities_id'  => '1',
            'room_id'  => '1',
            'facilities_name' => 'Air Conditioner (AC)'
        ],[
            'facilities_id'  => '2',
            'room_id'  => '1',
            'facilities_name' => 'Lampu'
        ],[
            'facilities_id'  => '3',
            'room_id'  => '1',
            'facilities_name' => 'Proyektor'
        ],
        [
            'facilities_id'  => '4',
            'room_id'  => '2',
            'facilities_name' => 'Air Conditioner (AC)'
        ],[
            'facilities_id'  => '5',
            'room_id'  => '2',
            'facilities_name' => 'Lampu'
        ],[
            'facilities_id'  => '6',
            'room_id'  => '2',
            'facilities_name' => 'Proyektor'
        ],
        [
            'facilities_id'  => '7',
            'room_id'  => '3',
            'facilities_name' => 'Air Conditioner (AC)'
        ],[
            'facilities_id'  => '8',
            'room_id'  => '3',
            'facilities_name' => 'Lampu'
        ],[
            'facilities_id'  => '9',
            'room_id'  => '3',
            'facilities_name' => 'Proyektor'
        ],[
            'facilities_id'  => '10',
            'room_id'  => '3',
            'facilities_name' => 'Komputer'
        ]
        ]);
    }
}
