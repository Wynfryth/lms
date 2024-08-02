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
        Schema::create('t_classes', function (Blueprint $table) {
            $table->id();
            $table->string('class_code');
            $table->unsignedBigInteger('class_category_id');
            $table->string('class_title');
            $table->string('class_desc');
            $table->date('class_period')->nullable()->default(null);
            $table->unsignedBigInteger('tc_id')->nullable()->default(null);
            $table->unsignedBigInteger('is_active');
            $table->date('start_eff_date')->nullable()->default(null);
            $table->date('end_eff_date')->nullable()->default(null);
            $table->unsignedBigInteger('loc_type_id')->nullable()->default(null);
            $table->unsignedBigInteger('loc_id')->nullable()->default(null);
            $table->string('created_by')->nullable()->default(null);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_classes');
    }
};
