<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('type', ['COGNITIVE', 'DISC', 'SITUATIONAL']);
            $table->text('description')->nullable();
            $table->integer('time_limit_minutes')->nullable();
            $table->json('rubric_config')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('evaluations');
    }
};
