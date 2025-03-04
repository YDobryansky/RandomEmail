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
        Schema::create('app_tasks', function (Blueprint $table) {
            $table->id();
            $table->char('name', 255)->default('');
            $table->integer('items_min_per_hour')->default(0);
            $table->integer('items_max_per_hour')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->char('file', 255)->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_tasks');
    }
};
