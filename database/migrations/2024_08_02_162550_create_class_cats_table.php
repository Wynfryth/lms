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
        Schema::create('tm_class_category', function (Blueprint $table) {
            $table->id();
            $table->string('class_category')->nullable()->default(null);
            $table->string('desc')->nullable()->default(null);
            $table->unsignedBigInteger('is_active')->default(1);
            $table->string('created_by')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tm_class_category');
    }
};
