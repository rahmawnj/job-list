<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_candidate_milestones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_candidate_id')->constrained('job_candidates')->cascadeOnDelete();
            $table->string('step');
            $table->string('status')->default('pending');
            $table->date('date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_candidate_milestones');
    }
};
