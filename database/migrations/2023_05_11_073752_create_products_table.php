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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title_ar');
            $table->string('title_en');
            $table->string('image');
            $table->string('price');
            $table->text('description_ar');
            $table->text('description_en');
            $table->string('views');
            $table->decimal('lat');
            $table->decimal('lng');
            $table->enum('type' , ['NEW' , 'LIKENEW' , 'GOOD' , 'NOTSODUSTY' , 'OLD']);
            $table->enum('status' , ['ACTIVE' , 'INACTIVE'])->default('ACTIVE');
            $table->foreignId('category_id')->constrained('categories', 'id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('sub_category_id')->constrained('categories', 'id')->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('products');
    }
};
