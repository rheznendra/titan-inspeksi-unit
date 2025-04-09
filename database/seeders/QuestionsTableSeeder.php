<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $questions = [
            ['question' => 'Seat Belt untuk Sopir'],
            ['question' => 'Seat Belt untuk penumpang'],
            ['question' => 'Stir Mobil'],
            ['question' => 'Rem Kaki'],
            ['question' => 'Rem Tangan/ Rem Parkir'],
            ['question' => 'Klakson'],
            ['question' => 'Kaca Spion Belakang'],
            ['question' => 'Kaca Samping kanan'],
            ['question' => 'Kaca Spion kanan'],
            ['question' => 'Kaca depan'],
            ['question' => 'Kaca samping kiri'],
            ['question' => 'Kaca Spion Kiri'],
            ['question' => 'Kaca belakang'],
            ['question' => 'Tie Rod'],
            ['question' => 'Wiper dan Air wiper'],
            ['question' => 'Strobe Light ( Lampu Sorot )'],
            ['question' => 'Lampu depan Utama'],
            ['question' => 'Lampu Hazard'],
            ['question' => 'Lampu panel'],
            ['question' => 'Rotary Lamp'],
            ['question' => 'Water Truck (Hijau)'],
            ['question' => 'Ambulan,Fire Truck, Lv security (merah)'],
            ['question' => 'Fog Lamp/ Lampu kabut'],
            ['question' => 'Accu'],
            ['question' => 'Tutup Fuel Tank'],
            ['question' => 'Lampu Mundur'],
            ['question' => 'Baut Ban'],
            ['question' => 'Ban Depan'],
            ['question' => 'Ban Belakang'],
            ['question' => 'Ban Cadangan'],
            ['question' => 'Ganjal Ban'],
            ['question' => 'Kebocoran Oil'],
            ['question' => 'Keboroan Air Radiator'],
            ['question' => 'Dinamo Start'],
            ['question' => 'Level Bahan Bakar'],
            ['question' => 'Rambu Dilarang Merokok atau rambu peringatan lainnya'],
            ['question' => 'Side Reflector (water truck,Fuel truck, Lube truck, Bus)'],
            ['question' => 'Air Contioner (pendingin Ruangan)'],
            ['question' => 'Jack /Dongkrak Lengkap'],
            ['question' => 'Level Water Radiator'],
            ['question' => '4 WD'],
            ['question' => 'Kotak P3K'],
            ['question' => 'Level Oil'],
            ['question' => 'Perseneling (Pegangan Gigi)'],
            ['question' => 'Ganjal Ban'],
            ['question' => 'Safety Cone (2 buah)'],
            ['question' => 'Hours Meter'],
            ['question' => '2 X 6 Kg Fire extinguisher (APAR)'],
            ['question' => 'Radio Komunikasi 2 Arah'],
            ['question' => 'Air Contioner (pendingin ruangan)'],
            ['question' => 'Vessel/Bak'],
            ['question' => 'Antena Radio Rig'],
            ['question' => 'Kapasitas isi tangki'],
            ['question' => 'Plakat /Simbol Bahan Cair Mudah Terbakar'],
            ['question' => 'Air pencuci Kaca / Air Weper'],
            ['question' => 'Panel Control'],
            ['question' => 'Kaca film tidak lebih dari 30%'],
            ['question' => 'STNK/Surat Layak Operasi']
        ];

        foreach ($questions as $question) {
            \App\Models\Question::create([
                'question' => $question['question'],
                'author' => fake()->randomElement(\App\Enums\InspectionAuthor::cases())->value,
            ]);
        }
    }
}
