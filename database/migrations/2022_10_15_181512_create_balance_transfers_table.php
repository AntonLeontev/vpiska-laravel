<?php

use App\Models\Order;
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
        Schema::create('balance_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(Order::class)->nullable()->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('sum');
            $table->string('type');
            $table->string('description');
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
            Schema::dropIfExists('balance_transfers');
        }
    }
};
