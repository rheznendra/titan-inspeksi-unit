<?php

namespace App\Livewire\UnitInspection;

use App\Enums\InspectionAuthor;
use Livewire\Component;
use App\Models\Question;
use App\Livewire\Forms\UnitInspection\InspectionForm;
use App\Enums\InspectionPermit;
use App\Models\UnitChecked;
use Mary\Traits\Toast;

class Inspection extends Component
{
    use Toast;

    public array $unitInformation = [];
    public InspectionForm $form;
    public $authorCases;
    public ?string $no_registrasi = null;

    public function mount()
    {
        $this->authorCases = InspectionAuthor::cases();
        $this->searchUnit();
    }

    public function searchUnit()
    {
        if ($this->no_registrasi && $this->no_registrasi !== request()->get('no_registrasi')) {
            return redirect()->route('unit-inspection.inspection', [
                'no_registrasi' => $this->no_registrasi,
            ]);
        } else {
            $this->no_registrasi = $this->no_registrasi ?? request()->get('no_registrasi');
            if ($this->no_registrasi == 'R20250804140534') {
                $this->unitInformation = [
                    'no_unit' => 'ABC1234_A',
                    'jenis_kendaraan' => 'TRAILER',
                    'lokasi' => 'Muara Enim',
                    'nomor_seri_mesin' => '123456789012345678',
                    'nomor_polisi' => 'BG1234ABC',
                    'tahun_pembuatan' => '2014',
                    'perusahaan' => 'PT. Maju Mundur',
                    'kilometer' => '5000',
                    'hours_meter' => '5,5',
                    'brand' => 'HINO',
                    'name' => fake()->name(),
                    'username' => fake()->userName(),
                    'author' => $this->authorCases[random_int(0, count($this->authorCases) - 1)]->value,
                    // 'author' => 'TC',
                ];
            }
        }
    }

    public function save()
    {
        $this->form->resetValidation();
        $this->form->validate(
            $this->form->rules($this->questions()),
            $this->form->messages(),
            $this->form->attributes()
        );

        $questions = Question::whereIn('id', array_keys($this->form->availability))->pluck('question', 'id');

        $groupedAnswer = [];

        foreach ($questions as $questionId => $question) {
            $groupedAnswer[$questionId] = [
                'question' => $question,
                'availability' => $this->form->availability[$questionId],
                'condition' => $this->form->condition[$questionId],
                'note' => $this->form->note[$questionId] ?? null,
            ];
        }
        $groupedAnswer = json_encode($groupedAnswer);
        $this->form->permit =  InspectionPermit::from($this->form->permit)->value;

        try {
            $unitChecked = UnitChecked::create([
                'no_registrasi' => $this->no_registrasi,
                'answered_questions' => $groupedAnswer,
                'permit' => $this->form->permit,
                'permit_note' => $this->form->permit_note,
                'inspection_date' => $this->form->inspection_date,
                'inspection_notes' => $this->form->inspection_notes,
            ]);
            $this->resetForm();
            $this->success('Berhasil', 'Data berhasil disimpan', timeout: 5000);
        } catch (\Exception $e) {
            $this->error('Gagal', 'Data gagal disimpan', timeout: 5000);
        }
    }

    public function resetForm()
    {
        $this->form->reset();
        $this->form->resetValidation();
    }

    private function questions()
    {
        return Question::select('id', 'ulid', 'question')
            ->orderBy('created_at', 'DESC')
            ->limit(3)
            ->get();
    }

    public function render()
    {
        return view('livewire.unit-inspection.inspection.form', [
            'questions' => $this->questions(),
            'inspectionPermits' => asSelectArray(InspectionPermit::cases()),
        ]);
    }
}
