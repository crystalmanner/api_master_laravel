<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSavedSearchesModifiersTable extends Migration
{
    const TABLE_NAME = "activity_saved_searches_modifiers"; // TODO: get it from model i.e (new Type)->getTable()

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('saved_search_uuid');
            $table->uuid('modifier_uuid');
            $table->unique(['saved_search_uuid', 'modifier_uuid'], 'unique');
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