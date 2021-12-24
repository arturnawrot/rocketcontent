<?php

// Credit: https://medium.com/sammich-shop/simple-record-history-tracking-with-laravel-observers-48a2e3c5698b

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('actor_id'); 

            // Which table are we tracking
            $table->string('reference_table');
            // Which record from the table are we referencing
            $table->integer('reference_id')->unsigned();

            $table->longText('body');

            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('histories');
    }
}
