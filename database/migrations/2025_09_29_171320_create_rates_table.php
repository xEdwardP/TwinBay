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
        Schema::create('rates', function (Blueprint $table) {
            $table->id();
            $table->enum('name', ['regular', 'nocturna', 'fin de semana', 'feriados']);
            $table->enum('type', ['por hora', 'por dia']);
            $table->decimal('cost', 10, 2);
            $table->integer('quantity');
            $table->integer('grace_period_minutes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rates');
    }
};
