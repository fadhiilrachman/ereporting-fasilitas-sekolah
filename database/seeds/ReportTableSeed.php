<?php

use Illuminate\Database\Seeder;

class ReportTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Report::insert([
            [
                'user_id'  => 2, // 2, 3, 4, 5, 6, 7, 8, 9, 10, 11
                'facilities_id' => 1, // 1, 2, 3, 4, 5, 6, 7, 8, 9, 10
                'criteria_1' => 40, // 1, 10, 40, 50
                'criteria_2' => 1,
                'criteria_3' => 1,
                'criteria_4' => 1,
                'criteria_5' => 1,
                'status' => 'under_review',
                'created_at' => '2020-01-01 12:39:21'
            ],
            [
                'user_id'  => 3, // 2, 3, 4, 5, 6, 7, 8, 9, 10, 11
                'facilities_id' => 2, // 1, 2, 3, 4, 5, 6, 7, 8, 9, 10
                'criteria_1' => 1, // 1, 10, 40, 50
                'criteria_2' => 1,
                'criteria_3' => 10,
                'criteria_4' => 1,
                'criteria_5' => 40,
                'status' => 'under_review',
                'created_at' => '2020-01-02 09:18:19'
            ],
            [
                'user_id'  => 4, // 2, 3, 4, 5, 6, 7, 8, 9, 10, 11
                'facilities_id' => 3, // 1, 2, 3, 4, 5, 6, 7, 8, 9, 10
                'criteria_1' => 1, // 1, 10, 40, 50
                'criteria_2' => 10,
                'criteria_3' => 1,
                'criteria_4' => 50,
                'criteria_5' => 1,
                'status' => 'under_review',
                'created_at' => '2020-01-03 10:20:01'
            ],
            [
                'user_id'  => 5, // 2, 3, 4, 5, 6, 7, 8, 9, 10, 11
                'facilities_id' => 4, // 1, 2, 3, 4, 5, 6, 7, 8, 9, 10
                'criteria_1' => 10, // 1, 10, 40, 50
                'criteria_2' => 1,
                'criteria_3' => 40,
                'criteria_4' => 1,
                'criteria_5' => 10,
                'status' => 'under_review',
                'created_at' => '2020-01-04 13:26:15'
            ],
            [
                'user_id'  => 6, // 2, 3, 4, 5, 6, 7, 8, 9, 10, 11
                'facilities_id' => 5, // 1, 2, 3, 4, 5, 6, 7, 8, 9, 10
                'criteria_1' => 1, // 1, 10, 40, 50
                'criteria_2' => 50,
                'criteria_3' => 40,
                'criteria_4' => 40,
                'criteria_5' => 1,
                'status' => 'under_review',
                'created_at' => '2020-01-01 14:47:55'
            ],
            [
                'user_id'  => 7, // 2, 3, 4, 5, 6, 7, 8, 9, 10, 11
                'facilities_id' => 6, // 1, 2, 3, 4, 5, 6, 7, 8, 9, 10
                'criteria_1' => 1, // 1, 10, 40, 50
                'criteria_2' => 10,
                'criteria_3' => 10,
                'criteria_4' => 1,
                'criteria_5' => 10,
                'status' => 'under_review',
                'created_at' => '2020-01-02 12:19:25'
            ],
            [
                'user_id'  => 8, // 2, 3, 4, 5, 6, 7, 8, 9, 10, 11
                'facilities_id' => 7, // 1, 2, 3, 4, 5, 6, 7, 8, 9, 10
                'criteria_1' => 40, // 1, 10, 40, 50
                'criteria_2' => 50,
                'criteria_3' => 1,
                'criteria_4' => 10,
                'criteria_5' => 1,
                'status' => 'under_review',
                'created_at' => '2020-01-03 11:33:45'
            ],
            [
                'user_id'  => 9, // 2, 3, 4, 5, 6, 7, 8, 9, 10, 11
                'facilities_id' => 8, // 1, 2, 3, 4, 5, 6, 7, 8, 9, 10
                'criteria_1' => 50, // 1, 10, 40, 50
                'criteria_2' => 50,
                'criteria_3' => 10,
                'criteria_4' => 1,
                'criteria_5' => 1,
                'status' => 'under_review',
                'created_at' => '2020-01-04 10:43:09'
            ],
            [
                'user_id'  => 10, // 2, 3, 4, 5, 6, 7, 8, 9, 10, 11
                'facilities_id' => 9, // 1, 2, 3, 4, 5, 6, 7, 8, 9, 10
                'criteria_1' => 1, // 1, 10, 40, 50
                'criteria_2' => 50,
                'criteria_3' => 40,
                'criteria_4' => 10,
                'criteria_5' => 1,
                'status' => 'under_review',
                'created_at' => '2020-01-01 08:56:17'
            ],
            [
                'user_id'  => 11, // 2, 3, 4, 5, 6, 7, 8, 9, 10, 11
                'facilities_id' => 10, // 1, 2, 3, 4, 5, 6, 7, 8, 9, 10
                'criteria_1' => 10, // 1, 10, 40, 50
                'criteria_2' => 40,
                'criteria_3' => 1,
                'criteria_4' => 1,
                'criteria_5' => 50,
                'status' => 'under_review',
                'created_at' => '2020-01-02 09:21:45'
            ],
            ]);
    }
}
