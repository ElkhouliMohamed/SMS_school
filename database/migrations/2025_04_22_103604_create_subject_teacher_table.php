<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('subject_teacher', function (Blueprint $table) {
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade');
            $table->primary(['subject_id', 'teacher_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subject_teacher');
    }
};
