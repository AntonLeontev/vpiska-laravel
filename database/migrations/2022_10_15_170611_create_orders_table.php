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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')
                ->constrained('events')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('customer_id')
            ->constrained('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('payment_id');
            $table->integer('status')->default(0);
            $table->string('code', 6);
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
            Schema::dropIfExists('orders');
        }
    }
};
