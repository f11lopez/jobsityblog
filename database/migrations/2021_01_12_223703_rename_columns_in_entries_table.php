<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnsInEntriesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
  */
  public function up()
  {
    Schema::table('entries', function (Blueprint $table) {
      $table->renameColumn('content', 'body');
    });
  }
    
  /**
   * Reverse the migrations.
   *
   * @return void
  */
  public function down()
  {
    Schema::table('entries', function (Blueprint $table) {
      $table->renameColumn('body', 'content');
    });
  }
  
} //class