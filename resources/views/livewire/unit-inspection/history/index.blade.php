<div>
	<!-- HEADER -->
	<x-header title="Inspection History" separator progress-indicator>
		<x-slot:actions>
			<x-button class="btn-primary" label="Filters" @click="$wire.drawer = true" responsive icon="o-funnel" />
		</x-slot:actions>
	</x-header>

	<!-- TABLE  -->
	<x-card>
		<x-table :headers="$headers" :rows="$unitChecked" :sort-by="$sortBy" with-pagination show-empty-text>
			@scope('cell_no', $unit, $unitChecked)
				{{ ($unitChecked->currentPage() - 1) * $unitChecked->perPage() + $loop->index + 1 }}.
			@endscope

			@scope('cell_created_at', $unit)
				<span class="whitespace-nowrap">{{ $unit->created_at->format('d M, Y H:i:s') }}</span>
			@endscope

			@scope('cell_permit', $unit)
				<span class="tooltip whitespace-nowrap" data-tip="{{ $unit->permit->permit->label() }}">
					{{ $unit->permit->permit->shortLabel() }}
				</span>
			@endscope

			@scope('actions', $unit)
				<div class="flex">
					<x-button class="btn-ghost btn-circle text-primary" icon="mdi.file-pdf-box" tooltip="Export PDF" link="{{ route('unit-inspection.history.pdf', $unit->ulid) }}"
						no-wire-navigate />
					<x-button class="btn-ghost btn-circle text-error" icon="mdi.trash-can" tooltip="Delete" wire:click="delete('{{ $unit['ulid'] }}')" spinner="delete" />
				</div>
			@endscope
		</x-table>
	</x-card>

	<!-- FILTER DRAWER -->
	<x-drawer class="w-full lg:w-1/3" title="Filters" wire:model="drawer" right separator with-close-button>
		<x-input label="No Registrasi" wire:model="historyDrawer.no_registrasi" />
		<div class="mt-1 sm:grid sm:grid-cols-2 sm:gap-x-4">
			<x-input label="No Unit" wire:model="historyDrawer.no_unit" />
			<x-input label="Lokasi" wire:model="historyDrawer.lokasi" />
			<x-input label="Jenis Kendaraan" wire:model="historyDrawer.jenis_kendaraan" />
			<x-input label="Nomor Seri Mesin" wire:model="historyDrawer.nomor_seri_mesin" />
			<x-input label="Nomor Polisi" wire:model="historyDrawer.nomor_polisi" />
			<x-input type="number" label="Kilometer" wire:model="historyDrawer.kilometer" />
			<x-choices-offline label="Tahun Pembuatan" wire:model="historyDrawer.tahun_pembuatan" placeholder="Pilih" :options="$yearsRange" option-label="label" option-value="value" single
				searchable clearable />
			<x-input type="number" label="Hours Meter" wire:model="historyDrawer.hours_meter" />
			<x-input label="Perusahaan" wire:model="historyDrawer.perusahaan" />
			<x-input label="Brand" wire:model="historyDrawer.brand" />
			<x-select label="Izin" placeholder="Pilih" wire:model="historyDrawer.permit" :options="$inspectionPermits" option-value="value" option-label="label" />
			<x-datepicker label="Tanggal Inspeksi" placeholder="Pilih" wire:model="historyDrawer.inspection_date" :config="['maxDate' => 'today']" />
		</div>
		<div class="mt-3">
			<x-checkbox label="Include Deleted" wire:model="historyDrawer.withTrashed" />
		</div>
		<x-slot:actions>
			<x-button class="btn-error" label="Reset" icon="o-x-mark" click="clear" spinner />
			<x-button class="btn-primary" label="Cari" icon="s-magnifying-glass" wire:click="search" spinner="search" />
		</x-slot:actions>
	</x-drawer>
</div>

@assets
	{{-- Flatpickr  --}}
	<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
	<script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
@endassets

@script
	<script>
		flatpickr.localize(flatpickr.l10ns.id);
	</script>
@endscript
