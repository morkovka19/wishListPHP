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
        Schema::create('friends_request',  function (Blueprint $table){
            $table->bigInteger('sender_id');
            $table->bigInteger('receiver_id');
            $table->enum('status', ['sended', 'accepted', 'rejected']);
            
            $table->primary(['sender_id', 'receiver_id']);
            $table->foreign('sender_id')->references('id')->on('users');
            $table->foreign('receiver_id')->references('id')->on('users');

        });
        Schema::table('users', function (Blueprint $table) {
            $table -> json('friends');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('friends_request');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('friends');
        });
    }
};
