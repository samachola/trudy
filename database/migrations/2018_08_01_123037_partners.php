<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Partners extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'partners', function (Blueprint $table) {
                  $table->increments('id');
                  $table->integer('category');
                  $table->string('location');
                  $table->integer('user_id');
                  $table->float('lat')->nullable(true);
                  $table->float('lng')->nullable(true);
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('partners');
    }
}
