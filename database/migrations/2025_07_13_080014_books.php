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
        Schema::create('books', function (Blueprint $table) {
            $table->id('id_book');
            $table->unsignedBigInteger('id_category');
            $table->string('name_book');
            $table->string('cover_book')->nullable();
            $table->string('author');
            $table->string('publisher');
            $table->date('publication_date');
            $table->string('description');
            $table->string('isbn')->unique();
            $table->integer('stock')->default(0);
            $table->timestamps();

            $table->foreign('id_category')->references('id_category')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
