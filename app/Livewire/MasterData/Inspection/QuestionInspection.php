<?php

namespace App\Livewire\MasterData\Inspection;

use App\Models\Question;
use Illuminate\Pagination\LengthAwarePaginator;
use Mary\Traits\Toast;
use Livewire\Component;
use Livewire\WithPagination;

class QuestionInspection extends Component
{
    use Toast, WithPagination;

    public string $search = '';

    public bool $drawer = false;

    public array $sortBy = ['column' => 'created_at', 'direction' => 'asc'];

    // Clear filters
    public function clear(): void
    {
        $this->reset();
        $this->success('Filters cleared.', position: 'toast-bottom');
    }

    // Delete action
    public function delete($id): void
    {
        $this->warning("Will delete #$id", 'It is fake.', position: 'toast-bottom');
    }

    // Table headers
    public function headers(): array
    {
        return [
            ['key' => 'no', 'label' => '#', 'class' => 'w-1', 'sortable' => false],
            ['key' => 'question', 'label' => 'Question', 'class' => 'w-64'],
            ['key' => 'created_at', 'label' => 'Created At', 'class' => 'w-64'],
        ];
    }

    /**
     * For demo purpose, this is a static collection.
     *
     * On real projects you do it with Eloquent collections.
     * Please, refer to maryUI docs to see the eloquent examples.
     */
    public function questions(): LengthAwarePaginator
    {
        return Question::select('id', 'question', 'created_at')
            ->orderBy(...array_values($this->sortBy))
            ->paginate();
    }

    public function render()
    {
        return view('livewire.master-data.inspection.question-inspection', [
            'questions' => $this->questions(),
            'headers' => $this->headers()
        ]);
    }
}
