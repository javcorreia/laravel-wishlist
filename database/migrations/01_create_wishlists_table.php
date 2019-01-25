<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWishlistsTable extends Migration
{

    public function up()
    {
        $schemaTableName = config('wishlist.table_name');

        Schema::create($schemaTableName, function (Blueprint $table) use ($schemaTableName) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable(true);
            $table->char('session_id', 255)->nullable(true);
            $table->integer('item_id')->unsigned();
            $table->timestamps();

            // index
            $table->index('user_id', $schemaTableName . '_user_id_index');
        });
    }

    public function down()
    {
        $schemaTableName = config('wishlist.table_name');

        Schema::dropIfExists($schemaTableName);
    }
}
