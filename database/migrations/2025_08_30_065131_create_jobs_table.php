<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employer_id')->constrained('employers')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->unsignedBigInteger('industry_id')->nullable();
            $table->string('location');
            $table->string('salary_range')->nullable();
            $table->enum('job_type', ['full_time', 'part_time', 'contract', 'internship'])->default('full_time');
            $table->enum('status', ['active', 'closed'])->default('active');
            $table->timestamps();
    
            $table->foreign('industry_id')->references('id')->on('ai_industry_meta')->nullOnDelete();
    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
