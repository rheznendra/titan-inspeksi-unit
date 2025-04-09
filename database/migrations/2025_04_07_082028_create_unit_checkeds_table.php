<?php

use App\UnitCondition;
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
        Schema::create('unit_checkeds', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid')->unique();
            $table->string('no_unit')->nullable();
            $table->json('answered_questions');
            // $table->boolean('exist');
            // $table->enum('condition', UnitCondition::cases());
            // $table->longText('description')->nullable();
            $table->enum('permit', array_column(\App\Enums\InspectionPermit::cases(), 'value'));
            $table->longText('permit_note')->nullable();
            $table->longText('inspection_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_checkeds');
    }
};
