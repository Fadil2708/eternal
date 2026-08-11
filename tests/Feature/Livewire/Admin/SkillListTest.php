<?php

namespace Tests\Feature\Livewire\Admin;

use App\Livewire\Admin\SkillList;
use App\Models\Skill;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class SkillListTest extends TestCase
{
    public function test_admin_can_create_skill(): void
    {
        $admin = User::factory()->admin()->create();

        Livewire::actingAs($admin)
            ->test(SkillList::class)
            ->call('create')
            ->assertSet('editingId', 'new')
            ->set('name', 'Kubernetes')
            ->set('category', 'Programming')
            ->call('save')
            ->assertSet('editingId', null)
            ->assertDispatched('toast');

        $this->assertDatabaseHas('skills', ['name' => 'Kubernetes', 'category' => 'Programming']);
    }

    public function test_admin_can_edit_skill(): void
    {
        $admin = User::factory()->admin()->create();
        $skill = Skill::create(['name' => 'Docker', 'category' => 'Programming']);

        Livewire::actingAs($admin)
            ->test(SkillList::class)
            ->call('edit', $skill->id)
            ->assertSet('editingId', $skill->id)
            ->assertSet('name', 'Docker')
            ->set('category', 'Lainnya')
            ->call('save')
            ->assertDispatched('toast');

        $this->assertDatabaseHas('skills', ['id' => $skill->id, 'category' => 'Lainnya']);
    }

    public function test_admin_can_delete_skill(): void
    {
        $admin = User::factory()->admin()->create();
        $skill = Skill::create(['name' => 'Docker', 'category' => 'Programming']);

        Livewire::actingAs($admin)
            ->test(SkillList::class)
            ->call('delete', $skill->id)
            ->assertDispatched('toast');

        $this->assertDatabaseMissing('skills', ['id' => $skill->id]);
    }

    public function test_non_admin_cannot_save(): void
    {
        $user = User::factory()->intern()->create();

        Livewire::actingAs($user)
            ->test(SkillList::class)
            ->call('create')
            ->assertStatus(403);
    }

    public function test_search_filters_skills(): void
    {
        $admin = User::factory()->admin()->create();
        Skill::create(['name' => 'Laravel', 'category' => 'Programming']);
        Skill::create(['name' => 'Figma', 'category' => 'Design']);

        Livewire::actingAs($admin)
            ->test(SkillList::class)
            ->set('search', 'lara')
            ->assertSee('Laravel')
            ->assertDontSee('Figma');
    }
}
