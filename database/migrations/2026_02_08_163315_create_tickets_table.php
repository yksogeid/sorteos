<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('numero');
            $table->boolean('available')->default(true);
            $table->boolean('belongs_to_anticipated_prize')->default(false);
            $table->string('anticipated_prize_name')->nullable();
            $table->foreignId('sorteo_id')->constrained('sorteos')->onDelete('cascade');
            $table->foreignId('venta_id')->nullable()->constrained('ventas')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
