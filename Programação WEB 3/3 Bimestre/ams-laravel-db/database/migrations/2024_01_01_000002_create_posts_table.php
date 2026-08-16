<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Relacionamento 1:N (Um para Muitos)
     * Um usuário pode ter vários posts.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            // Chave estrangeira SEM unique -> permite vários posts por usuário (1:N)
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->string('title');
            $table->text('content');
            $table->timestamps();

            $table->index('title'); // índice adicional de exemplo
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
