<?php

namespace App\Livewire\Admin;

use App\Models\Skill;
use App\Services\SkillService;
use Livewire\Component;
use Livewire\WithPagination;

class SkillList extends Component
{
    use WithPagination;

    public $editingId = null;
    public $name = '';
    public $category = '';
    public $search = '';

    private SkillService $skillService;

    public function boot(SkillService $skillService): void
    {
        $this->skillService = $skillService;
    }

    protected $rules = [
        'name' => 'required|string|max:100',
        'category' => 'nullable|string|max:50',
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function create(): void
    {
        abort_unless(auth()->user()->isAdmin(), 403);
        $this->resetForm();
        $this->editingId = 'new';
    }

    public function edit(string $id): void
    {
        abort_unless(auth()->user()->isAdmin(), 403);
        $skill = Skill::findOrFail($id);
        $this->editingId = $id;
        $this->name = $skill->name;
        $this->category = $skill->category;
    }

    public function save(): void
    {
        abort_unless(auth()->user()->isAdmin(), 403);
        $this->validate();

        if ($this->editingId === 'new') {
            $this->skillService->create([
                'name' => $this->name,
                'category' => $this->category ?: null,
            ]);
            $this->dispatch('toast', message: 'Keahlian berhasil ditambahkan.', type: 'success');
        } else {
            $skill = Skill::findOrFail($this->editingId);
            $this->skillService->update($skill, [
                'name' => $this->name,
                'category' => $this->category ?: null,
            ]);
            $this->dispatch('toast', message: 'Keahlian berhasil diperbarui.', type: 'success');
        }

        $this->resetForm();
    }

    public function delete(string $id): void
    {
        abort_unless(auth()->user()->isAdmin(), 403);
        $skill = Skill::findOrFail($id);
        $this->skillService->delete($skill);
        $this->dispatch('toast', message: 'Keahlian berhasil dihapus.', type: 'success');
    }

    public function cancel(): void
    {
        abort_unless(auth()->user()->isAdmin(), 403);
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->editingId = null;
        $this->name = '';
        $this->category = '';
    }

    public function render()
    {
        $skills = $this->skillService->getPaginatedList($this->search);

        return view('livewire.admin.skill-list', compact('skills'));
    }
}