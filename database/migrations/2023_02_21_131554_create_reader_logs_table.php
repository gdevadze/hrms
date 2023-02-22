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
        Schema::create('reader_logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('card_id')->unsigned()->nullable();
            $table->foreign('card_id')->references('card_number')->on(\App\Models\User::class)->onUpdate('cascade')->onDelete('cascade');
            $table->dateTime('date');
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
        Schema::dropIfExists('reader_logs');
    }
};
