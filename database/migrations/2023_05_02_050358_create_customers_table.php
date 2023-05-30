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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('mobile')->unique();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->integer('pincode')->nullable();
            $table->string('city')->nullable();
            $table->string('location')->nullable();
            $table->string('photo')->nullable();
            $table->string('source')->nullable()->defalut('offline');
            $table->boolean('isDealer')->nullable()->default(0);
            $table->boolean('mobile_verified')->nullable()->default(0);
            $table->boolean('email_verified')->nullable()->default(0);
            $table->string('password')->nullable();
            $table->string('otp')->nullable();
            $table->string('otp_timeout')->nullable();
            $table->dateTime('lastlogin')->nullable();
            $table->string('lastlogin_ip')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
