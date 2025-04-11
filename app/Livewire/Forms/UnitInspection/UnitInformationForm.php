<?php

namespace App\Livewire\Forms\UnitInspection;

use App\Enums\InspectionAuthor;
use App\Rules\UnitInformation;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UnitInformationForm extends Form
{
    private $authorCases;
    public array $data = [];
    public ?string $no_registrasi = null;

    public function rules($search = true)
    {
        return [
            'no_registrasi' => [$search ? 'required' : 'nullable', 'string', 'max:20', new UnitInformation],
        ];
    }

    public function getUnit(): array
    {
        $this->authorCases = InspectionAuthor::cases();
        $unit = [];
        if ($this->no_registrasi === 'R20250804140534') {
            $unit = [
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
        return $unit;
    }
}
