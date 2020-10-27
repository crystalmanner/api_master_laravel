<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesModifiersTable extends Migration
{
    const TABLE_NAME = "activity_modifiers"; // TODO: get it from model i.e (new Type)->getTable()

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('name');
            $table->string('resource_name');
            $table->string('label');
            $table->string('placeholder');
            $table->string('type')->nullable();
            $table->string('filter')->nullable();
            $table->string('value_param')->nullable();
            $table->string('text_param')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
}