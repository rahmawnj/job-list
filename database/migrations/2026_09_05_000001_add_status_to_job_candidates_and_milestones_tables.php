<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('job_candidates') && !Schema::hasColumn('job_candidates', 'status')) {
            Schema::table('job_candidates', function (Blueprint $table) {
                $table->string('status')->default('pending')->after('step');
            });
        }

        if (Schema::hasTable('job_candidate_milestones') && !Schema::hasColumn('job_candidate_milestones', 'status')) {
            Schema::table('job_candidate_milestones', function (Blueprint $table) {
                $table->string('status')->default('pending')->after('step');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('job_candidates') && Schema::hasColumn('job_candidates', 'status')) {
            Schema::table('job_candidates', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }

        if (Schema::hasTable('job_candidate_milestones') && Schema::hasColumn('job_candidate_milestones', 'status')) {
            Schema::table('job_candidate_milestones', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
};
