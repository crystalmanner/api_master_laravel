<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveForeignKeysFromActivitiesTable extends Migration
{
    const TABLE_NAME = "activity_activities"; // TODO: get it from model i.e (new Activity)->getTable()

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // tear down
        Schema::table(self::TABLE_NAME, function (Blueprint $table) {
            $table->dropColumn(['customer_uuid', 'salesrep_uuid', 'status_id', 'type_id']);
        });

        Schema::table(self::TABLE_NAME, function (Blueprint $table) {

            // recreate
            $table->uuid('customer_uuid')->nullable();
            $table->uuid('salesrep_uuid')->nullable();
            $table->integer('status_id')->unsigned()->index()->nullable();
            $table->integer('type_id')->unsigned()->index()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // tear down
        Schema::table(self::TABLE_NAME, function (Blueprint $table) {
            $table->dropColumn(['customer_uuid', 'salesrep_uuid', 'status_id', 'type_id']);
        });

        // recreate
        Schema::table(self::TABLE_NAME, function (Blueprint $table) {
            $table->string('customer_uuid')->nullable();
            $table->string('salesrep_uuid')->nullable();
            $table->foreign('status_id')
                ->on('activity_status')
                ->references('id')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');
            $table->foreign('type_id')
                ->on('activity_types')
                ->references('id')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');
            $table->foreign('customer_uuid')
                ->on('users')
                ->references('id')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');
            $table->foreign('salesrep_uuid')
                ->on('users')
                ->references('id')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');
        });
    }
}
