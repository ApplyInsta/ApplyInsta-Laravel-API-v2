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
        Schema::create('ai_industry_meta', function (Blueprint $table) {
            $table->smallIncrements('id'); // smallint unsigned, auto increment
            $table->string('name', 64);
            $table->string('slug', 80)->nullable();
            $table->text('icon')->nullable();
            $table->unsignedInteger('active_post');
            $table->dateTime('create_date')->useCurrent();
            $table->dateTime('update_date')->useCurrent()->useCurrentOnUpdate();
            $table->boolean('active_flag')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_industry_meta');
    }
};
