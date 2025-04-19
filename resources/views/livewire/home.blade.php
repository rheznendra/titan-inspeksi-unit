<div>
	<!-- HEADER -->
	<x-header title="Home" separator progress-indicator>
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

			@scope('cell_permit', $unit)
				@if ($unit->permit()->exists() && $unit->permit->permit)
					<span class="tooltip whitespace-nowrap" data-tip="{{ $unit->permit->permit->label() }}">
						{{ $unit->permit->permit->shortLabel() }}
					</span>
				@else
					<span>-</span>
				@endif
			@endscope

			@scope('cell_inspection_date', $unit)
				<span class="whitespace-nowrap">{{ $unit->permit->inspection_date->format('d M, Y') }}</span>
			@endscope

			@scope('cell_tc_filled_at', $unit)
				<span class="whitespace-nowrap">{{ $unit->permit->tc_filled_at?->format('d M, Y H:i:s') ?? '-' }}</span>
			@endscope

			@scope('cell_operation_filled_at', $unit)
				<span class="whitespace-nowrap">{{ $unit->permit->operation_filled_at?->format('d M, Y H:i:s') ?? '-' }}</span>
			@endscope

			@scope('cell_she_filled_at', $unit)
				<span class="whitespace-nowrap">{{ $unit->permit->she_filled_at?->format('d M, Y H:i:s') ?? '-' }}</span>
			@endscope

			@scope('actions', $unit)
				<div class="flex">
					<x-button class="btn-ghost btn-circle text-primary" icon="mdi.file-pdf-box" tooltip="Export PDF" link="{{ route('pdf', $unit->ulid) }}" no-wire-navigate />
					<x-button class="btn-ghost btn-circle text-success" icon="c-eye" tooltip="Lihat Data" link="{{ route('inspection', ['no_registrasi' => $unit->registration_number]) }}" />
				</div>
			@endscope
		</x-table>
	</x-card>

	<!-- FILTER DRAWER -->
	<x-drawer class="w-full lg:w-1/3" title="Filters" wire:model="drawer" right separator with-close-button>
		<x-input label="No Registrasi" wire:model="historyDrawer.no_registrasi" />
		<x-select label="Izin" placeholder="Pilih" wire:model="historyDrawer.permit" :options="$inspectionPermits" option-value="value" option-label="label" />
		<x-datepicker label="Tanggal Inspeksi" placeholder="Pilih" wire:model="historyDrawer.inspection_date" :config="['maxDate' => 'today']" />
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
