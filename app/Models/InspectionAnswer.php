<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InspectionAnswer extends Model
{
    public $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'ulid_inspection_author',
        'ulid_question',
        'availability',
        'condition',
        'note',
        'author',
    ];

    /**
     * Get the unit that owns the InspectionAnswer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(InspectionUnit::class, 'ulid_inspection_unit', 'ulid');
    }

    /**
     * Get the question that owns the InspectionAnswer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'ulid_question', 'ulid');
    }
}
