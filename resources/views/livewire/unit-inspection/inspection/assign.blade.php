<div class="mt-5 flex flex-col space-y-4 sm:flex-row sm:flex-wrap sm:space-y-0">
	@foreach (\App\Enums\InspectionAuthor::cases() as $label => $enum)
		@if (isset($unitInformation['author']))
			@php
				$owner = \App\Enums\InspectionAuthor::tryFrom($unitInformation['author']) !== $enum;
			@endphp
			<div class="w-full sm:w-auto sm:flex-1 sm:pr-4">
				<x-input :value="!$owner ? $unitInformation['name'] : null" :label="'Petugas Inspeksi (' . $enum->value . ')'" :disabled="$owner" />
			</div>
		@else
			<div class="w-full sm:w-auto sm:flex-1 sm:pr-4">
				<x-input :label="'Petugas Inspeksi (' . $enum->value . ')'" disabled />
			</div>
		@endif
	@endforeach

	<div class="w-full sm:w-auto sm:flex-1 sm:pl-4">
		<x-datepicker wire:model="form.inspection_date" label="Tanggal Inspeksi" icon="o-calendar" :disabled="!isset($unitInformation['author'])" />
	</div>
</div>
