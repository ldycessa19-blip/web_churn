<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('predictions', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['single', 'bulk'])->default('single');
            $table->string('filename')->nullable(); // untuk bulk
            $table->integer('gender')->nullable();
            $table->integer('age')->nullable();
            $table->integer('married')->nullable();
            $table->integer('dependents')->nullable();
            $table->integer('tenure')->nullable();
            $table->integer('phone_service')->nullable();
            $table->integer('internet_service')->nullable();
            $table->decimal('monthly_charge', 15, 2)->nullable();
            $table->decimal('total_charges', 15, 2)->nullable();
            $table->string('prediction_result'); // Potential Churn / Non-Churn
            $table->string('probability');
            $table->integer('total_data')->nullable(); // untuk bulk
            $table->integer('churn_count')->nullable(); // untuk bulk
            $table->integer('nonchurn_count')->nullable(); // untuk bulk
            $table->string('churn_rate')->nullable(); // untuk bulk
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('predictions');
    }
};