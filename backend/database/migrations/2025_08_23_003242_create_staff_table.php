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
        Schema::create('staff', function (Blueprint $table) {
            $table->id(); // PK autoincrement
            $table->unsignedBigInteger('user_id'); // Relación con users
            $table->enum('staff_type', ['professor', 'admin']);
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('department', 120)->nullable();
            $table->string('employee_id', 50)->nullable();
            $table->string('academic_rank', 80)->nullable();
            $table->timestamps();

            // Clave foránea
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
