<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('type')->default('restaurant'); // restaurant, cafe, bar, fast_food
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('location')->nullable();
            $table->string('currency')->default('TZS');
            $table->decimal('tax_rate', 5, 2)->default(10.00);
            $table->decimal('service_charge', 5, 2)->default(0.00);
            $table->json('opening_hours')->nullable();
            $table->json('payment_methods')->nullable();
            $table->string('status')->default('pending'); // pending, approved, rejected, suspended
            $table->json('kyc_documents')->nullable();
            $table->string('tin_number')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};
