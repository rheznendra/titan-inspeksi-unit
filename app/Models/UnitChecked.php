<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class UnitChecked extends Model
{
    use HasUlids;

    protected $fillable = [
        'no_unit',
        'answered_questions',
        'inspection_requirement_met',
        'inspection_operational_permit',
        'inspection_operational_permit_description',
        'inspection_other',
        'inspection_other_description',
        'inspection_notes',
    ];

    protected $casts = [
        'answered_questions' => 'json',
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
}
