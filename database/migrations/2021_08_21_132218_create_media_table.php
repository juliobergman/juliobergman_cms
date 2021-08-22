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

            $table->string('name')->nullable();
            $table->text('alt')->nullable();
            $table->text('info')->nullable();

            $table->unsignedBigInteger('category_id')->default(1);
            $table->foreign('category_id')->references('id')->on('media_categories');

            $table->text('public_path'); // Folder Path
            $table->text('storage_path'); // Folder Path

            $table->text('fullsize'); // Original File
            $table->text('xlarge'); // 2048 x 1536
            $table->text('large'); // 1024 x 768
            $table->text('medium'); // 640x480
            $table->text('thumbnail'); // 200 x 200

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
