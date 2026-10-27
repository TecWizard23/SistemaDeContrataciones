<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vacancies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('department');
            $table->string('location')->default('La Paz');
            $table->string('contract_type')->default('Tiempo Completo');
            $table->integer('openings_count')->default(1);
            $table->string('status')->default('OPEN'); // OPEN, IN_REVIEW, CLOSED
            $table->string('salary_range')->nullable();
            $table->text('description')->nullable();
            $table->text('requirements')->nullable();
            $table->date('closing_date')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::table('candidates', function (Blueprint $table) {
            $table->string('city')->nullable()->after('phone');
            $table->text('summary')->nullable()->after('city');
            $table->integer('experience_years')->default(0)->after('summary');
            $table->string('education_level')->nullable()->after('experience_years');
            $table->string('linkedin_url')->nullable()->after('education_level');
            $table->string('hiring_stage')->default('ASSESSMENT')->after('applied_position'); // APPLIED, ASSESSMENT, INTERVIEW, SELECTED, REJECTED
        });
    }

    public function down(): void
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->dropColumn([
                'city',
                'summary',
                'experience_years',
                'education_level',
                'linkedin_url',
                'hiring_stage',
            ]);
        });

        Schema::dropIfExists('vacancies');
    }
};
