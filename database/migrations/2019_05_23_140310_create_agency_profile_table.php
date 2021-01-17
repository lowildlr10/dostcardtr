<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgencyProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agency_profile', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('agency_id');
            $table->text('agency_logo')->nullable();
            $table->text('address');
            $table->text('zip_code');
            $table->text('telephone_no')->nullable();
            $table->text('email')->nullable();
            $table->text('website')->nullable();
            $table->text('mobile_no')->nullable();
            $table->integer('agency_head');
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
        Schema::dropIfExists('agency_profile');
    }
}
