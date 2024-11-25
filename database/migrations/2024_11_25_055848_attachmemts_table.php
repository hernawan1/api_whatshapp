<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('attachmemts', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('id_chatroom');
            $table->unsignedBigInteger('id_user');
            $table->string('name_file');
            $table->string('type_file');
            $table->string('path');
            $table->timestampsTz();
            $table->softDeletesTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('attachmemts');
    }
};
