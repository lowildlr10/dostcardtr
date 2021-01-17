<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('emp_id')->unique();
            $table->integer('bio_id')->unique();
            $table->integer('office_id');
            $table->integer('division_id');
            $table->integer('unit_id');
            $table->string('first_name');
            $table->string('mid_name')->nullable();
            $table->string('last_name');
            $table->string('position');
            $table->date('birthday');
            $table->enum('gender', ['male', 'female']);
            $table->string('user_name')->unique();
            $table->string('mobile_no')->unique()->nullable();
            $table->string('email')->unique();
            $table->enum('emp_status', ['','permanent','contractual']);
            $table->dateTime('email_verified_at')->nullable();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->string('e_signature')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->integer('user_role');
            $table->dateTime('approved_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
