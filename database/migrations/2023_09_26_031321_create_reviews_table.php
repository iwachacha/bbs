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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('lecture_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('year');
            $table->integer('fulfillment_rate');
            $table->integer('ease_rate');
            $table->integer('satisfaction_rate');
            $table->float('average_rate', 3, 2)->nullable();
            $table->text('good_point')->nullable();
            $table->text('bad_point')->nullable();
            $table->text('lecture_content')->nullable();
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
        Schema::dropIfExists('reviews');
    }
};
