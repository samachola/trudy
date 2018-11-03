<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Requests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'requests', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('category_id');
                $table->string('date');
                $table->string('client_email');
                $table->integer('partner_id');
                $table->integer('status');
                $table->integer('fee')->default(0);
                $table->integer('rating')->default(0);
                $table->integer('paid')->default(0);
                $table->timestamps();
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
        Schema::dropIfExists('requests');
    }
}
