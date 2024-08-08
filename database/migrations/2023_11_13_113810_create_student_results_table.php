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
        Schema::create('student_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Foreign key referencing the users table
               
            // Subjects
            $table->integer('introduction')->default(0);
            $table->integer('windows')->default(0);
            $table->integer('word')->default(0);
            $table->integer('excel')->default(0);
            $table->integer('access')->default(0);
            $table->integer('powerpoint')->default(0);
            $table->integer('publisher')->default(0);
            $table->integer('internet')->default(0);
            $table->timestamps();
            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_results');
    }
};
