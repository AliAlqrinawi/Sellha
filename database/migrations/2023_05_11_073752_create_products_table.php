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
            $table->string('file');
            $table->double('price');
            $table->string('discount')->nullable();
            $table->text('description_ar');
            $table->text('description_en');
            $table->unsignedInteger('views')->default(0);
            $table->double('lat');
            $table->double('lng');
            $table->boolean('is_sale')->default(0);
            $table->enum('show' , ['BEST-DEALS' , 'NEW-ARRIVALS' , 'MOST-WANTED' , 'DEALS-OF-THE-WEEK'])->nullable();
            $table->enum('type' , ['NEW' , 'LIKENEW' , 'GOOD' , 'NOTSODUSTY' , 'OLD']);
            $table->enum('status' , ['ACTIVE' , 'INACTIVE'])->default('ACTIVE');
            $table->foreignId('user_id')->constrained('users', 'id')->cascadeOnDelete()->cascadeOnUpdate();
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
