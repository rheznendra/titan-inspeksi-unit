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
        Schema::create('inspection_authors', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid')->unique();
            $table->foreignUlid('ulid_inspection_unit')->constrained('inspection_units', 'ulid')->restrictOnDelete();
            $table->char('registration_number', 15);
            $table->string('name', 50);
            $table->enum('author', array_column(InspectionAuthor::cases(), 'value'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspection_authors');
    }
};
