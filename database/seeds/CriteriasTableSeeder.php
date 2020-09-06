<?php

use Illuminate\Database\Seeder;

class CriteriasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Criterias::insert([
        [
            'facilities_id'  => '1',
            'criteria_5' => 'AC tidak dapat menyala atau mati total',
            'criteria_4' => 'AC tidak dingin atau terlalu dingin',
            'criteria_3' => 'AC mengeluarkan suara berisik',
            'criteria_2' => 'AC bocor atau air menetes ke ruangan',
            'criteria_1' => 'Remote AC hilang'
        ],[
            'facilities_id'  => '2',
            'criteria_5' => 'Lampu tidak dapat menyala',
            'criteria_4' => 'Lampu nyala dan mati dengan sendirinya',
            'criteria_3' => 'Nyala lampu meredup',
            'criteria_2' => 'Cahaya lampu berkedip-kedip',
            'criteria_1' => 'Bohlam lampu hilang'
        ],[
            'facilities_id'  => '3',
            'criteria_5' => 'Proyektor mati total',
            'criteria_4' => 'LCD Proyektor redup',
            'criteria_3' => 'VGA input/video input tidak bisa tampil',
            'criteria_2' => 'LCD proyektor berubah warna',
            'criteria_1' => 'Remote proyektor hilang atau tidak berfungsi'
        ],
        [
            'facilities_id'  => '4',
            'criteria_5' => 'AC tidak dapat menyala atau mati total',
            'criteria_4' => 'AC tidak dingin atau terlalu dingin',
            'criteria_3' => 'AC mengeluarkan suara berisik',
            'criteria_2' => 'AC bocor atau air menetes ke ruangan',
            'criteria_1' => 'Remote AC hilang'
        ],[
            'facilities_id'  => '5',
            'criteria_5' => 'Lampu tidak dapat menyala',
            'criteria_4' => 'Lampu nyala dan mati dengan sendirinya',
            'criteria_3' => 'Nyala lampu meredup',
            'criteria_2' => 'Cahaya lampu berkedip-kedip',
            'criteria_1' => 'Bohlam lampu hilang'
        ],[
            'facilities_id'  => '6',
            'criteria_5' => 'Proyektor mati total',
            'criteria_4' => 'LCD Proyektor redup',
            'criteria_3' => 'VGA input/video input tidak bisa tampil',
            'criteria_2' => 'LCD proyektor berubah warna',
            'criteria_1' => 'Remote proyektor hilang atau tidak berfungsi'
        ],
        [
            'facilities_id'  => '7',
            'criteria_5' => 'AC tidak dapat menyala atau mati total',
            'criteria_4' => 'AC tidak dingin atau terlalu dingin',
            'criteria_3' => 'AC mengeluarkan suara berisik',
            'criteria_2' => 'AC bocor atau air menetes ke ruangan',
            'criteria_1' => 'Remote AC hilang'
        ],[
            'facilities_id'  => '8',
            'criteria_5' => 'Lampu tidak dapat menyala',
            'criteria_4' => 'Lampu nyala dan mati dengan sendirinya',
            'criteria_3' => 'Nyala lampu meredup',
            'criteria_2' => 'Cahaya lampu berkedip-kedip',
            'criteria_1' => 'Bohlam lampu hilang'
        ],[
            'facilities_id'  => '9',
            'criteria_5' => 'Proyektor mati total',
            'criteria_4' => 'LCD Proyektor redup',
            'criteria_3' => 'VGA input/video input tidak bisa tampil',
            'criteria_2' => 'LCD proyektor berubah warna',
            'criteria_1' => 'Remote proyektor hilang atau tidak berfungsi'
        ],[
            'facilities_id'  => '10',
            'criteria_5' => 'Komputer mati total',
            'criteria_4' => 'Monitor komputer tidak dapat menyala',
            'criteria_3' => 'Koneksi Internet tidak dapat berfungsi',
            'criteria_2' => 'Keyboard dan atau mouse tidak dapat berfungsi',
            'criteria_1' => 'Microsoft Office tidak dapat berfungsi'
        ]
        ]);
    }
}
