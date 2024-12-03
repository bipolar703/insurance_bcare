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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('department_id');
            $table->string('name');
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone');
            $table->bigInteger('country_phone_id');
            $table->string('password');
            $table->tinyInteger('status')->comment = "1 => Active || 2 => Inactive";
            $table->bigInteger('employee_type_id');
            $table->longText('image')->nullable();
            $table->tinyInteger('gender')->comment = "1 => Male || 2 => Female";
            $table->tinyInteger('marital_status')->comment = "1 => Single || 2 => Married || 3=>Divorced || 4=>Widow/Widower";
            $table->date('date_of_birth');
            $table->bigInteger('country_id');
            $table->bigInteger('city_id');
            $table->bigInteger('nationality');
            $table->date('date_of_hiring');
            $table->date('date_termination')->nullable();
            $table->longText('address');
            $table->decimal('salary',10,3)->nullable();
            $table->string('work_email')->nullable();
            $table->string('work_phone')->nullable();
            $table->bigInteger('work_country_phone_id')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
