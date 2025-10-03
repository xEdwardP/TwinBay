<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parking_space_id')->constrained('parking_spaces')->onDelete('cascade');
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('cascade');
            $table->foreignId('rate_id')->constrained('rates')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('ticket_number')->unique();
            $table->date('in_date');
            $table->time('in_time');
            $table->date('out_date')->nullable();
            $table->time('out_time')->nullable();
            $table->string('total_time')->nullable();
            $table->decimal('total_amount', 10, 2)->nullable();
            $table->enum('ticket_status', ['activo', 'completado', 'cancelado']);
            $table->string('observations')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
