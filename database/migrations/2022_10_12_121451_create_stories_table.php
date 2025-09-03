<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('place');
            $table->string('title');
            $table->string('date');
            $table->integer('privacy')->default(1)->comment('1=public, 2=follower, 3=only_me');
            $table->integer('status')->default(0)->comment('0=pending, 1=approved');
            $table->string('image');
            $table->longText('description');
            $table->string('gallery')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stories');
    }
}
