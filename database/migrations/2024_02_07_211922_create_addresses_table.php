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
            // $table->bigIncrements('id');
            $table->unsignedBigInteger('id')->autoIncrement(10);
            $table->string('foreign_table', 100);
            $table->bigInteger('foreign_id');
            $table->string('postal_code', 8)->nullable(false);
            $table->string('state', 2);
            $table->string('city', 200);
            $table->string('sublocality', 200);
            $table->string('street', 200);
            $table->string('street_number', 200)->nullable(false);
            $table->string('complement', 200)->default('');
            // $table->engine = 'InnoDB';
            // $table->charset = 'utf8mb4';
            // $table->collation = 'utf8mb4_0900_ai_ci';
            $table->unique(['foreign_table', 'foreign_id']);
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
