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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('book_id');  //unsigned x NO NEGATIVE NUMBERS!, BigInt is because primary key in laravel is bigIncrements()
            $table->text('review');
            $table->unsignedTinyInteger('rating');
            $table->timestamps();

            $table->foreign('book_id')->references('id')->on('books')
            ->onDelete('cascade');
            //$table->foreignId('book_id')->constrained()->cascadeOnDelete(); BETTER works the same that row16+row21
               //constrained() understand that the table is 'book' because follow name covention <table>_id
            //continue on Book.php and Review.php
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
