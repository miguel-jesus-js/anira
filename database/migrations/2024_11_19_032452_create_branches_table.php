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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('address_id')->nullable(true)->constrained()->onDelete('cascade');
            $table->foreignId('employee_id')->nullable(true)->constrained()->onDelete('cascade');
            $table->string('name', 80)->nullable(false);
            $table->string('email', 100)->nullable(false)->unique();
            $table->char('country_code', 5)->nullable(false);
            $table->char('phone_number', 11)->nullable(false)->unique();
            $table->integer('status')->nullable(false)->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
