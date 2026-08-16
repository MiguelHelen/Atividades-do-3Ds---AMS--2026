<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Relacionamento N:M (Muitos para Muitos)
     * Um post pode ter várias tags e uma tag pode pertencer a vários posts.
     * Tabela pivô explícita: post_tag
     */
    public function up(): void
    {
        Schema::create('post_tag', function (Blueprint $table) {
            $table->id();

            $table->foreignId('post_id')
                ->constrained('posts')
                ->onDelete('cascade');

            $table->foreignId('tag_id')
                ->constrained('tags')
                ->onDelete('cascade');

            $table->timestamps();

            // Evita duplicar a mesma tag no mesmo post
            $table->unique(['post_id', 'tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_tag');
    }
};
