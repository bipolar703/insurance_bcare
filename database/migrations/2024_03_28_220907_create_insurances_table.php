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
        Schema::create('insurances', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('insurance_type')->comment = "الأول (1) => ضد الغير || الثاني (2) => شامل";
            $table->longText('image');
            $table->decimal('price', 10, 3);
            $table->tinyInteger('status')->comment = "1 => Active || 2 => Inactive";
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurances');
    }
};
