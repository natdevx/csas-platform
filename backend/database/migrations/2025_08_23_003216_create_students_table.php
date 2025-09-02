<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id(); // ID autoincrement principal de students
            $table->unsignedBigInteger('user_id'); // relación con users
            $table->enum('gender', ['male', 'female', 'other']);
            $table->integer('age');
            $table->unsignedBigInteger('institute_id');
            $table->unsignedBigInteger('career_id');
            $table->string('enrollment_id', 55);
            $table->unsignedBigInteger('group_id');
            $table->timestamps();

            // Relaciones
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('institute_id')->references('id')->on('institutes')->onDelete('cascade');
            $table->foreign('career_id')->references('id')->on('careers')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
