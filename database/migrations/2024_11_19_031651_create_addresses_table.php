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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('address', '255')->nullable(false);
            $table->string('street', '150')->nullable(false);
            $table->string('neighborhood', '255')->nullable(false);
            $table->string('interior_number', '10')->nullable(true)->default('S/N');
            $table->string('outer_number', '255')->nullable(true)->default('S/N');
            $table->char('city', '8')->nullable(false);
            $table->string('state', '50')->nullable(false);
            $table->string('locality', '50')->nullable(false);
            $table->char('cp', '8')->nullable(false);
            $table->addColumn('geometry', 'latitude')->nullable(false);
            $table->addColumn('geometry', 'longitude')->nullable(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
