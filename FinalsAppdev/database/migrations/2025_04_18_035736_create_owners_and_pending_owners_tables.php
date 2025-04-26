<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('owners', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('password')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('resortname')->nullable();
            $table->string('resorts_address')->nullable();;
            $table->string('type_of_accommodation')->nullable();
            $table->text('description')->nullable();
            $table->string('resort_img')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });

        Schema::create('pending_owners', function (Blueprint $table) {
            $table->id();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('password')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('resortname')->nullable();
            $table->string('resorts_address')->nullable();
            $table->string('type_of_accommodation')->nullable();
            $table->text('description')->nullable();
            $table->string('resort_img')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('owners');
        Schema::dropIfExists('pending_owners');
    }

};
