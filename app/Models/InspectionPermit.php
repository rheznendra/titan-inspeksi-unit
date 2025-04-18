<?php

namespace App\Models;

use App\Enums\InspectionPermit as EnumsInspectionPermit;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InspectionPermit extends Model
{
    public $primaryKey = null;
    public $incrementing = false;

    protected $fillable = [
        'ulid_inspection_unit',
        'front_image',
        'back_image',
        'permit',
        'permit_note',
        'tc_name',
        'operation_name',
        'she_name',
        'inspection_date',
        'inspection_notes',
        'tc_filled_at',
        'operation_filled_at',
        'she_filled_at',
    ];

    protected $casts = [
        'permit' => EnumsInspectionPermit::class,
        'inspection_date' => 'datetime:d-m-Y',
        'tc_filled_at' => 'datetime',
        'operation_filled_at' => 'datetime',
        'she_filled_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the unit that owns the InspectionPermit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(InspectionUnit::class, 'ulid_inspection_unit', 'ulid');
    }

    #[Scope]
    protected function filledByTC(Builder $query): void
    {
        $query->whereNotNull('tc_filled_at');
    }

    #[Scope]
    protected function filledByOperation(Builder $query): void
    {
        $query->whereNotNull('operation_filled_at');
    }

    #[Scope]
    protected function filledBySHE(Builder $query): void
    {
        $query->whereNotNull('she_filled_at');
    }

    #[Scope]
    protected function notFilledBySHE(Builder $query): void
    {
        $query->whereNull('she_filled_at');
    }
}
