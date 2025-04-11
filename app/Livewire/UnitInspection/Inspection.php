<?php

namespace App\Livewire\UnitInspection;

use Livewire\Component;
use App\Models\Question;
use App\Livewire\Forms\UnitInspection\InspectionForm;
use App\Enums\InspectionPermit;
use App\Livewire\Forms\UnitInspection\UnitInformationForm;
use App\Models\UnitChecked;
use App\Services\Inspection\UnitInformationService;
use Mary\Traits\Toast;

class Inspection extends Component
{
	use Toast;

	public array $unitInformation = [];
	public InspectionForm $form;
	public UnitInformationForm $unitInformationForm;
	public $authorCases;

	public function mount()
	{
		$this->searchUnit(search: false);
	}

	public function searchUnit($search = true)
	{
		$this->unitInformationForm->no_registrasi = $this->unitInformationForm->no_registrasi ?? request()->get('no_registrasi');

		if ($search) {
			$this->unitInformationForm->resetValidation();
		}
		$validated = $this->unitInformationForm->validate($this->unitInformationForm->rules($search));
		$this->unitInformation = $this->unitInformationForm->getUnit();
	}

	public function save()
	{
		$this->form->resetValidation();
		$this->form->validate(
			$this->form->rules($this->questions(), $this->unitInformation['author']),
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
				'no_registrasi' => $this->unitInformationForm->no_registrasi,
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
		return Question::select('id', 'ulid', 'question', 'author')
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
