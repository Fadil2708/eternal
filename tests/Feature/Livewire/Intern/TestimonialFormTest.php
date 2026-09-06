<?php

namespace Tests\Feature\Livewire\Intern;

use App\Livewire\Intern\TestimonialForm;
use App\Models\InternProfile;
use App\Models\Internship;
use App\Models\Testimonial;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class TestimonialFormTest extends TestCase
{
    public function test_mount_without_completed_internship(): void
    {
        $intern = User::factory()->intern()->create();

        Livewire::actingAs($intern)
            ->test(TestimonialForm::class)
            ->assertSet('hasCompletedInternship', false)
            ->assertSet('alreadySubmitted', false)
            ->assertSet('rating', 5)
            ->assertSet('content', '');
    }

    public function test_mount_with_completed_internship(): void
    {
        $intern = User::factory()->intern()->create();

        InternProfile::factory()->create([
            'user_id' => $intern->id,
        ]);

        Internship::factory()
            ->completed()
            ->create([
                'intern_id' => $intern->id,
            ]);

        Livewire::actingAs($intern)
            ->test(TestimonialForm::class)
            ->assertSet('hasCompletedInternship', true)
            ->assertSet('alreadySubmitted', false)
            ->assertSet('rating', 5);
    }

    public function test_can_submit_testimonial(): void
    {
        $intern = User::factory()->intern()->create();

        InternProfile::factory()->create([
            'user_id' => $intern->id,
        ]);

        $internship = Internship::factory()
            ->completed()
            ->create([
                'intern_id' => $intern->id,
            ]);

        Livewire::actingAs($intern)
            ->test(TestimonialForm::class)
            ->set('rating', 4)
            ->set(
                'content',
                'Pengalaman magang yang sangat berharga dan menyenangkan.'
            )
            ->call('submit')
            ->assertHasNoErrors()
            ->assertSet('submitted', true);

        $this->assertDatabaseHas('testimonials', [
            'internship_id' => $internship->id,
            'intern_id' => $intern->id,
            'rating' => 4,
            'content' => 'Pengalaman magang yang sangat berharga dan menyenangkan.',
        ]);
    }

    public function test_cannot_submit_without_completed_internship(): void
    {
        $intern = User::factory()->intern()->create();

        InternProfile::factory()->create([
            'user_id' => $intern->id,
        ]);

        Livewire::actingAs($intern)
            ->test(TestimonialForm::class)
            ->set('rating', 4)
            ->set(
                'content',
                'Pengalaman magang yang sangat berharga dan menyenangkan.'
            )
            ->call('submit')
            ->assertHasNoErrors()
            ->assertSet('submitted', false);

        $this->assertDatabaseMissing('testimonials', [
            'intern_id' => $intern->id,
        ]);
    }

    public function test_validation_fails_without_content(): void
    {
        $intern = User::factory()->intern()->create();

        InternProfile::factory()->create([
            'user_id' => $intern->id,
        ]);

        Internship::factory()
            ->completed()
            ->create([
                'intern_id' => $intern->id,
            ]);

        Livewire::actingAs($intern)
            ->test(TestimonialForm::class)
            ->set('rating', 5)
            ->set('content', '')
            ->call('submit')
            ->assertHasErrors([
                'content',
            ]);
    }

    public function test_validation_fails_invalid_rating_below_minimum(): void
    {
        $intern = User::factory()->intern()->create();

        InternProfile::factory()->create([
            'user_id' => $intern->id,
        ]);

        Internship::factory()
            ->completed()
            ->create([
                'intern_id' => $intern->id,
            ]);

        Livewire::actingAs($intern)
            ->test(TestimonialForm::class)
            ->set('rating', 0)
            ->set(
                'content',
                'Pengalaman magang yang sangat berharga dan menyenangkan.'
            )
            ->call('submit')
            ->assertHasErrors([
                'rating',
            ]);
    }

    public function test_validation_fails_invalid_rating_above_maximum(): void
    {
        $intern = User::factory()->intern()->create();

        InternProfile::factory()->create([
            'user_id' => $intern->id,
        ]);

        Internship::factory()
            ->completed()
            ->create([
                'intern_id' => $intern->id,
            ]);

        Livewire::actingAs($intern)
            ->test(TestimonialForm::class)
            ->set('rating', 6)
            ->set(
                'content',
                'Pengalaman magang yang sangat berharga dan menyenangkan.'
            )
            ->call('submit')
            ->assertHasErrors([
                'rating',
            ]);
    }

    public function test_validation_fails_content_over_1000_characters(): void
    {
        $intern = User::factory()->intern()->create();

        InternProfile::factory()->create([
            'user_id' => $intern->id,
        ]);

        Internship::factory()
            ->completed()
            ->create([
                'intern_id' => $intern->id,
            ]);

        Livewire::actingAs($intern)
            ->test(TestimonialForm::class)
            ->set('rating', 5)
            ->set('content', str_repeat('A', 1001))
            ->call('submit')
            ->assertHasErrors([
                'content',
            ]);
    }

    public function test_already_submitted_cannot_create_second_testimonial(): void
    {
        $intern = User::factory()->intern()->create();

        InternProfile::factory()->create([
            'user_id' => $intern->id,
        ]);

        $internship = Internship::factory()
            ->completed()
            ->create([
                'intern_id' => $intern->id,
            ]);

        Testimonial::factory()->create([
            'internship_id' => $internship->id,
            'intern_id' => $intern->id,
            'rating' => 3,
        ]);

        Livewire::actingAs($intern)
            ->test(TestimonialForm::class)
            ->set('rating', 5)
            ->set(
                'content',
                'Testimonial kedua yang seharusnya tidak dibuat.'
            )
            ->call('submit')
            ->assertHasNoErrors()
            ->assertSet('submitted', true);

        $this->assertDatabaseCount('testimonials', 1);

        $this->assertDatabaseHas('testimonials', [
            'intern_id' => $intern->id,
            'rating' => 3,
        ]);
    }

    public function test_mount_detects_existing_testimonial(): void
    {
        $intern = User::factory()->intern()->create();

        InternProfile::factory()->create([
            'user_id' => $intern->id,
        ]);

        $internship = Internship::factory()
            ->completed()
            ->create([
                'intern_id' => $intern->id,
            ]);

        Testimonial::factory()->create([
            'internship_id' => $internship->id,
            'intern_id' => $intern->id,
            'rating' => 3,
        ]);

        Livewire::actingAs($intern)
            ->test(TestimonialForm::class)
            ->assertSet('alreadySubmitted', true)
            ->assertSet('rating', 5);
    }
}