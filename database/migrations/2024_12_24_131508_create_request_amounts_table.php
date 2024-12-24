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
        Schema::create('request_amounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key to User model
            $table->string('name');  // Tournament or event name
            $table->decimal('amount', 10, 2); // Requested amount
            $table->text('reason');  // Reason for the request
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // Request status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_amounts');
    }
};
