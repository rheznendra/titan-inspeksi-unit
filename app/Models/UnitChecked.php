<?php

namespace App\Models;

use App\Enums\InspectionPermit;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitChecked extends Model
{
    use HasUlids, SoftDeletes;

    protected $fillable = [
        'no_registrasi',
        'answered_questions',
        'permit',
        'permit_note',
        'inspection_date',
        'inspection_notes',
    ];

    protected $casts = [
        'answered_questions' => 'json',
        'permit' => InspectionPermit::class,
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
