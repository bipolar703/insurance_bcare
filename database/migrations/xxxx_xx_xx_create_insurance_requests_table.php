Schema::table('insurance_requests', function (Blueprint $table) {
    $table->string('nafath_code', 2)->nullable();
});
