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
        Schema::create('friend_requests',  function (Blueprint $table){
            $table->id();
            $table->bigInteger('sender_id');
            $table->bigInteger('receiver_id');
            $table->enum('status', ['sended', 'accepted', 'rejected']);
            
            //$table->primary(['sender_id', 'receiver_id']);
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();

        });
   
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
        Schema::table('friend_requests', function (Blueprint $table) {
            $table->dropForeign(['sender_id']);
            $table->dropForeign(['receiver_id']);
        });
        
        Schema::dropIfExists('friend_requests');
    }
};
