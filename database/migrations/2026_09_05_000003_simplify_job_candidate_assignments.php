<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('job_candidates')) {
            $columns = collect([
                'client_name',
                'step',
                'status',
                'date',
                'notes',
            ])->filter(fn ($column) => Schema::hasColumn('job_candidates', $column))->values()->all();

            if ($columns) {
                Schema::table('job_candidates', function (Blueprint $table) use ($columns) {
                    $table->dropColumn($columns);
                });
            }
        }

        if (Schema::hasTable('job_candidate_milestones')) {
            Schema::drop('job_candidate_milestones');
        }
    }

    public function down(): void
    {
        // Legacy recruitment-process fields are intentionally not restored.
    }
};
