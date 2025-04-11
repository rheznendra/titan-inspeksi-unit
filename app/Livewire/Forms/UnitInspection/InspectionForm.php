<?php

namespace App\Livewire\Forms\UnitInspection;

use App\Enums\InspectionPermit;
use App\Models\Question;
use Illuminate\Validation\Rule;
use Livewire\Form;

class InspectionForm extends Form
{
    public $availability = [];
    public $condition = [];
    public $note = [];
    public $permit = null;
    public ?string $permit_note = null, $inspection_notes = null, $inspection_date = null;

    public function rules($questions, $author): array
    {
        $questions = $questions->where('author', '=', $author);
        $rules =  [
            'permit' => ['required', Rule::enum(InspectionPermit::class)],
            'inspection_date' => 'required|date|before_or_equal:' . now()->format('M d Y'),
            'inspection_notes' => 'nullable|string|max:3750',
        ];

        foreach ($questions as $question) {
            $rules['availability.' . $question->id] = 'required|boolean';
            $rules['condition.' . $question->id] = 'required|boolean';
            $rules['note.' . $question->id] = 'nullable|string|max:100';
        }

        if ($this->permit && InspectionPermit::from($this->permit)->hasNote()) {
            $rules['permit_note'] = [
                'required',
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
            'permit' => 'izin',
            'permit_note' => 'catatan izin',
            'inspection_date' => 'tanggal inspeksi',
            'inspection_notes' => 'catatan inspeksi'
        ];
    }
}
