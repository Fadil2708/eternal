<?php

namespace Tests\Feature\Livewire\Intern;

use App\Livewire\Intern\LogbookForm;
use App\Models\InternProfile;
use App\Models\Internship;
use App\Models\Logbook;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class LogbookFormTest extends TestCase
{
    public function test_mount_without_active_internship(): void
    {
        $intern = User::factory()->intern()->create();

        InternProfile::factory()->create([
            'user_id' => $intern->id,
        ]);

        Livewire::actingAs($intern)
            ->test(LogbookForm::class)
            ->assertSet('hasActiveInternship', false);
    }

    public function test_mount_with_active_internship(): void
    {
        $intern = User::factory()->intern()->create();

        InternProfile::factory()->create([
            'user_id' => $intern->id,
        ]);

        Internship::factory()
            ->active()
            ->create([
                'intern_id' => $intern->id,
            ]);

        Livewire::actingAs($intern)
            ->test(LogbookForm::class)
            ->assertSet('hasActiveInternship', true);
    }

    public function test_can_create_logbook_as_draft(): void
    {
        $intern = User::factory()->intern()->create();

        InternProfile::factory()->create([
            'user_id' => $intern->id,
        ]);

        $internship = Internship::factory()
            ->active()
            ->create([
                'intern_id' => $intern->id,
            ]);

        Livewire::actingAs($intern)
            ->test(LogbookForm::class)
            ->set('activity_date', now()->format('Y-m-d'))
            ->set(
                'activities',
                'Worked on project features for the internship program.'
            )
            ->set('output', 'Completed module')
            ->call('saveAsDraft')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('logbooks', [
            'internship_id' => $internship->id,
            'intern_id' => $intern->id,
            'validation_status' => 'draft',
            'activities' => 'Worked on project features for the internship program.',
            'output' => 'Completed module',
        ]);
    }

    public function test_can_submit_logbook(): void
    {
        $intern = User::factory()->intern()->create();

        InternProfile::factory()->create([
            'user_id' => $intern->id,
        ]);

        $internship = Internship::factory()
            ->active()
            ->create([
                'intern_id' => $intern->id,
            ]);

        Livewire::actingAs($intern)
            ->test(LogbookForm::class)
            ->set('activity_date', now()->format('Y-m-d'))
            ->set(
                'activities',
                'Completed the assigned internship development task.'
            )
            ->set('output', 'Feature completed')
            ->call('submit')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('logbooks', [
            'internship_id' => $internship->id,
            'intern_id' => $intern->id,
            'validation_status' => 'submitted',
        ]);
    }

    public function test_can_edit_logbook_as_draft(): void
    {
        $intern = User::factory()->intern()->create();

        InternProfile::factory()->create([
            'user_id' => $intern->id,
        ]);

        $internship = Internship::factory()
            ->active()
            ->create([
                'intern_id' => $intern->id,
            ]);

        $logbook = Logbook::factory()->create([
            'internship_id' => $internship->id,
            'intern_id' => $intern->id,
            'validation_status' => 'draft',
        ]);

        Livewire::actingAs($intern)
            ->test(LogbookForm::class, [
                'id' => $logbook->id,
            ])
            ->set(
                'activities',
                'Updated activities for the logbook entry.'
            )
            ->set('output', 'Updated output')
            ->call('saveAsDraft')
            ->assertHasNoErrors();

        $this->assertEquals(
            'Updated activities for the logbook entry.',
            $logbook->fresh()->activities
        );

        $this->assertEquals(
            'Updated output',
            $logbook->fresh()->output
        );
    }

    public function test_validation_fails_without_activity_date(): void
    {
        $intern = User::factory()->intern()->create();

        InternProfile::factory()->create([
            'user_id' => $intern->id,
        ]);

        Internship::factory()
            ->active()
            ->create([
                'intern_id' => $intern->id,
            ]);

        Livewire::actingAs($intern)
            ->test(LogbookForm::class)
            ->set('activity_date', '')
            ->set(
                'activities',
                'Worked on an internship project.'
            )
            ->set('output', 'Completed work')
            ->call('saveAsDraft')
            ->assertHasErrors([
                'activity_date',
            ]);
    }

    public function test_validation_fails_without_activities(): void
    {
        $intern = User::factory()->intern()->create();

        InternProfile::factory()->create([
            'user_id' => $intern->id,
        ]);

        Internship::factory()
            ->active()
            ->create([
                'intern_id' => $intern->id,
            ]);

        Livewire::actingAs($intern)
            ->test(LogbookForm::class)
            ->set('activity_date', now()->format('Y-m-d'))
            ->set('activities', '')
            ->set('output', 'Completed output')
            ->call('saveAsDraft')
            ->assertHasErrors([
                'activities',
            ]);
    }

    public function test_validation_fails_without_output(): void
    {
        $intern = User::factory()->intern()->create();

        InternProfile::factory()->create([
            'user_id' => $intern->id,
        ]);

        Internship::factory()
            ->active()
            ->create([
                'intern_id' => $intern->id,
            ]);

        Livewire::actingAs($intern)
            ->test(LogbookForm::class)
            ->set('activity_date', now()->format('Y-m-d'))
            ->set(
                'activities',
                'Worked on an internship project.'
            )
            ->set('output', '')
            ->call('saveAsDraft')
            ->assertHasErrors([
                'output',
            ]);
    }

    public function test_validation_errors_are_detected(): void
    {
        $intern = User::factory()->intern()->create();

        InternProfile::factory()->create([
            'user_id' => $intern->id,
        ]);

        Internship::factory()
            ->active()
            ->create([
                'intern_id' => $intern->id,
            ]);

        Livewire::actingAs($intern)
            ->test(LogbookForm::class)
            ->set('activity_date', '')
            ->set('activities', '')
            ->set('output', '')
            ->call('saveAsDraft')
            ->assertHasErrors([
                'activity_date',
                'activities',
                'output',
            ]);
    }

    public function test_can_create_multiple_logbooks_for_different_dates(): void
    {
        $intern = User::factory()->intern()->create();

        InternProfile::factory()->create([
            'user_id' => $intern->id,
        ]);

        $internship = Internship::factory()
            ->active()
            ->create([
                'intern_id' => $intern->id,
            ]);

        $firstDate = now()->format('Y-m-d');
        $secondDate = now()->addDay()->format('Y-m-d');

        Livewire::actingAs($intern)
            ->test(LogbookForm::class)
            ->set('activity_date', $firstDate)
            ->set(
                'activities',
                'First day internship activities.'
            )
            ->set('output', 'First output')
            ->call('saveAsDraft')
            ->assertHasNoErrors();

        Livewire::actingAs($intern)
            ->test(LogbookForm::class)
            ->set('activity_date', $secondDate)
            ->set(
                'activities',
                'Second day internship activities.'
            )
            ->set('output', 'Second output')
            ->call('saveAsDraft')
            ->assertHasNoErrors();

        $this->assertDatabaseCount('logbooks', 2);

        $this->assertDatabaseHas('logbooks', [
            'internship_id' => $internship->id,
            'activity_date' => $firstDate . ' 00:00:00',
        ]);

        $this->assertDatabaseHas('logbooks', [
            'internship_id' => $internship->id,
            'activity_date' => $secondDate . ' 00:00:00',
        ]);
    }

    public function test_reset_form_restores_default_values(): void
    {
        $intern = User::factory()->intern()->create();

        InternProfile::factory()->create([
            'user_id' => $intern->id,
        ]);

        Internship::factory()
            ->active()
            ->create([
                'intern_id' => $intern->id,
            ]);

        Livewire::actingAs($intern)
            ->test(LogbookForm::class)
            ->set('activity_date', '2026-01-01')
            ->set('activities', 'Some activity')
            ->set('output', 'Some output')
            ->call('resetForm')
            ->assertSet('logbookId', null)
            ->assertSet('activities', '')
            ->assertSet('output', '')
            ->assertSet('validationStatus', 'draft')
            ->assertSet(
                'activity_date',
                now()->format('Y-m-d')
            );
    }
}