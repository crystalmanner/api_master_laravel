<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPbsIdToUsers extends Migration
{
    const TABLE_NAME = "users"; // TODO: get it from model i.e (new User)->getTable()
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(self::TABLE_NAME, function (Blueprint $table) {
            if (!Schema::hasColumn(self::TABLE_NAME, 'pbs_id')) {
                $table->string('pbs_id')->nullable();
            }
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
            if (Schema::hasColumn(self::TABLE_NAME, 'pbs_id')) {
                $table->dropColumn('pbs_id');
            }
        });
    }
}
