<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHashColumnToMigrationsTable extends Migration
{

    public function up()
    {
      Schema::table('migrations', function($table) {
        $table->char('hash', 8)->nullable();
      });
    }

    public function down()
    {
      Schema::table('migrations', function($table) {
        $table->dropColumn('hash');
      });
    }
}
