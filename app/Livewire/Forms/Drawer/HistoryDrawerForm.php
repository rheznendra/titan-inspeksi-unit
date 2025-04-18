<?php

namespace App\Livewire\Forms\Drawer;

use Livewire\Form;

class HistoryDrawerForm extends Form
{
    public ?string $no_registrasi = null, $permit = null, $inspection_date = null;
    public bool $withTrashed = false;
}
