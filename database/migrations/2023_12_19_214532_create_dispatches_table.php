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
        Schema::create('app_dispatches', function (Blueprint $table) {
            $table->id();
            $table->timestamp('send_date');
            $table->tinyInteger('send_status')->default(0);
            $table->unsignedBigInteger('gateway_id');
            $table->unsignedBigInteger('task_id');
            $table->timestamps();
            $table->text('data');
            $table->index(['send_date', 'send_status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_dispatches');
    }
};
