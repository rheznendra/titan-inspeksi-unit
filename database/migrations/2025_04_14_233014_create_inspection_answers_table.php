<?php

use App\Enums\InspectionAuthor;
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
        Schema::create('inspection_answers', function (Blueprint $table) {
            $table->foreignUlid('ulid_inspection_unit')->constrained('inspection_units', 'ulid')->restrictOnDelete();
            $table->foreignUlid('ulid_question')->constrained('questions', 'ulid')->restrictOnDelete();
            $table->boolean('availability')->nullable();
            $table->boolean('condition')->nullable();
            $table->string('note')->nullable();
            $table->enum('author', array_filter(array_column(InspectionAuthor::cases(), 'value'), fn($value) => $value !== InspectionAuthor::SHE->value));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspection_answer');
    }
};
