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
        Schema::create('inventory_images', function (Blueprint $table) {
            $table->id();
            $table->string('image_name');
            $table->string('image_data')->unique();
            $table->foreignId('inventory_id')->constrained('inventory')->onDelete('cascade');
            $table->enum('status',['0','1','2'])->default(1);
            $table->foreignId('deleted_by_user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->softDeletes()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_images');
    }
};
