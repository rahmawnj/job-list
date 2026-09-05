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
        Schema::create('apply_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->unsigned();
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->text('description');
            $table->string('url')->nullable();
            $table->string('status')->default('pending');
            $table->string('note')->nullable();
            $table->enum('read', [1, 0])->default(0);
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
        Schema::dropIfExists('apply_jobs');
    }
};
