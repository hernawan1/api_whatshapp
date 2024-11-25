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
        Schema::create('member_chatrooms', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('id_chatroom');
            $table->unsignedBigInteger('id_user');
            $table->enum('status_member', ['join', 'leave']);
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
        Schema::dropIfExists('member_chatrooms');
    }
};
