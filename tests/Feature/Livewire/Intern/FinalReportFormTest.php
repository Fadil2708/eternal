<?php

namespace Tests\Feature\Livewire\Intern;

use App\Livewire\Intern\FinalReportForm;
use App\Models\FinalReport;
use App\Models\InternProfile;
use App\Models\Internship;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Tests\TestCase;

class FinalReportFormTest extends TestCase
{
    public function test_mount_without_active_internship(): void
    {
        $intern = User::factory()->intern()->create();
        InternProfile::factory()->create(['user_id' => $intern->id]);

        Livewire::actingAs($intern)
            ->test(FinalReportForm::class)
            ->assertSet('hasActiveInternship', false);
    }

    public function test_mount_with_active_internship(): void
    {
        $intern = User::factory()->intern()->create();
        InternProfile::factory()->create(['user_id' => $intern->id]);
        Internship::factory()->active()->create(['intern_id' => $intern->id]);

        Livewire::actingAs($intern)
            ->test(FinalReportForm::class)
            ->assertSet('hasActiveInternship', true)
            ->assertSet('canUpload', true);
    }

    public function test_can_upload_report(): void
    {
        $intern = User::factory()->intern()->create();
        InternProfile::factory()->create(['user_id' => $intern->id]);
        $internship = Internship::factory()->active()->create(['intern_id' => $intern->id]);

        $file = UploadedFile::fake()->create('report.pdf', 100);

        Livewire::actingAs($intern)
            ->test(FinalReportForm::class)
            ->set('title', 'Final Report')
            ->set('file', $file)
            ->call('upload');

        $this->assertDatabaseHas('final_reports', [
            'internship_id' => $internship->id,
            'title' => 'Final Report',
            'supervisor_approval' => 'pending',
        ]);
    }

    public function test_cannot_upload_without_file(): void
    {
        $intern = User::factory()->intern()->create();
        InternProfile::factory()->create(['user_id' => $intern->id]);
        Internship::factory()->active()->create(['intern_id' => $intern->id]);

        Livewire::actingAs($intern)
            ->test(FinalReportForm::class)
            ->set('title', 'Final Report')
            ->call('upload')
            ->assertHasErrors(['file']);
    }

    public function test_can_reupload_after_rejection(): void
    {
        $intern = User::factory()->intern()->create();
        InternProfile::factory()->create(['user_id' => $intern->id]);
        $internship = Internship::factory()->active()->create(['intern_id' => $intern->id]);
        FinalReport::factory()->rejected()->create([
            'internship_id' => $internship->id,
            'intern_id' => $intern->id,
        ]);

        Livewire::actingAs($intern)
            ->test(FinalReportForm::class)
            ->assertSet('canUpload', true);
    }

    public function test_cannot_upload_when_pending(): void
    {
        $intern = User::factory()->intern()->create();
        InternProfile::factory()->create(['user_id' => $intern->id]);
        $internship = Internship::factory()->active()->create(['intern_id' => $intern->id]);
        FinalReport::factory()->pending()->create([
            'internship_id' => $internship->id,
            'intern_id' => $intern->id,
        ]);

        Livewire::actingAs($intern)
            ->test(FinalReportForm::class)
            ->assertSet('canUpload', false);
    }

    public function test_upload_validates_file_size(): void
    {
        $intern = User::factory()->intern()->create();
        InternProfile::factory()->create(['user_id' => $intern->id]);
        Internship::factory()->active()->create(['intern_id' => $intern->id]);

        $file = UploadedFile::fake()->create('report.pdf', 25000);

        Livewire::actingAs($intern)
            ->test(FinalReportForm::class)
            ->set('title', 'Final Report')
            ->set('file', $file)
            ->call('upload')
            ->assertHasErrors(['file']);
    }

    public function test_upload_validates_file_type(): void
    {
        $intern = User::factory()->intern()->create();
        InternProfile::factory()->create(['user_id' => $intern->id]);
        Internship::factory()->active()->create(['intern_id' => $intern->id]);

        $file = UploadedFile::fake()->create('report.jpg', 100, 'image/jpeg');

        Livewire::actingAs($intern)
            ->test(FinalReportForm::class)
            ->set('title', 'Final Report')
            ->set('file', $file)
            ->call('upload')
            ->assertHasErrors(['file']);
    }

    public function test_upload_validates_title_required(): void
    {
        $intern = User::factory()->intern()->create();
        InternProfile::factory()->create(['user_id' => $intern->id]);
        Internship::factory()->active()->create(['intern_id' => $intern->id]);

        $file = UploadedFile::fake()->create('report.pdf', 100);

        Livewire::actingAs($intern)
            ->test(FinalReportForm::class)
            ->set('file', $file)
            ->call('upload')
            ->assertHasErrors(['title']);
    }

    public function test_upload_sets_submitted_at(): void
    {
        $intern = User::factory()->intern()->create();
        InternProfile::factory()->create(['user_id' => $intern->id]);
        $internship = Internship::factory()->active()->create(['intern_id' => $intern->id]);

        $file = UploadedFile::fake()->create('report.pdf', 100);

        Livewire::actingAs($intern)
            ->test(FinalReportForm::class)
            ->set('title', 'Final Report')
            ->set('file', $file)
            ->call('upload');

        $report = FinalReport::where('intern_id', $intern->id)->first();

        $this->assertNotNull($report);
        $this->assertNotNull($report->submitted_at);
        $this->assertEquals('pending', $report->supervisor_approval);
        $this->assertNull($report->approved_at);
        $this->assertEquals($internship->id, $report->internship_id);
    }

    public function test_upload_updates_existing_rejected_report(): void
    {
        $intern = User::factory()->intern()->create();
        InternProfile::factory()->create(['user_id' => $intern->id]);
        $internship = Internship::factory()->active()->create(['intern_id' => $intern->id]);
        $oldReport = FinalReport::factory()->rejected()->create([
            'internship_id' => $internship->id,
            'intern_id' => $intern->id,
            'title' => 'Old Title',
        ]);

        $file = UploadedFile::fake()->create('report.pdf', 100);

        Livewire::actingAs($intern)
            ->test(FinalReportForm::class)
            ->set('title', 'Updated Title')
            ->set('file', $file)
            ->call('upload');

        $this->assertDatabaseHas('final_reports', [
            'id' => $oldReport->id,
            'title' => 'Updated Title',
            'supervisor_approval' => 'pending',
        ]);

        $this->assertDatabaseCount('final_reports', 1);
    }
}
