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
        Schema::create('leads', function (Blueprint $table) {
            //enquire person detail
            $table->id();
            $table->unsignedBigInteger('source_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            //lead details
            $table->string('description');
            $table->string('product_ids')->nullable();
            $table->tinyInteger('status');
            $table->date('nextCallingDate')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            //user detail

            $table->foreign('user_id')->references('id')->on('users');//who has created the lead in system
            $table->foreign('customer_id')->references('id')->on('customers');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
