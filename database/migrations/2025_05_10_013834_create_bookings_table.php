<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('room_id')->constrained()->onDelete('cascade');

            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();

            $table->date('start_date');
            $table->date('end_date');

            $table->integer('nights')->default(1); // ✅ NEW
            $table->decimal('total_price', 10, 2)->nullable(); // ✅ NEW

            $table->enum('status', ['waiting', 'approve', 'rejected', 'cancelled'])->default('waiting');

            $table->text('notes')->nullable(); // ✅ Optional
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
