<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // Legacy status fields are no longer part of the job candidate assignment flow.
    }

    public function down(): void
    {
        // Nothing to revert.
    }
};
