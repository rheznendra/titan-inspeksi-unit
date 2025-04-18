<div class="border-t-base-content/15 border-t-1 mt-5 flex flex-col pt-3">
	<x-radio :required="$unitInformationForm->unitExists && $unitInformationForm->author === $she" label="Pilih izin sesuai hasil inspeksi:" wire:model.change="form.permit" :options="$inspectionPermits" option-label="label" option-value="value" :disabled="!$unitInformationForm->unitExists ||
	    $unitInformationForm->author !== $she ||
	    $unitInformationForm->unit->permit()->doesntExist() ||
	    $unitInformationForm->unit->permit->filledByTC()->filledByOperation()->doesntExist() ||
	    $unitInformationForm->unit->permit->filledBySHE()->exists()" />

	@if ($form->permit && \App\Enums\InspectionPermit::from($form->permit)->hasNote())
		<div class="mt-3">
			<x-input box-class="mt-3" wire:model="form.permit_note" :disabled="(!$unitInformationForm->unitExists && $unitInformationForm->author === $she) || $unitInformationForm->unit->permit->filledBySHE()->exists()" />
		</div>
	@endif
</div>
