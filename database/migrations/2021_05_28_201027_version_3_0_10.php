<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Version3010 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('approval_tracks', function (Blueprint $table) {
            $table->integer('role_id')->nullable()->change();
            $table->integer('department_user_id')->nullable()->after('role_id');
            $table->integer('user_id')->nullable()->after('department_user_id');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('approval_tracks', function (Blueprint $table) {
            $table->integer('role_id')->change();
            if (Schema::hasColumn('approval_tracks', 'department_user_id')) {
                $table->dropColumn('department_user_id');
            };
            if (Schema::hasColumn('approval_tracks', 'user_id')) {
                $table->dropColumn('user_id');
            };
        });
    }
}
