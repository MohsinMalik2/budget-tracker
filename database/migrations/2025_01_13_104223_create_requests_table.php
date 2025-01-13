<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id(); // Automatically adds an auto-incrementing 'id' field
            $table->unsignedBigInteger('user_id'); // Reference to the user making the request
            $table->decimal('requested_amount', 10, 2); // Requested amount
            $table->text('reason')->nullable(); // Reason for the request
            $table->string('title')->nullable(); // Title (nullable if none exists)
            $table->text('remarks')->nullable(); // Reason for the request status change
            $table->decimal('approve_amount', 10, 2); // Approved amount
            $table->enum('status', ['Pending', 'Approved', 'Disapproved', 'Partially Approved'])->default('Pending'); // Status of the request
            $table->timestamps(); // Timestamps for created_at and updated_at

            // Foreign key constraint linking to the 'users' table
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('requests');
    }
}
