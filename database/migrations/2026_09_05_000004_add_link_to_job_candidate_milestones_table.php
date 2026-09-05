<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('job_candidate_milestones') && !Schema::hasColumn('job_candidate_milestones', 'link')) {
            Schema::table('job_candidate_milestones', function (Blueprint $table) {
                $table->string('link')->nullable()->after('notes');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('job_candidate_milestones') && Schema::hasColumn('job_candidate_milestones', 'link')) {
            Schema::table('job_candidate_milestones', function (Blueprint $table) {
                $table->dropColumn('link');
            });
        }
    }
};
