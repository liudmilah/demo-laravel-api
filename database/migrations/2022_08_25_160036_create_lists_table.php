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
        Schema::create('lists', function (Blueprint $table) {
            $table->string('id', 36);
            $table->primary('id');
            $table->string('name', 100)->nullable(false);
            $table->unsignedTinyInteger('sequence')->nullable(false);
            $table->string('board_id', 36)->nullable(false);
            $table->foreign('board_id')->references('id')->on('boards')->onDelete('CASCADE');
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
        Schema::dropIfExists('lists');
    }
};
