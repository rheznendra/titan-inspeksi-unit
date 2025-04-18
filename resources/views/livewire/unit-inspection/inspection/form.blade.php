@php
	$she = \App\Enums\InspectionAuthor::SHE->value;
@endphp
<div>
	<!-- HEADER -->
	<x-header title="Inspection Form" separator progress-indicator />

	<!-- TABLE  -->
	<x-card separator>
		@include('livewire.unit-inspection.inspection.information')
		<hr class="border-base-content/25 my-5" />
		@include('livewire.unit-inspection.inspection.alert')
		@include('livewire.unit-inspection.inspection.question')
		@include('livewire.unit-inspection.inspection.images')
		@include('livewire.unit-inspection.inspection.permit')
		@include('livewire.unit-inspection.inspection.assign')
		@include('livewire.unit-inspection.inspection.notes')
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
		@php
			$showActions = false;
			if ($unitInformationForm->unitExists) {
			    $permit = $unitInformationForm->unit->permit();
			    if ($unitInformationForm->author !== $she) {
			        $showActions = !$permit->exists() || !$permit->filledBySHE()->exists();
			    } elseif ($permit->exists()) {
			        $showActions = $permit->filledByTC()->filledByOperation()->notFilledBySHE()->exists();
			    }
			}
		@endphp
		@if ($showActions)
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
