<div class="border-t-base-content/15 border-t-1 mt-5 flex flex-col pt-3">
	<x-radio label="Pilih izin sesuai hasil inspeksi:" wire:model.change="form.permit" :options="$inspectionPermits" option-label="label" option-value="value" />
	@if ($this->form->permit && \App\Enums\InspectionPermit::from($this->form->permit)->hasNote())
		<div class="mt-3">
			<x-input box-class="mt-3" wire:model="form.permit_note" />
		</div>
	@endif
</div>
