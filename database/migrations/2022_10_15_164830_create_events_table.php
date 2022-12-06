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
            $table->foreignIdFor(User::class, 'creator_id')
                ->constrained('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->dateTime('starts_at');
            $table->dateTime('ends_at');
            $table->unsignedInteger('price');
            $table->unsignedInteger('fee');
            $table->string('city_fias_id', 50);
            $table->string('city_name', 150);
            $table->string('street_fias_id', 50);
            $table->string('street', 150);
            $table->string('street_type', 10)->default('ул.');
            $table->string('building_fias_id', 50);
            $table->string('building', 50);
            $table->string('phone', 20);
            $table->integer('max_members');
            $table->text('description')->nullable();
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
