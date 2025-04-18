<div class="border-t-base-content/15 border-t-1 mt-5 flex flex-col">
	<x-textarea label="Catatan" wire:model="form.inspection_notes" hint="Max 3500 chars" rows="5" :disabled="!$unitInformationForm->unitExists ||
	    $unitInformationForm->author !== $she ||
	    $unitInformationForm->unit->permit()->doesntExist() ||
	    $unitInformationForm->unit->permit->filledByTC()->filledByOperation()->doesntExist() ||
	    $unitInformationForm->unit->permit->filledBySHE()->exists()" />
</div>
