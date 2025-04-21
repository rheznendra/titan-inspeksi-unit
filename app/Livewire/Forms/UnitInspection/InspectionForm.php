<?php

namespace App\Livewire\Forms\UnitInspection;

use App\Enums\InspectionAuthor;
use App\Enums\InspectionPermit;
use App\Models\Question;
use App\Rules\base64Image;
use Illuminate\Validation\Rule;
use Livewire\Form;

class InspectionForm extends Form
{
    public $availability = [];
    public $condition = [];
    public $note = [];
    public ?string $front_image = null;
    public ?string $back_image = null;
    public ?string $permit = null;
    public ?string $permit_note = null;
    public ?string $inspection_notes = null;
    public ?string $inspection_date = null;
    public ?string $tc_name = null;
    public ?string $operation_name = null;
    public ?string $she_name = null;

    public function rules($questions, $unit): array
    {
        $author = $unit->author;
        $hasPermit = $unit->unit->permit()->exists();
        $questions = $questions->where('author', '=', $author);
        $rules =  [
            'permit' => ['nullable', Rule::requiredIf($author === InspectionAuthor::SHE->value), Rule::enum(InspectionPermit::class)],
            'inspection_date' => [
                !$hasPermit ? 'required' : 'nullable',
                'date',
                'before_or_equal:' . now()->format('M d Y')
            ],
            'inspection_notes' => 'nullable|string|max:3750',
        ];

        if ($author === InspectionAuthor::TC->value) {
            $rules['front_image'] = [$unit->unit->permit?->front_image ? 'nullable' : 'required', new base64Image()];
            $rules['back_image'] = [$unit->unit->permit?->back_image ? 'nullable' : 'required', new base64Image()];
        }

        foreach ($questions as $question) {
            $rules['availability.' . $question->id] = 'nullable|boolean';
            $rules['condition.' . $question->id] = 'nullable|boolean';
            $rules['note.' . $question->id] = 'nullable|string|max:100';
        }

        if ($this->permit && InspectionPermit::from($this->permit)->hasNote()) {
            $rules['permit_note'] = [
                'nullable',
                'string',
                'max:100'
            ];
        }
        return $rules;
    }

    public function messages(): array
    {
        return [
            'availability.*.required' => ':Attribute wajib dipilih.',
            'condition.*.required' => ':Attribute wajib dipilih.',
            'permit.required' => ':Attribute wajib dipilih.'
        ];
    }

    public function attributes(): array
    {
        return [
            'availability' => 'kelengkapan',
            'availability.*' => 'kelengkapan',
            'condition' => 'kondisi',
            'condition.*' => 'kondisi',
            'note' => 'keterangan',
            'note.*' => 'keterangan',
            'front_image' => 'foto depan',
            'back_image' => 'foto belakang',
            'permit' => 'izin',
            'permit_note' => 'catatan izin',
            'inspection_date' => 'tanggal inspeksi',
            'inspection_notes' => 'catatan inspeksi'
        ];
    }
}
