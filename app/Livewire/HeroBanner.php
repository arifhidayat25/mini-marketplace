<?php

namespace App\Livewire;

use App\Models\Banner;
use Livewire\Component;

class HeroBanner extends Component
{
    public $banners = [];

    public function mount()
    {
        $this->banners = Banner::where('is_active', true)->orderBy('order')->get();
    }

    public function render()
    {
        return view('livewire.hero-banner');
    }
}