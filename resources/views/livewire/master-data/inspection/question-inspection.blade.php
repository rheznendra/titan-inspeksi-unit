<div>
	<!-- HEADER -->
	<x-header title="Question Lists" separator progress-indicator>
		<x-slot:middle class="!justify-end">
			<x-input placeholder="Search..." wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />
		</x-slot:middle>
		<x-slot:actions>
			<x-button class="btn-primary" label="Filters" @click="$wire.drawer = true" responsive icon="o-funnel" />
		</x-slot:actions>
	</x-header>

	<!-- TABLE  -->
	<x-card>
		<x-table :headers="$headers" :rows="$questions" :sort-by="$sortBy" with-pagination>
			@scope('cell_no', $question, $questions)
				{{ ($questions->currentPage() - 1) * $questions->perPage() + $loop->index + 1 }}.
			@endscope

			@scope('cell_owner_id', $question)
				@if ($owner = $question->ownerQuestion)
					<x-badge class="tooltip badge-neutral badge-soft" data-tip="{{ $owner->question }}" :value="$owner->id" />
				@else
					<span>-</span>
				@endif
			@endscope

			@scope('actions', $question)
				<x-button class="btn-ghost btn-sm text-error" icon="o-trash" wire:click="delete({{ $question['id'] }})" spinner />
			@endscope
		</x-table>
	</x-card>

	<!-- FILTER DRAWER -->
	<x-drawer class="lg:w-1/3" title="Filters" wire:model="drawer" right separator with-close-button>
		<x-input placeholder="Search..." wire:model.live.debounce="search" icon="o-magnifying-glass" @keydown.enter="$wire.drawer = false" />

		<x-slot:actions>
			<x-button label="Reset" icon="o-x-mark" wire:click="clear" spinner />
			<x-button class="btn-primary" label="Done" icon="o-check" @click="$wire.drawer = false" />
		</x-slot:actions>
	</x-drawer>
</div>
