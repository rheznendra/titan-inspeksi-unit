<?php

namespace App\Livewire\UnitInspection;

use Livewire\WithPagination;
use Livewire\Component;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\UnitChecked;
use Illuminate\Database\QueryException;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Mary\Traits\Toast;

class History extends Component
{
    use Toast, WithPagination;

    public array $sortBy;
    public bool $withDeleted = false;

    public function mount()
    {
        $this->sortBy = [
            'column' => 'created_at',
            'direction' => 'desc',
        ];
    }

    public function delete($ulid)
    {
        LivewireAlert::title('Apakah Anda yakin?')
            ->text('Anda tetap dapat mengembalikan data ini')
            ->asConfirm()
            ->onConfirm('deleteConfirmed', ['ulid' => $ulid])
            ->show();
    }

    public function deleteConfirmed($data)
    {
        $unitChecked = UnitChecked::where('ulid', $data['ulid'])->first();
        if (!$unitChecked) {
            $this->error('Data tidak ditemukan');
            return;
        }
        try {
            $unitChecked->delete();
            $this->success('Data berhasil dihapus');
        } catch (QueryException $e) {
            $this->error('Gagal menghapus data');
        }
    }

    public function headers()
    {
        return [
            ['key' => 'no', 'label' => '#', 'class' => 'w-1', 'sortable' => false],
            ['key' => 'no_registrasi', 'label' => 'No Registrasi', 'class' => 'w-20'],
            ['key' => 'permit', 'label' => 'Izin', 'class' => 'w-20'],
            ['key' => 'inspection_date', 'label' => 'Tanggal Inspeksi', 'class' => 'w-20 text-center'],
            ['key' => 'created_at', 'label' => 'Created At', 'class' => 'w-64 text-center'],
        ];
    }

    public function unitChecked(): LengthAwarePaginator
    {
        return UnitChecked::select('ulid', 'no_registrasi', 'permit', 'inspection_date', 'created_at')
            ->orderBy(...array_values($this->sortBy))
            ->when($this->withDeleted, fn($query) => $query->withTrashed())
            ->paginate();
    }

    public function render()
    {
        return view('livewire.unit-inspection.history', [
            'headers' => $this->headers(),
            'unitChecked' => $this->unitChecked(),
        ]);
    }
}
