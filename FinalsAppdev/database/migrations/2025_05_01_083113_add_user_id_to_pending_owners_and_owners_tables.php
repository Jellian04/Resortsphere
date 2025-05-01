<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToPendingOwnersAndOwnersTables extends Migration
{
    public function up()
    {
        // Add user_id column to the owners table (pending_owners already has it)
        Schema::table('owners', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
        });
    }
    
    public function down()
    {
        // Drop user_id column from the owners table (pending_owners already has it)
        Schema::table('owners', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
}
