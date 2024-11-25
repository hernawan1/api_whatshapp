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
        Schema::create('messages', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('id_chatroom');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_attachmemt')->nullabel();
            $table->string('message');
            $table->enum('type_message', ['file', 'text', 'link']);
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
        Schema::dropIfExists('messages');
    }
};
