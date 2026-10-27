<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->foreignId('vacancy_id')->nullable()->after('applied_position')->constrained('vacancies')->nullOnDelete();
            $table->text('hiring_notes')->nullable()->after('hiring_stage');
            $table->timestamp('interview_scheduled_at')->nullable()->after('hiring_notes');
            $table->timestamp('hired_at')->nullable()->after('interview_scheduled_at');
        });
    }

    public function down(): void
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->dropForeign(['vacancy_id']);
            $table->dropColumn([
                'vacancy_id',
                'hiring_notes',
                'interview_scheduled_at',
                'hired_at',
            ]);
        });
    }
};
