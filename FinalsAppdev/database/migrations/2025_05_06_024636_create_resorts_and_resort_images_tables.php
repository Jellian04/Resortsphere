<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Create resorts table
        Schema::create('resorts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('registers_id'); // Reference to registers table
            $table->string('resort_name');
            $table->string('resort_address');
            $table->string('accommodation_type');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();

            $table->foreign('registers_id')->references('id')->on('registers')->onDelete('cascade');
        });

        // Create resort_images table
        Schema::create('resort_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resort_id'); // Reference to resorts table
            $table->string('image_path');
            $table->timestamps();

            $table->foreign('resort_id')->references('id')->on('resorts')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resort_images');
        Schema::dropIfExists('resorts');
    }
};
