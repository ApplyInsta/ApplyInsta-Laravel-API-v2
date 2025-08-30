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
        Schema::create('employers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('company_name');
            $table->string('company_website')->nullable();
            $table->string('company_logo')->nullable();
            $table->unsignedBigInteger('industry_id')->nullable();
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->timestamps();
    
            $table->foreign('industry_id')->references('id')->on('ai_industry_meta')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employers');
    }
};
