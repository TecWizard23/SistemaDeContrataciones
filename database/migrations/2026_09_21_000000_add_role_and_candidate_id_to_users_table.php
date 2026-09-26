<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['HR', 'CANDIDATE'])->default('CANDIDATE')->after('email');
            $table->foreignId('candidate_id')->nullable()->after('role')->constrained('candidates')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['candidate_id']);
            $table->dropColumn(['role', 'candidate_id']);
        });
    }
};
