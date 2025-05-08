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
        Schema::create('event_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['registered', 'confirmed', 'cancelled', 'attended'])->default('registered');
            $table->boolean('payment_required')->default(false);
            $table->boolean('payment_completed')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();

            // Ensure a student can only register once for an event
            $table->unique(['event_id', 'student_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_registrations');
    }
};
