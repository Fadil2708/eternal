<?php

namespace App\Livewire\Intern;

use App\Models\Internship;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts::app', ['title' => 'Evaluasi'])]
class EvaluationView extends Component
{
    public $internship = null;

    public function mount(): void
    {
        $this->internship = Internship::with(['evaluation', 'vacancy'])
            ->where('intern_id', auth()->id())
            ->where('status', 'completed')
            ->latest()
            ->first();
    }

    public function render()
    {
        return view('livewire.intern.evaluation-view');
    }
}
