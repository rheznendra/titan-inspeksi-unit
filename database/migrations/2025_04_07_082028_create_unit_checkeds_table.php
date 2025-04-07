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
            $table->boolean('inspection_requirement_met')->default(false);
            $table->boolean('inspection_operational_permit')->default(false);
            $table->longText('inspection_operational_permit_description')->nullable();
            $table->boolean('inspection_other')->default(false);
            $table->longText('inspection_other_description')->nullable();

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
