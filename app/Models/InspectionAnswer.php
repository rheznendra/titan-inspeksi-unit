<?php

namespace App\Models;

use App\Enums\InspectionAuthor;
use App\Models\InspectionAuthor as ModelsInspectionAuthor;
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
    ];

    /**
     * Get the author that owns the InspectionAnswer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(ModelsInspectionAuthor::class, 'ulid_inspection_unit', 'ulid');
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
