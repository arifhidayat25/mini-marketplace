<?php

namespace App\Livewire;

use Livewire\Component;

class SearchBar extends Component
{
    public $search = '';

    public function mount()
    {
        $this->search = request()->query('q', '');
    }

    public function performSearch()
    {
        // Arahkan ke halaman pencarian dengan query
        return $this->redirect(route('search.page', ['q' => $this->search]), navigate: true);
    }

    public function render()
    {
        return view('livewire.search-bar');
    }
}