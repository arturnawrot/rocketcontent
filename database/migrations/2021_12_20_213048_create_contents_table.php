<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_listings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->text('title');
            $table->mediumText('description');
            $table->integer('word_count');
            $table->string('status');
            $table->timestamp('deadline');
            $table->timestamps();
        });

        Schema::create('content_listing_options', function (Blueprint $table) {
            $table->unsignedBigInteger('content_listing_id');
            $table->string('name');
            $table->text('value');
        });

        Schema::create('content_listing_has_a_writer', function (Blueprint $table) {
            $table->unsignedBigInteger('content_listing_id');
            $table->unsignedBigInteger('user_id');
            $table->string('status');
        });

        Schema::create('content_listing_submissions', function (Blueprint $table) {
            $table->unsignedBigInteger('content_listing_id');
            $table->unsignedBigInteger('user_id');
            $table->longText('content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content_listings');
        Schema::dropIfExists('content_listing_options');
        Schema::dropIfExists('content_listing_has_a_writer');
        Schema::dropIfExists('writer_has_submissions');
    }
}
