<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

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
        'inspection_date',
        'inspection_notes',
    ];

    protected $casts = [
        'permit' => InspectionPermit::class,
        'inspection_date' => 'datetime:d-m-Y',
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function unit()
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
