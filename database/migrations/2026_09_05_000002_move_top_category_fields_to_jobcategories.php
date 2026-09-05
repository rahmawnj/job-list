<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('jobcategories', 'is_top_category')) {
            Schema::table('jobcategories', function (Blueprint $table) {
                $table->boolean('is_top_category')->default(false);
            });
        }

        if (!Schema::hasColumn('jobcategories', 'logo')) {
            Schema::table('jobcategories', function (Blueprint $table) {
                $table->string('logo')->nullable();
            });
        }

        Schema::dropIfExists('topcategories');
    }

    public function down(): void
    {
        Schema::table('jobcategories', function (Blueprint $table) {
            $table->dropColumn(['is_top_category', 'logo']);
        });
    }
};