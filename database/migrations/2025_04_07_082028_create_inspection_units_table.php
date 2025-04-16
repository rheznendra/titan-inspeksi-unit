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
        Schema::create('inspection_units', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid')->unique();
            // Unit Information
            $table->char('registration_number', 15);
            $table->char('unit_number', 9);
            $table->string('vehicle_type', 15);
            $table->char('plate_number', 9);
            $table->year('year_manufacture');
            $table->string('company', 25);
            $table->string('location', 15);
            $table->char('engine_serial_number', 18);
            $table->integer('kilometer');
            $table->decimal('hours_meter', 10, 1);
            $table->string('brand', 10);
            //
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
