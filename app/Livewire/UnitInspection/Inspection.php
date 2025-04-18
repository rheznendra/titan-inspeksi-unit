<?php

namespace App\Livewire\UnitInspection;

use Mary\Traits\Toast;
use Livewire\Component;
use App\Models\Question;
use App\Livewire\Forms\UnitInspection\UnitInformationForm;
use App\Livewire\Forms\UnitInspection\InspectionForm;
use App\Enums\InspectionPermit;
use App\Enums\InspectionAuthor;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;

class Inspection extends Component
{
    use Toast;

    public array $unitInformation = [];
    public InspectionForm $form;
    public UnitInformationForm $unitInformationForm;
    public $authorCases;

    public bool $modalCamera = false;
    public ?string $modalCameraTitle = null;
    public bool $imageTaken = false;
    public bool $imageConfirmed = false;
    public bool $hasImage = false;
    public bool $isPreview = false;
    public ?string $imageUrl = null;

    public function mount()
    {
        $this->searchUnit();
    }

    public function searchUnit()
    {
        if (!request()->has('no_registrasi') || !request()->get('no_registrasi')) {
            abort(403);
        }
        $this->unitInformationForm->no_registrasi = request()->get('no_registrasi');

        $unit = request()->only(
            [
                'no_unit',
                'jenis_kendaraan',
                'nomor_seri_mesin',
                'nomor_polisi',
                'tahun_pembuatan',
                'perusahaan',
                'kilometer',
                'hours_meter',
                'brand',
                'name',
                'author',
            ]
        );
        $this->unitInformationForm->getUnit($unit);
        if ($this->unitInformationForm->unitExists) {
            if ($this->unitInformationForm->unit->permit()->exists()) {
                $this->form->permit = $this->unitInformationForm->unit->permit->permit;
                $this->form->permit_note = $this->unitInformationForm->unit->permit->permit_note;
                $this->form->inspection_date = $this->unitInformationForm->unit->permit->inspection_date;
                $this->form->tc_name = $this->unitInformationForm->unit->permit->tc_name;
                $this->form->operation_name = $this->unitInformationForm->unit->permit->operation_name;
                $this->form->she_name = $this->unitInformationForm->unit->permit->she_name;
            }
            if ($this->unitInformationForm->unit->answers()->exists()) {
                $answers = $this->unitInformationForm
                    ->unit
                    ->answers()
                    ->join('questions', 'questions.ulid', '=', 'inspection_answers.ulid_question')
                    ->whereNot('questions.author', InspectionAuthor::SHE->value);

                $this->form->availability = $answers->pluck('availability', 'questions.id')->toArray();
                $this->form->condition = $answers->pluck('condition', 'questions.id')->toArray();
                $this->form->note = $answers->pluck('note', 'questions.id')->toArray();
            }
        }
    }

    public function alertCameraError($message)
    {
        $this->error('Terjadi Kesalahan', $message, timeout: 10000);
    }

    public function imageExists($type)
    {
        $this->imageUrl = null;
        $this->imageConfirmed = false;
        $isPreview = false;

        $img = null;

        if ($type === 'front') {
            $title = 'Ambil Foto Depan';
            $uploadedImage = $this->unitInformationForm->unit->permit?->front_image;
            if (!$uploadedImage) {
                $img = $this->form->front_image;
            } else {
                $img = $uploadedImage;
            }
        } else if ($type === 'back') {
            $title = 'Ambil Foto Belakang';
            $uploadedImage = $this->unitInformationForm->unit->permit?->back_image;
            if (!$uploadedImage) {
                $img = $this->form->back_image;
            } else {
                $img = $uploadedImage;
            }
        }
        if ($img) {
            if ($uploadedImage) {
                $this->imageUrl = asset('storage/' . $this->unitInformationForm->no_registrasi . '/' . $img);
            } else {
                $this->imageUrl = $img;
            }
            $isPreview = true;
            $this->imageConfirmed = true;
        }
        $this->isPreview = $isPreview;
        $this->modalCameraTitle = $title;
    }

    public function initModalCamera()
    {
        $this->modalCamera = true;
    }

    public function confirmImage($type, $imageData)
    {
        if ($type === 'front') {
            $this->form->front_image = $imageData;
        } else if ($type === 'back') {
            $this->form->back_image = $imageData;
        }
        $this->imageConfirmed = true;
    }

    public function retakeImage($type)
    {
        if ($type === 'front') {
            $this->form->front_image = null;
        } else if ($type === 'back') {
            $this->form->back_image = null;
        }
        $this->isPreview = false;
        $this->imageConfirmed = false;
    }

