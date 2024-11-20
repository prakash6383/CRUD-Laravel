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
        Schema::create('trainees', function (Blueprint $table) {
            $table->id();
            $table->string("firstName", 255);
            $table->string("lastName", 255);
            $table->string("email", 255)->unique();
            $table->string("is_verified")->default(false);
            $table->string("phone", 255)->unique();
            $table->string('password')->nullable();
            $table->enum('role', ['guest', 'manager', 'admin'])->nullable();
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
        Schema::dropIfExists('trainees');
    }
};
