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
        Schema::create('ics', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('commName')->nullable();
            $table->string('slug')->unique();
            $table->foreignId('image')->constrained('images');
            $table->foreignId('blog_diagram')->constrained('images');
            $table->foreignId('store_id')->constrained('stores');
            $table->integer('views')->default(0);
            $table->integer('likes')->default(0);
            $table->string('manName')->nullable();
            $table->string('videoUrl')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('i_c_s');
    }
};
