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
        Schema::create('cards', function (Blueprint $table) {
            $table->string('id', 36);
            $table->primary('id');
            $table->string('name', 100)->nullable(false);
            $table->unsignedSmallInteger('sequence')->nullable(false);
            $table->text('description')->nullable(true);
            $table->string('list_id', 36)->nullable(false);
            $table->foreign('list_id')->references('id')->on('lists')->onDelete('CASCADE');
            $table->string('label_id', 36)->nullable(true);
            $table->foreign('label_id')->references('id')->on('labels')->onDelete('CASCADE');
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
        Schema::dropIfExists('cards');
    }
};
