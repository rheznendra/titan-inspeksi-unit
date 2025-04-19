<?php

namespace App\Livewire;

use Mary\Traits\Toast;
use Livewire\WithPagination;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Illuminate\Validation\Rule;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\QueryException;
use App\Models\InspectionUnit;
use App\Livewire\Forms\Drawer\HomeDrawerForm;
use App\Enums\InspectionPermit;

class Home extends Component
{
    use Toast, WithPagination;

    public array $sortBy;
    public bool $drawer = false;
    public HomeDrawerForm $historyDrawerForm;

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
        $unitChecked = InspectionUnit::where('ulid', $data['ulid'])->first();
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

    public function search()
    {
        $this->historyDrawerForm->resetValidation();
        $this->historyDrawerForm->validate([
            'no_registrasi' => 'nullable|string|max:255',
            'permit' => ['nullable', Rule::enum(InspectionPermit::class)],
            'inspection_date' => 'nullable|date_format:Y-m-d',
            'withTrashed' => 'nullable|boolean',
        ]);
        $this->drawer = false;
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
        return InspectionUnit::has('permit')
            ->when($this->historyDrawerForm->no_registrasi, fn($query) => $query->whereLike('no_registrasi', $this->historyDrawerForm->no_registrasi))
            ->when($this->historyDrawerForm->permit, fn($query) => $query->where('permit', $this->historyDrawerForm->permit))
            ->when($this->historyDrawerForm->inspection_date, fn($query) => $query->whereDate('inspection_date', $this->historyDrawerForm->inspection_date))
            ->orderBy(...array_values($this->sortBy))
            ->paginate();
    }

    public function render()
    {
        return view('livewire.home', [
            'headers' => $this->headers(),
            'unitChecked' => $this->unitChecked(),
            'inspectionPermits' => asSelectArray(InspectionPermit::cases()),
        ]);
    }
}
