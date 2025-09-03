<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('intro')->default(0);
            $table->integer('basic_info')->default(0);
            $table->integer('present_address')->default(0);
            $table->integer('permanent_address')->default(0);
            $table->integer('physical_attributes')->default(0);
            $table->integer('education_info')->default(0);
            $table->integer('career_info')->default(0);
            $table->integer('language')->default(0);
            $table->integer('hobbies_interest')->default(0);
            $table->integer('attitude_behavior')->default(0);
            $table->integer('residency_information')->default(0);
            $table->integer('spiritual_social_bg')->default(0);
            $table->integer('lifestyle')->default(0);
            $table->integer('astronomic_info')->default(0);
            $table->integer('family_information')->default(0);
            $table->integer('partner_expectation')->default(0);
            $table->integer('status')->default(0)->comment('0=Default, 1=Pending, 2=Approved');
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
        Schema::dropIfExists('user_posts');
    }
}
