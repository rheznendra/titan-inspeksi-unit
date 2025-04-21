<?php

namespace App\Http\Controllers\Export;

use function Spatie\LaravelPdf\Support\pdf;
use Spatie\LaravelPdf\Enums\Unit;
use Spatie\LaravelPdf\Enums\Format;
use App\Models\InspectionUnit;
use App\Http\Controllers\Controller;

use App\Enums\InspectionPermit;
use App\Models\Question;

class UnitInspectionExport extends Controller
{
    public function export(string $ulid)
    {
        $unitChecked = InspectionUnit::withExists('permit')
            ->with('answers')
            ->where('ulid', $ulid)
            ->firstOrFail();

        $questions = Question::pluck('question', 'ulid');
        $answers = $questions->map(function ($question, $key) use ($unitChecked) {
            $answer = $unitChecked->answers->where('ulid_question', $key)->first();
            return [
                'question' => $question,
                'availability' => $answer->availability ?? null,
                'condition' => $answer->condition ?? null,
                'note' => $answer->note ?? null,
            ];
        });

        $inspectionPermits =  InspectionPermit::class;
        $fileName = 'Unit Inspection-' . $unitChecked->registration_number . '-' . $unitChecked->permit->inspection_date->format('dmY') . '.pdf';

        return pdf()->view('pdf.inspection', [
            'data' => $unitChecked,
            'answers' => $answers,
            'inspection_permits' => $inspectionPermits,
        ])
            ->headerView('pdf.header')
            ->margins(120, 0, 48, 0, Unit::Pixel)
            ->format(Format::A4)
            ->name($fileName)
            ->download();
    }
}
