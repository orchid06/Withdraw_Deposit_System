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
        Schema::create('withdraw_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users' , 'id')->onDelete('cascade');
            $table->foreignId('withdraw_method_id')->constrained('withdraw_methods' , 'id')->onDelete('cascade');
            $table->double('amount');
            $table->enum('status' , ['pending', 'approved' , 'rejected']);
            $table->longText('feedback');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdraw_requests');
    }
};
