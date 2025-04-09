<?php

namespace App\Livewire\Forms\UnitInspection;

use App\Enums\InspectionPermit;
use Illuminate\Validation\Rule;
use Livewire\Form;

class InspectionForm extends Form
{
    public $availability = [];
    public $condition = [];
    public $note = [];
    public $permit = null;
    public ?string $permit_note = null, $inspection_notes = null;

    public function rules(): array
    {
        $rules =  [
            'availability' => 'required|array',
            'availability.*' => 'required',
            'condition' => 'required|array',
            'condition.*' => 'required',
            'note' => 'nullable|array',
            'note.*' => 'string|max:100',
            'permit' => ['required', Rule::enum(InspectionPermit::class)],
            'inspection_date' => 'required|date',
            'inspection_notes' => 'nullable|string|max:100',
        ];
        if ($this->permit && InspectionPermit::from($this->permit)->hasNote()) {
            $rules['permit_note'] = [
                'required',
                'string',
                'max:100'
            ];
        }
        return $rules;
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
            'inspection_notes' => 'catatan inspeksi'
        ];
    }
}
