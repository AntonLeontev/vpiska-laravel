<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('sex');
            $table->string('city_fias_id')->nullable();
            $table->string('city_name')->nullable();
            $table->string('email')->unique('email');
            $table->dateTime('email_verified_at')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('password');
            $table->integer('balance')->default(0);
            $table->string('photo_path');
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
        if (!app()->isProduction()) {
            Schema::dropIfExists('users');
        }
    }
};
