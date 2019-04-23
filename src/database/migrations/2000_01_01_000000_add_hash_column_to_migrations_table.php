<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHashColumnToMigrationsTable extends Migration
{

    public function up()
    {
      if (!Schema::hasColumn('migrations', 'hash')){
        Schema::table('migrations', function($table) {
          $table->char('hash', 8)->nullable();
        });
      }
    }

    public function down()
    {
      if (Schema::hasColumn('migrations', 'hash')){
        Schema::table('migrations', function($table) {
          $table->dropColumn('hash');
        });
      }
    }
}
