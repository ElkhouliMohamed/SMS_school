<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('class_teacher', function (Blueprint $table) {
            $table->foreignId('class_id')->constrained('school_classes')->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade');
            $table->primary(['class_id', 'teacher_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_teacher');
    }
};
