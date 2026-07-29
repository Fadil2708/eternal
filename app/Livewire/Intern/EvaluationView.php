<?php

namespace App\Livewire\Intern;

use App\Models\Evaluation;
use Livewire\Component;

class EvaluationView extends Component
{
    public $internship = null;

    public function mount(): void
    {
        $this->internship = \App\Models\Internship::with(['evaluation', 'vacancy'])
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