<?php

namespace App\Http\Controllers\Export;

use App\Enums\InspectionPermit;
use App\Http\Controllers\Controller;
use App\Models\UnitChecked;
use Spatie\LaravelPdf\Enums\Format;
use Spatie\LaravelPdf\Enums\Unit;

use function Spatie\LaravelPdf\Support\pdf;

class UnitInspectionExport extends Controller
{
    public function export(string $ulid)
    {
        $unitChecked = UnitChecked::where('ulid', $ulid)->firstOrFail();
        $unitChecked->answered_questions = json_decode($unitChecked->answered_questions);

        $inspectionPermits =  InspectionPermit::class;
        $fileName = 'Unit Inspection-' . $unitChecked->no_registrasi . '-' . $unitChecked->inspection_date->format('dmY') . '.pdf';

        return pdf()->view('pdf.inspection', [
            'data' => $unitChecked,
            'inspection_permits' => $inspectionPermits,
        ])
            ->headerView('pdf.header')
            ->margins(120, 0, 48, 0, Unit::Pixel)
            ->format(Format::A4)
            ->name($fileName)
            ->download();
    }
}
