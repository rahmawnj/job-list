<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jobcategory_id')->unsigned();
            $table->foreignId('company_id')->unsigned();
            $table->foreignId('location_id')->unsigned();
            $table->string('title');
            $table->string('image')->nullable();
            $table->text('skills')->nullable();
            $table->string('total_position')->nullable();
            $table->string('status');
            $table->string('type')->nullable();
            $table->text('experience')->nullable();
            $table->string('salary')->nullable();
            $table->text('description')->nullable();
            $table->text('requirement')->nullable();
            $table->date('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
};
