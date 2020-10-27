<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddDaysFieldsToActivityTable extends Migration
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
            $table->integer('has_activity_reminder')->unsigned()->default(0);
            $table->integer('days')->default(0);
            $table->string('deals_deal_uuid')->nullable();
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
            $table->dropColumn(['has_activity_reminder', 'deals_deal_uuid', 'days']);
        });
    }
}
