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
        Schema::create('servis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kupac_id')->constrained()->onDelete('cascade');
            $table->foreignId('proizvod_id')->constrained()->onDelete('cascade');
            $table->date('datum_prijave');
            $table->date('datum_zavrsetka')->nullable();
            $table->text('opis_kvara')->nullable();
            $table->text('opis_popravke')->nullable();
            $table->string('status')->default('prijavljen');
            $table->foreignId('serviser_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servis');
    }
};
