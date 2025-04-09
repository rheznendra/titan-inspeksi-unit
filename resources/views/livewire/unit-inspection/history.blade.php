<div>
	<!-- HEADER -->
	<x-header title="Inspection History" separator progress-indicator>
		<x-slot:middle class="!justify-end">
			<x-input placeholder="Search..." wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />
		</x-slot:middle>
		<x-slot:actions>
			<x-button class="btn-primary" label="Filters" @click="$wire.drawer = true" responsive icon="o-funnel" />
		</x-slot:actions>
	</x-header>

	<!-- TABLE  -->
	<x-card>
		<x-table :headers="$headers" :rows="$unitChecked" :sort-by="$sortBy" with-pagination>
			@scope('cell_no', $unit, $unitChecked)
				{{ ($unitChecked->currentPage() - 1) * $unitChecked->perPage() + $loop->index + 1 }}.
			@endscope

			@scope('cell_created_at', $unit)
				<span class="whitespace-nowrap">{{ $unit->created_at->format('d M, Y H:i:s') }}</span>
			@endscope

			@scope('cell_permit', $unit)
				<span class="whitespace-nowrap">
					{{ $unit->permit->shortLabel() }}
				</span>
			@endscope

			@scope('actions', $unit)
				<div class="flex">
					<x-button class="btn-ghost btn-circle text-primary" icon="mdi.file-pdf-box" tooltip="Export PDF" />
					<x-button class="btn-ghost btn-circle text-error" icon="mdi.trash-can" wire:click="delete('{{ $unit['ulid'] }}')" spinner tooltip="Delete" />
				</div>
			@endscope
		</x-table>
	</x-card>

	<!-- FILTER DRAWER -->
	<x-drawer class="lg:w-1/3" title="Filters" wire:model="drawer" right separator with-close-button>
		<x-input placeholder="Search..." wire:model.live.debounce="search" icon="o-magnifying-glass" @keydown.enter="$wire.drawer = false" />

		<x-slot:actions>
			<x-button label="Reset" icon="o-x-mark" wire:click="clear" spinner />
			<x-button class="btn-primary" label="Done" icon="o-check" @click="$wire.drawer = false" />
		</x-slot:actions>
	</x-drawer>
</div>
