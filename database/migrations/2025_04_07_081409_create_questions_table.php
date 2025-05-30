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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid')->unique();
            $table->longText('question');
            $table->enum('author', array_filter(
                array_column(InspectionAuthor::cases(), 'value'),
                fn($enum) => $enum !== InspectionAuthor::SHE->value
            ));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
