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
        Schema::create('inspection_permits', function (Blueprint $table) {
            $table->foreignUlid('ulid_inspection_unit')->constrained('inspection_units', 'ulid')->restrictOnDelete();
            $table->text('front_image')->nullable();
            $table->text('back_image')->nullable();
            $table->enum('permit', array_column(\App\Enums\InspectionPermit::cases(), 'value'))->nullable();
            $table->longText('permit_note')->nullable();
            $table->string('tc_name', 50)->nullable();
            $table->string('operation_name', 50)->nullable();
            $table->string('she_name', 50)->nullable();
            $table->date('inspection_date')->nullable();
            $table->longText('inspection_notes')->nullable();
            $table->timestamp('tc_filled_at')->nullable();
            $table->timestamp('operation_filled_at')->nullable();
            $table->timestamp('she_filled_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspection_permit');
    }
};
