<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToPendingOwnersTable extends Migration
{
    public function up()
    {
        Schema::table('owners', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
        });
        Schema::table('pending_owners', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('owners', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
        Schema::table('pending_owners', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
        });
    }
}
