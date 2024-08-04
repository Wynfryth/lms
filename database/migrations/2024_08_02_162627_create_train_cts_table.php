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
        Schema::create('tm_training_center', function (Blueprint $table) {
            $table->id();
            $table->string('tc_name')->nullable()->default(null);
            $table->string('tc_address')->nullable()->default(null);
            $table->string('note')->nullable()->default(null);
            $table->string('created_by')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tm_training_center');
    }
};
