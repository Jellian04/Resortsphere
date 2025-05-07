<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescriptionToResortsTable extends Migration
{
    public function up()
    {
        Schema::table('resorts', function (Blueprint $table) {
            $table->text('description')->nullable(); // Adds a nullable description column
        });
    }

    public function down()
    {
        Schema::table('resorts', function (Blueprint $table) {
            $table->dropColumn('description'); // Rollback this column if necessary
        });
    }
}