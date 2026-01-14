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
        Schema::create('stavka_narudzbines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('narudzbina_id')->constrained()->onDelete('cascade');
            $table->foreignId('proizvod_id')->constrained()->onDelete('cascade');
            $table->integer('kolicina')->default(1);
            $table->decimal('cena_jedinice', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stavka_narudzbines');
    }
};
