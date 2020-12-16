<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrawPrizeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('draw_prize', function (Blueprint $table) {
            $table->id();
            $table->integer('draw_id');
            $table->integer('prize_id');
            $table->tinyInteger('qty')->default(0);
            $table->tinyInteger('available_qty')->default(0);
            $table->tinyInteger('order_column')->default(0);

            $table->softDeletes();
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
        Schema::dropIfExists('draw_prize');
    }
}
