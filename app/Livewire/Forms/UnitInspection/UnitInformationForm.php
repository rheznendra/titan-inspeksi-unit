<?php

namespace App\Livewire\Forms\UnitInspection;

use App\Enums\InspectionAuthor;
use App\Models\InspectionUnit;
use Illuminate\Support\Facades\Http;
use Livewire\Form;

class UnitInformationForm extends Form
{
    private $authorCases;

    public ?InspectionUnit $unit = null;
    public ?string $no_registrasi = null;
    public ?string $unit_number = null;
    public ?string $vehicle_type = null;
    public ?string $plate_number = null;
    public ?string $year_manufacture = null;
    public ?string $company = null;
    public ?string $location = null;
    public ?string $engine_serial_number = null;
    public ?string $kilometer = null;
    public ?string $hours_meter = null;
    public ?string $brand = null;
    public ?string $name = null;
    public ?string $username = null;
    public ?string $author = null;
    public bool $unitExists = false;

    public function getUnit($request = []): void
    {
        if (!$this->no_registrasi) {
            $this->unit = null;
            return;
        }
        $this->authorCases = InspectionAuthor::cases();

        $this->getApi($request);

        $unit = [
            'unit_number' => $this->unit_number,
            'vehicle_type' => $this->vehicle_type,
            'plate_number' => $this->plate_number,
            'year_manufacture' => $this->year_manufacture,
            'company' => $this->company,
            'location' => $this->location,
            'engine_serial_number' => $this->engine_serial_number,
            'kilometer' => $this->kilometer,
            'hours_meter' => $this->hours_meter,
            'brand' => $this->brand,
        ];
        $this->unit = InspectionUnit::firstOrCreate([
            'registration_number' => $this->no_registrasi,
        ], $unit);
    }

    private function getApi($request = [])
    {
        // Simulate API response
        // $api = Http::get('https://api.example.com/unit', [
        //     'no_registrasi' => $this->no_registrasi,
        // ]);
        // if ($api->failed() || $api->status() !== 200 || $api->json('status') !== 'success') {
        //     return $this->addError('no_registrasi', 'No Registrasi tidak ditemukan');
        // }

        if ($this->no_registrasi !== 'R20250804140534') {
            return abort(403, 'No Registrasi tidak ditemukan');
        }

        $this->unitExists = true;

        //For testing
        $this->unit_number = $request['no_unit'] ?? 'ABC1234_A';
        $this->vehicle_type = $request['jenis_kendaraan'] ?? 'TRAILER';
        $this->plate_number = $request['nomor_polisi'] ?? 'BG1234ABC';
        $this->year_manufacture = $request['tahun_pembuatan'] ?? '2014';
        $this->company = $request['perusahaan'] ?? 'PT. Maju Mundur';
        $this->location = $request['lokasi'] ?? 'Muara Enim';
        $this->engine_serial_number = $request['nomor_seri_mesin'] ?? '123456789012345678';
        $this->kilometer = $request['kilometer'] ?? 5000;
        $this->hours_meter = $request['hours_meter'] ?? 5.5;
        $this->brand = $request['brand'] ?? 'HINO';

        $name = fake()->name();
        // $name = 'Rheznendra Praditya';
        $this->name = $request['name'] ?? trim($name);
        $this->username = $request['username'] ?? mb_strtolower(preg_replace('/[^a-z0-9]/i', '', $name));
        $this->author = $request['author'] ?? $this->authorCases[random_int(0, count($this->authorCases) - 1)]->value;
        // $this->author = $request['author'] ?? 'TC';
    }
}
