<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypesTable extends Migration
{
    const TABLE_NAME = "activity_types"; // TODO: get it from model i.e (new Type)->getTable()
  /**
   * Run the migrations.
   *
   * @return void
   */
    public function up()
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->integer('id')->unsigned()->primary();
            $table->string('name');
        });
    }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
    public function down()
    {
        Schema::drop(self::TABLE_NAME);
    }
}
