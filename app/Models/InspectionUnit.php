<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class InspectionUnit extends Model
{
    use HasUlids, SoftDeletes;

    protected $fillable = [
        'registration_number',
        'unit_number',
        'vehicle_type',
        'plate_number',
        'year_manufacture',
        'company',
        'location',
        'engine_serial_number',
        'kilometer',
        'hours_meter',
        'brand',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the columns that should receive a unique identifier.
     *
     * @return array<int, string>
     */
    public function uniqueIds(): array
    {
        return ['ulid'];
    }

    public function permit(): HasOne
    {
        return $this->hasOne(InspectionPermit::class, 'ulid_inspection_unit', 'ulid');
    }

    public function answers(?string $author = null): HasMany
    {
        return $this->hasMany(InspectionAnswer::class, 'ulid_inspection_unit', 'ulid');
    }
}
