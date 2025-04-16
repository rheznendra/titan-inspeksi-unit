<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InspectionAuthor extends Model
{
    use HasUlids;

    protected $fillable = [
        'ulid_inspection_unit',
        'registration_number',
        'name',
        'author',
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

    protected $casts = [
        'author' => \App\Enums\InspectionAuthor::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the unit that owns the InspectionAuthor
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(InspectionUnit::class, 'ulid_inspection_unit', 'ulid');
    }
}
