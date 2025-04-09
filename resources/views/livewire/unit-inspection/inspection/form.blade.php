<div>
	<!-- HEADER -->
	<x-header title="Inspection Form" separator progress-indicator />

	<!-- TABLE  -->
	<x-card separator>
		<x-form wire:submit="searchUnit">
			<x-input label="No Registrasi" wire:model="no_registrasi">
				<x-slot:append>
					<x-button class="join-item btn-primary" icon="o-magnifying-glass" wire:click="searchUnit" />
				</x-slot:append>
			</x-input>
			@include('livewire.unit-inspection.inspection.information')
		</x-form>
		@include('livewire.unit-inspection.inspection.question')
		@include('livewire.unit-inspection.inspection.permit')
		@include('livewire.unit-inspection.inspection.assign')
		<div class="border-t-base-content/15 border-t-1 mt-5 flex flex-col">
			<x-textarea label="Catatan" wire:model="form.inspection_notes" hint="Max 100 chars" rows="5" />
		</div>
		<x-slot:actions>
			<x-button class="btn-error" label="Reset" wire:click="resetForm" />
			<x-button class="btn-primary" type="submit" label="Submit" spinner="save" />
		</x-slot:actions>
	</x-card>
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
