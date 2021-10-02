<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_data', function (Blueprint $table) {
            $table->id();

            $table->foreignId('content_id')->constrained()->references('id')->on('contents')->onDelete('cascade');

            $table->string('page_title')->nullable();
            $table->string('seo_info')->nullable();
            $table->foreignId('cover')->nullable()->references('id')->on('media');
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
        Schema::dropIfExists('content_data');
    }
}
