<?php

use App\Models\User;
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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'creator_id')->referenced()->cascadeOnDelete()->cascadeOnUpdate();
            $table->dateTime('starts_at');
            $table->dateTime('ends_at');
            $table->unsignedInteger('price');
            $table->integer('city');
            $table->string('city_name');
            $table->string('street');
            $table->string('building');
            $table->string('phone');
            $table->integer('max_members');
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
            Schema::dropIfExists('events');
        }
    }
};
