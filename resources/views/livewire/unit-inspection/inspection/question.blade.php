<hr class="border-base-content/25 my-5" />
<div class="w-full overflow-x-auto">
	<table class="table-sm table table-auto">
		<thead class="bg-base-content/9 text-base-content text-center">
			<tr class="text-dark border-b-0">
				<th class="border-base-content/25 border" rowspan="2">No</th>
				<th class="border-base-content/25 border" rowspan="2">Deskripsi</th>
				<th class="border-base-content/25 border" colspan="2">Kelengkapan</th>
				<th class="border-base-content/25 border" colspan="2">Kondisi</th>
				<th class="border-base-content/25 w-1/4 border lg:w-1/2" rowspan="2">Keterangan</th>
			</tr>
			<tr>
				<th class="border-base-content/25 border">Ada</th>
				<th class="border-base-content/25 border">Tidak</th>
				<th class="border-base-content/25 border">Baik</th>
				<th class="border-base-content/25 border">Buruk</th>
			</tr>
		</thead>
		<tbody>
			@php
				$iteration = 0;
			@endphp
			@foreach ($questions as $item)
				<tr>
					<td class="border-base-content/15 border text-center">{{ $loop->iteration }}.</td>
					<td class="border-base-content/15 border">{{ $item->question }}</td>
					<td class="border-base-content/15 border text-center">
						<input class="radio" id="{{ $item->ulid }}_yes" type="radio" value="{{ $item->ulid }}_yes" wire:model="form.availability.{{ $iteration }}" />
					</td>
					<td class="border-base-content/15 border text-center">
						<input class="radio" id="{{ $item->ulid }}_no" type="radio" value="{{ $item->ulid }}_no" wire:model="form.availability.{{ $iteration }}" />
					</td>
					<td class="border-base-content/15 border text-center">
						<input class="radio" id="{{ $item->ulid }}_good" type="radio" value="{{ $item->ulid }}_good" wire:model="form.condition.{{ $iteration }}" />
					</td>
					<td class="border-base-content/15 border text-center">
						<input class="radio" id="{{ $item->ulid }}_bad" type="radio" value="{{ $item->ulid }}_bad" wire:model="form.condition.{{ $iteration }}" />
					</td>
					<td class="border-base-content/15 border">
						<x-input wire:model="form.note.{{ $iteration }}" />
					</td>
				</tr>
				@foreach ($item->childQuestions()->get() as $itemChild)
					@php
						$iteration++;
					@endphp
					<tr class="border-0">
						<td class="border-base-content/15 border-x"></td>
						<td class="border-base-content/15 border">{{ $itemChild->question }}</td>
						<td class="border-base-content/15 border text-center">
							<input class="radio" id="{{ $itemChild->ulid }}_yes" type="radio" value="{{ $itemChild->ulid }}_yes" wire:model="form.availability.{{ $iteration }}" />
						</td>
						<td class="border-base-content/15 border text-center">
							<input class="radio" id="{{ $itemChild->ulid }}_no" type="radio" value="{{ $itemChild->ulid }}_no" wire:model="form.availability.{{ $iteration }}" />
						</td>
						<td class="border-base-content/15 border text-center">
							<input class="radio" id="{{ $itemChild->ulid }}_good" type="radio" value="{{ $itemChild->ulid }}_good" wire:model="form.condition.{{ $iteration }}" />
						</td>
						<td class="border-base-content/15 border text-center">
							<input class="radio" id="{{ $itemChild->ulid }}_bad" type="radio" value="{{ $itemChild->ulid }}_bad" wire:model="form.condition.{{ $iteration }}" />
						</td>
						<td class="border-base-content/15 border">
							<x-input wire:model="form.note.{{ $iteration }}" />
						</td>
					</tr>
				@endforeach
				@php
					$iteration++;
				@endphp
			@endforeach
		</tbody>
	</table>
</div>
