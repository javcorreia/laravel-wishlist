<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWishlistIndexes extends Migration
{
    public function up()
    {
        $schemaTableName = config('wishlist.table_name');

        Schema::table($schemaTableName, function (Blueprint $table) {
            $table->index('user_id');
            $table->index('session_id');
        });
    }

    public function down()
    {
        $schemaTableName = config('wishlist.table_name');

        Schema::table($schemaTableName, function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['session_id']);
        });

    }
}
