<?php
namespace App\Filament\Livewire\Table;

use Livewire\Component;

class GoToPage extends Component
{
    public int $page = 1;

    public function __construct()
    {
        $this->page = (int)($_GET['page'] ?? 1);
    }

    public function render()
    {
        return view('filament.customize.pagination.go-to-page', ['page' => $this->page]);
    }
}
