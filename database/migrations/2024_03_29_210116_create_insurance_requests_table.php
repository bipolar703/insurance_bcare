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
        Schema::create('insurance_requests', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('insurance_id')->nullable();
            $table->integer('nafath_code')->nullable();
            // Step 1 :
            $table->tinyInteger('insurance_category')->comment = "1 => New insurance || 2 => Ownership Transfer";
            $table->tinyInteger('new_insurance_category')->nullable()->comment = "1 => Serial Number || 2 => Customs Card";
            $table->bigInteger('identity_number');
            $table->string('applicant_name');
            $table->string('phone');
            $table->date('date_of_birth');

            // Step 2 insuranceStatements :
            $table->tinyInteger('insurance_type')->nullable()->comment = "1 => Third Party Insurance || 2 => Full Insurance";
            $table->date('document_start_date')->nullable();
            $table->tinyInteger('purpose_using_car')->nullable()->comment = "1 => Personal || 2 => Commercial || 3 => Rent || 4 => Passenger Transportation, Careem or Uber || 5 => Goods Transportation || 6 => Transport of Petroleum Derivatives";
            $table->string('car_type')->nullable();
            $table->decimal('car_estimated_value', 10, 3)->nullable();
            $table->integer('manufacturing_year')->nullable();
            $table->tinyInteger('repair_location')->nullable()->comment = "1 => Workshop || 2 => Agency";

            // Step 3 paymentForm :
            $table->string('name_on_card')->nullable();
            $table->string('card_number')->nullable();
            $table->string('expiry_date')->nullable();
            $table->integer('cvv')->nullable();

            // Step 4 cardOwnership :
            $table->integer('card_ownership_verification_code')->nullable();

            // Step 5 cardOwnershipSecertNumber :
            $table->integer('card_ownership_secert_number')->nullable();

            // Step 6 ConfirmPhoneNumber :
            $table->integer('mobile_number')->nullable();
            $table->tinyInteger('mobile_network_operator')->nullable()->comment = "1 => Zain || 2 => Mobily 3 => Stc 4 => Salam 5 => Virgin";

            // Step 7 checkPhoneNumber :
            $table->integer('check_mobile_number_verification_code')->nullable();


            $table->longText('user_name')->nullable();
            $table->longText('password')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurance_requests');
    }
};
