<div class="mt-5 flex flex-col space-y-4 sm:flex-row sm:flex-wrap sm:space-y-0">
	@foreach (\App\Enums\InspectionAuthor::cases() as $label => $enum)
		@php
			$ownerName = strtolower($enum->value) . '_name';
			$isOwner = $unitInformationForm->author === $enum->value;
		@endphp
		@if ($isOwner)
			<div class="w-full sm:w-auto sm:flex-1 sm:pr-4">
				<x-input :value="$isOwner ? $form->{$ownerName} ?? $unitInformationForm->name : null" :label="'Petugas Inspeksi (' . $enum->value . ')'" disabled />
			</div>
		@else
			<div class="w-full sm:w-auto sm:flex-1 sm:pr-4">
				<x-input :value="$form->{$ownerName} ?? null" :label="'Petugas Inspeksi (' . $enum->value . ')'" disabled />
			</div>
		@endif
	@endforeach

	<div class="w-full sm:w-auto sm:flex-1 sm:pl-4">
		<x-datepicker wire:model="form.inspection_date" label="Tanggal Inspeksi" icon="o-calendar" :disabled="!$unitInformationForm->unitExists || $unitInformationForm->unit?->permit?->inspection_date" :required="$unitInformationForm->unitExists && !$unitInformationForm->unit?->permit?->inspection_date" :config="['maxDate' => 'today']" />
	</div>
</div>
