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
        Schema::create('tech_stacks', function (Blueprint $table) {
            $table->id();
            $table->enum('name', ['php', 'laravel'])->default('php');
            $table->enum('status', ['active', 'inactive', 'pending'])->default('inactive');
            // $table->foreign('trainee_id')->references('id')->on('trainees')->onDelete('cascade');
            $table->foreignId('trainee_id')->constrained();
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
        Schema::dropIfExists('tech_stacks');
    }
};
