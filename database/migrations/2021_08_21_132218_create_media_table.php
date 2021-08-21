<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->text('alt');
            $table->text('info');
            $table->foreignId('category_id')->references('id')->on('media_categories');
            $table->string('type');

            $table->text('path');
            $table->text('thumbnail');
            $table->string('width');
            $table->string('height');
            $table->unsignedBigInteger('oby')->default(0);

            $table->enum('public', ['yes','no'])->default('no');
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
        Schema::dropIfExists('media');
    }
}
