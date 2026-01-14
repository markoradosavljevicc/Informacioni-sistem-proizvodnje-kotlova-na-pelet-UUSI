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
        Schema::create('narudzbinas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kupac_id')->constrained()->onDelete('cascade');
            $table->date('datum_narudzbine');
            $table->date('rok_isporuke')->nullable();
            $table->string('status')->default('kreirana');
            $table->decimal('ukupna_cena', 8, 2);
            $table->text('napomena')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('narudzbinas');
    }
};
