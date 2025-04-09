<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'ulid',
        'owner_id',
        'question',
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

    public function ownerQuestion(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'owner_id', 'id')->latest();
    }

    public function childQuestions()
    {
        return $this->hasMany(Question::class, 'owner_id', 'id');
    }
}
