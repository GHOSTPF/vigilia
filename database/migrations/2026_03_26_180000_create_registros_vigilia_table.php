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
        Schema::create('registros_vigilia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('cpf_rg');
            $table->string('telefone');
            $table->integer('idade');
            
            // Campos para menores de idade
            $table->string('nome_responsavel')->nullable();
            $table->string('contato_responsavel')->nullable();
            $table->string('parentesco')->nullable();
            $table->string('termo_autorizacao_path')->nullable();
            $table->string('doc_responsavel_path')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registros_vigilia');
    }
};
