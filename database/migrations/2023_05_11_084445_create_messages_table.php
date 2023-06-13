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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->text('content')->nullable();
            $table->string('image')->nullable();
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();
            $table->boolean('is_read')->default(0);
            $table->enum('type' , ['CONTENT' , 'IMAGE' , 'LOCATION']);
            $table->foreignId('chat_id')->constrained('chats', 'id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('sender_id')->constrained('users', 'id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('receiver_id')->constrained('users', 'id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('product_id')->constrained('products', 'id')->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('messages');
    }
};
