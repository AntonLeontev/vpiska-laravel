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
            $table->boolean('sex');
            $table->integer('city_code')->nullable();
            $table->string('city_name')->nullable();
            $table->string('email')->unique('email');
            $table->boolean('email_confirmed')->default(0);
            $table->string('password');
            $table->boolean('activated')->default(0);
            $table->decimal('balance')->default(0);
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
        Schema::dropIfExists('users');
    }
};
