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
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->String('name')->unique();
            $table->String('description')->unique();
            $table->String('logo')->nullable();
            $table->timestamps();
        });
        Schema::table('products', function (Blueprint $table){
            $table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['brand_id']); // Eliminar la clave foránea
            $table->dropColumn(['brand_id']);
        });
        Schema::dropIfExists('brands');
    }
};
