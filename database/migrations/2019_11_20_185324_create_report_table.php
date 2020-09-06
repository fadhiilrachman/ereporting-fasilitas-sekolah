<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('report_id');
            $table->integer('user_id')->unsigned();
            $table->integer('facilities_id')->unsigned();
            $table->integer('criteria_1');
            $table->integer('criteria_2');
            $table->integer('criteria_3');
            $table->integer('criteria_4');
            $table->integer('criteria_5');
            $table->enum('status', ['under_review', 'accepted', 'rejected']);
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('user_id')
                ->references('user_id')
                ->on('users');
            $table->foreign('facilities_id')
                ->references('facilities_id')
                ->on('facilities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
