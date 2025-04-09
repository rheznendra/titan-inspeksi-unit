<div>
	<!-- HEADER -->
	<x-header title="Inspection Form" separator progress-indicator />

	<!-- TABLE  -->
	<x-card separator>
		<x-form wire:submit="searchUnit">
			<x-input label="No Registrasi" wire:model="no_registrasi" autocomplete="off" required clearable>
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
			<x-textarea label="Catatan" wire:model="form.inspection_notes" hint="Max 100 chars" rows="5" :disabled="!isset($unitInformation['author'])" />
		</div>
		@if ($errors->has('form.availability.*') || $errors->has('form.condition.*'))
			<x-alert class="alert-error mt-5" icon="o-exclamation-triangle">
				<strong>Error!</strong>
				<ul>
					@if ($errors->has('form.availability.*'))
						<li>{{ $errors->first('form.availability.*') }}</li>
					@endif
					@if ($errors->has('form.condition.*'))
						<li>{{ $errors->first('form.condition.*') }}</li>
					@endif
				</ul>
			</x-alert>
		@endif
		@if (isset($unitInformation['author']))
			<x-slot:actions>
				<x-button class="btn-error" label="Reset" wire:click="resetForm" />
				<x-button class="btn-primary" type="submit" label="Submit" spinner="save" wire:click="save" />
			</x-slot:actions>
		@endif
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
