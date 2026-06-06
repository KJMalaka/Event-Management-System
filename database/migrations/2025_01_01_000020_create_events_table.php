<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organizer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique()->index();
            $table->text('description');
            $table->string('location');
            $table->string('venue')->nullable();
            $table->dateTime('start_date')->index();
            $table->dateTime('end_date');
            $table->unsignedInteger('capacity')->default(100);
            $table->decimal('price', 10, 2)->default(0.00);
            $table->enum('status', ['draft', 'published', 'cancelled', 'completed'])->default('draft')->index();
            $table->string('banner_image')->nullable();
            $table->boolean('requires_approval')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'start_date']);
            $table->index(['organizer_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
