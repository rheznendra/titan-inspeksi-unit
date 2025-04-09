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
			@foreach ($questions as $item)
				<tr>
					<td class="border-base-content/15 border text-center">{{ $loop->iteration }}.</td>
					<td class="border-base-content/15 border">{{ $item->question }}</td>
					<td class="border-base-content/15 border text-center">
						<input id="{{ $item->ulid }}_yes" type="radio" value="1" wire:model="form.availability.{{ $item->id }}" @class([
							'radio',
							'radio-error' => $errors->has('form.availability.' . $item->id),
						])
							@disabled(!isset($unitInformation['author'])) />
					</td>
					<td class="border-base-content/15 border text-center">
						<input id="{{ $item->ulid }}_no" type="radio" value="0" wire:model="form.availability.{{ $item->id }}" @class([
							'radio',
							'radio-error' => $errors->has('form.availability.' . $item->id),
						])
							@disabled(!isset($unitInformation['author'])) />
					</td>
					<td class="border-base-content/15 border text-center">
						<input id="{{ $item->ulid }}_good" type="radio" value="1" wire:model="form.condition.{{ $item->id }}" @class([
							'radio',
							'radio-error' => $errors->has('form.condition.' . $item->id),
						])
							@disabled(!isset($unitInformation['author'])) />
					</td>
					<td class="border-base-content/15 border text-center">
						<input id="{{ $item->ulid }}_bad" type="radio" value="0" wire:model="form.condition.{{ $item->id }}" @class([
							'radio',
							'radio-error' => $errors->has('form.condition.' . $item->id),
						]) @disabled(!isset($unitInformation['author'])) />
					</td>
					<td class="border-base-content/15 border">
						<x-input wire:model="form.note.{{ $item->id }}" :disabled="!isset($unitInformation['author'])" />
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
