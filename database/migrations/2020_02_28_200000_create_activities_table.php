<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    const TABLE_NAME = "activity_activities"; // TODO: get it from model i.e (new Activity)->getTable()

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->dateTime('scheduled_at');
            $table->integer('status_id')->unsigned();
            $table->integer('type_id')->unsigned()->index();
            $table->string('customer_uuid');
            $table->string('salesrep_uuid');
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
        Schema::drop(self::TABLE_NAME);
    }
}
