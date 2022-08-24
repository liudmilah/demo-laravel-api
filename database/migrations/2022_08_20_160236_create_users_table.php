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
        Schema::create('users', function (Blueprint $table) {
            $table->string('id', 36);
            $table->primary('id');
            $table->string('status', 10)->nullable(false);
            $table->string('name', 100)->nullable(false);
            $table->string('email', 100)->unique()->nullable(false);
            $table->string('password_hash', 100)->nullable(false);
            $table->timestamp('email_verified_at')->nullable(true);
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
        Schema::dropIfExists('users');
    }
};
