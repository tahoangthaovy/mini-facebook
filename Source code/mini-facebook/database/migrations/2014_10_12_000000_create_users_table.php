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
            $table->string('name');
            $table->string('gender');
            $table->date('dob')->nullable();
            $table->string('phone')->nullable();
            $table->string('wordAt')->nullable();
            $table->string('liveAt')->nullable();
            $table->string('avatar')->default('/img/avatars/no-avatar.png');
            $table->string('cover')->default('/img/covers/no-cover.png');
            $table->longText('about')->nullable();
            $table->string('email')->unique();
            $table->string('password');
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