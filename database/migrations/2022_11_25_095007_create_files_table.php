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
        Schema::create('files', function (Blueprint $table) {
            $table->uuid('file_uuid')->primary();
            $table->string('title')->index();
            $table->string('path');
            $table->foreignUuid('folder_uuid')
                ->references('folder_uuid')
                ->on('folders');
            $table->bigInteger('size');
            $table->foreignId('user_id')
                ->references('user_id')
                ->on('users');
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
        Schema::dropIfExists('files');
    }
};
