<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_b', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('star_count')->default(0);
            $table->unsignedInteger('table_a_id');
            $table->foreign('table_a_id')->references('id')->on('table_a');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_b');
    }
};
