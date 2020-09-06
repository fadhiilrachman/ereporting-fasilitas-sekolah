<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCriteriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('criterias', function (Blueprint $table) {
            $table->increments('criteria_id');
            $table->integer('facilities_id')->unsigned();
            $table->string('criteria_1');
            $table->string('criteria_2');
            $table->string('criteria_3');
            $table->string('criteria_4');
            $table->string('criteria_5');

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
        Schema::dropIfExists('criterias');
    }
}
