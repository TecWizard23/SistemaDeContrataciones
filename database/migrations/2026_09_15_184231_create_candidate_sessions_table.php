<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('candidate_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_id')->constrained('candidates')->onDelete('cascade');
            $table->foreignId('evaluation_id')->constrained('evaluations')->onDelete('cascade');
            $table->enum('status', ['PENDING', 'IN_PROGRESS', 'COMPLETED', 'EXPIRED'])->default('PENDING');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->decimal('raw_score', 8, 2)->nullable();
            $table->decimal('fit_percentage', 5, 2)->nullable();
            $table->json('metrics_summary')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('candidate_sessions');
    }
};
