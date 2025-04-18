@if ($unitInformationForm->unitExists && $unitInformationForm->author === $she)
	@php
		$show = true;
		$alertClass = 'alert-warning';
		if ($unitInformationForm->unit->permit()->doesntExist()) {
		    $alertClass = 'alert-error';
		    $message = 'Formulir belum diisi oleh TC dan Operation';
		} elseif (!$unitInformationForm->unit->permit->filledByTC()->exists()) {
		    $message = 'Formulir belum diisi oleh TC';
		} elseif (!$unitInformationForm->unit->permit->filledByOperation()->exists()) {
		    $message = 'Formulir belum diisi oleh Operation';
		} else {
		    $show = false;
		}
	@endphp
	@if ($show)
		<x-alert @class([$alertClass, 'mb-3']) icon="o-exclamation-triangle">
			<div class="flex flex-col">
				<strong>Perhatian!</strong>
				<ul class="list-disc ps-5">
					<li>{{ $message }}</li>
				</ul>
			</div>
		</x-alert>
	@endif
@endif
