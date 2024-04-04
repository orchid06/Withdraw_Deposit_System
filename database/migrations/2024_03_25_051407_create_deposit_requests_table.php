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
        Schema::create('deposit_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users' , 'id')->onDelete('cascade');
            $table->foreignId('deposit_method_id')->default(1)->constrained('deposit_methods' , 'id')->onDelete('cascade');
            $table->double('amount',20,8);
            $table->json('fields');
            $table->enum('status' , ['pending', 'approved' , 'rejected'])->default('pending');
            $table->longText('feedback')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposit_requests');
    }
};
