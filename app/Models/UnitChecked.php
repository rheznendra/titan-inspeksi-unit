<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class UnitChecked extends Model
{
    use HasUlids;

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
