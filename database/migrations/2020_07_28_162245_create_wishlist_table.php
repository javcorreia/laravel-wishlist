<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWishlistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $schemaTableName = config('wishlist.table_name');

        Schema::dropIfExists($schemaTableName);
    }
}
