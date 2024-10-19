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
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_table_id')->constrained()->onDelete('cascade');
            $table->string('name', 50)->nullable(false);
            $table->integer('capacity')->nullable(false);
            $table->integer('number_people')->nullable(false);
            $table->string('status_name, 50')->nullable(false)->default("ACTIVE");
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
        Schema::dropIfExists('tables');
    }
};
