<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddReminderFieldsToActivityTable extends Migration
{
    const TABLE_NAME = "activity_activities"; // TODO: get it from model i.e (new ReminderUnit)->getTable()
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(self::TABLE_NAME, function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->integer('activity_reminder_quantity')->unsigned()->default(0);
            $table->integer('activity_reminder_unity_id')->unsigned()->index()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(self::TABLE_NAME, function (Blueprint $table) {
            $table->removeColumn('title');
            $table->removeColumn('activity_reminder_quantity');
            $table->removeColumn('activity_reminder_unity_id');
        });
    }
}
