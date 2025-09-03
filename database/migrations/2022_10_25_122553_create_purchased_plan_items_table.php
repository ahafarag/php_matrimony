<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasedPlanItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchased_plan_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('show_auto_profile_match')->default(0);
            $table->integer('express_interest')->default(0);
            $table->integer('gallery_photo_upload')->default(0);
            $table->integer('contact_view_info')->default(0);
            $table->integer('free_plan_purchased')->default(0)->comment('0=No, 1=Yes');
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
        Schema::dropIfExists('purchased_plan_items');
    }
}
