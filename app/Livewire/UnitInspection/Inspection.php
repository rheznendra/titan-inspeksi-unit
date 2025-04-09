<?php

namespace App\Livewire\UnitInspection;

use App\Enums\InspectionAuthor;
use Livewire\Component;
use App\Models\Question;
use App\Livewire\Forms\UnitInspection\InspectionForm;
use App\Enums\InspectionPermit;

class Inspection extends Component
{
    public array $unitInformation = [];
    public InspectionForm $form;
    public $authorCases;
    public ?string $no_registrasi = null;
    public $steps = 1;

    public function mount()
    {
        $this->authorCases = InspectionAuthor::cases();
        $this->searchUnit();
    }

    public function searchUnit()
    {
        $nr = $this->no_registrasi ?? request()->get('no_registrasi');
        if ($nr == '123') {
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
                // 'author' => $this->authorCases[random_int(0, count($this->authorCases) - 1)]->value,
                'author' => 'TC',
            ];
        }
    }

    public function save()
    {
        $this->form->resetValidation();
        $this->form->validate(
            $this->form->rules(),
            [],
            $this->form->attributes()
        );
        dd($this->form->all());
    }

    public function resetForm()
    {
        $this->form->reset();
        $this->form->resetValidation();
    }

    private function questions()
    {
        return Question::select('id', 'ulid', 'owner_id', 'question')
            ->with('childQuestions')
            ->doesntHave('ownerQuestion')
            ->orderBy('created_at', 'DESC')
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
