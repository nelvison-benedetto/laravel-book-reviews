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
        Schema::create('reviews', function (Blueprint $table) {   //crete tab in db called 'reviews' with these fields
            $table->id();   //auto-increment
            $table->unsignedBigInteger('book_id');  //foreign key to link review-book corrispondente, unsigned x no negative nums, BigInt is because lrv usa bigIncrements x gli id
            $table->text('review');
            $table->unsignedTinyInteger('rating');  //tinyinteger intero 1byte
            $table->timestamps();

            $table->foreign('book_id')->references('id')->on('books')  //definisce book_id come foreign key
            ->onDelete('cascade');  //se book viene eliminato vengono eliminate anche tutte le sue reviews

            //$table->foreignId('book_id')->constrained()->cascadeOnDelete(); BETTER works the same that row16+row21
               //constrained() understand that the table is 'book' because follow name covention <table>_id

        });  //continue on Book.php and Review.php
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