    private function base64ToImage($base64String)
    {
        $image = preg_replace('/^data:image\/jpeg;base64,/', '', $base64String);
        $image = str_replace(' ', '+', $image); // fix encoding issues
        return base64_decode($image);
    }

    public function save()
    {
        $this->form->resetValidation();
        $this->form->validate(
            $this->form->rules(
                $this->questions(),
                $this->unitInformationForm->author,
                $this->unitInformationForm->unit->permit()->exists()
            ),
            $this->form->messages(),
            $this->form->attributes()
        );

        $questions = Question::select('id', 'ulid', 'question')->get();

        $answers = [];
        if ($this->unitInformationForm->author !== InspectionAuthor::SHE->value && ($this->form->availability || $this->form->condition || $this->form->note)) {
            foreach ($questions as $question) {
                if (isset($this->form->availability[$question->id]) || isset($this->form->condition[$question->id]) || isset($this->form->note[$question->id])) {
                    $answers[] = [
                        'ulid_question' => $question->ulid,
                        'availability' => $this->form->availability[$question->id] ?? null,
                        'condition' => $this->form->condition[$question->id] ?? null,
                        'note' => $this->form->note[$question->id] ?? null,
                    ];
                }
            }
        }
        if ($this->unitInformationForm->author === InspectionAuthor::SHE->value) {
            $this->form->permit =  InspectionPermit::from($this->form->permit)->value;
        }

        $params = [];
        if ($this->unitInformationForm->unit->permit()->doesntExist() || !$this->unitInformationForm->unit->permit->inspection_date) {
            $params['inspection_date'] = $this->form->inspection_date;
        }

        $author = $this->unitInformationForm->author;
        $authorName = $this->unitInformationForm->name;
        if ($author === InspectionAuthor::TC->value) {
            $params['tc_filled_at'] = now();
            $params['tc_name'] = $authorName;

            if ($this->form->front_image) {
                $fileName = $this->unitInformationForm->no_registrasi . '/front_' . now()->format('YmdHis') . '.jpg';
                $params['front_image'] = basename($fileName);
                if ($this->unitInformationForm->unit->permit?->front_image) {
                    Storage::disk('public')->delete($this->unitInformationForm->no_registrasi . '/' . $this->unitInformationForm->unit->permit->front_image);
                }
                Storage::disk('public')->put($fileName, $this->base64ToImage($this->form->front_image));
            }
            if ($this->form->back_image) {
                $fileName = $this->unitInformationForm->no_registrasi . '/back_' . now()->format('YmdHis') . '.jpg';
                $params['back_image'] = basename($fileName);
                if ($this->unitInformationForm->unit->permit?->back_image) {
                    Storage::disk('public')->delete($this->unitInformationForm->no_registrasi . '/' . $this->unitInformationForm->unit->permit->back_image);
                }
                Storage::disk('public')->put($fileName, $this->base64ToImage($this->form->back_image));
            }
        } else if ($author === InspectionAuthor::OPERATION->value) {
            $params['operation_filled_at'] = now();
            $params['operation_name'] = $authorName;
        } else if ($author === InspectionAuthor::SHE->value) {
            $params['permit'] = InspectionPermit::from($this->form->permit)->value;
            $params['permit_note'] = $this->form->permit_note;
            $params['she_filled_at'] = now();
            $params['she_name'] = $authorName;
            $params['inspection_notes'] = $this->form->inspection_notes;
        }

        try {
            $permit = $this->unitInformationForm->unit->permit()->updateOrCreate([
                'ulid_inspection_unit' => $this->unitInformationForm->unit->ulid,
            ], $params);
            if ($author !== InspectionAuthor::SHE->value && $answers) {
                try {
                    $this->unitInformationForm->unit->answers($author)->delete();
                    $this->unitInformationForm->unit->answers()->createMany($answers);
                    $this->resetForm();
                    $this->success('Berhasil', 'Data berhasil disimpan', timeout: 5000);
                } catch (\Exception $e) {
                    $this->unitInformationForm->unit->permit()->delete();
                    $this->error('Gagal', 'Data gagal disimpan', timeout: 5000);
                }
            } else {
                $this->resetForm();
                $this->success('Berhasil', 'Data berhasil disimpan', timeout: 5000);
            }
        } catch (\Exception $e) {
            $this->error('Gagal', 'Data gagal disimpan', timeout: 5000);
        }
    }

    public function resetForm()
    {
        // $this->form->reset();
        $this->form->resetValidation();
    }

    private function questions()
    {
        return Question::select('id', 'ulid', 'question', 'author')
            ->orderBy('created_at', 'DESC')
            ->limit(10)
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
