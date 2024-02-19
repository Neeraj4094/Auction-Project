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
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->uuid('inventory_code')->unique();
            $table->string('name');
            $table->foreignId('category_id')->constrained('category')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('description');
            $table->decimal('price',10,2);
            $table->enum('position',['1', '2', '3']);
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
        Schema::dropIfExists('inventory');
    }
};
