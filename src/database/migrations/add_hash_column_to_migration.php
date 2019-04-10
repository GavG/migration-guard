<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHashColumnToMigration extends Migration
{

    public function up()
    {
      Schema::table('migrations', function($table) {
        $table->string('hash')->nullable();
      });
    }

    public function down()
    {
      Schema::table('migrations', function($table) {
        $table->dropColumn('hash');
      });
    }
}
