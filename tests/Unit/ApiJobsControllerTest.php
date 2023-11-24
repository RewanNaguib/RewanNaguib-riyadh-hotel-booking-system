<?php

namespace Tests\Unit;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ApiJobsControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_returns_a_list_of_jobs()
    {
        Job::factory()->count(3)->create();

        $response = $this->get('api/jobs');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['status', 'message', 'data' => [['id', 'title', 'description']]]);
    }

    /** @test */
    public function it_can_accept_job_applications()
    {
        $job = Job::factory()->create();

        Storage::fake('resumes');

        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone_number' => '123456789',
            'cover_letter' => 'This is a cover letter.',
            'resume' => UploadedFile::fake()->create('resume.pdf'),
        ];
        
        $response = $this->post("api/jobs/$job->id", $data);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['status', 'message']);

        $jobApplication = JobApplication::where('job_id', $job->id)->first();

        $this->assertNotNull($jobApplication);
        $this->assertTrue(Storage::disk('resumes')->exists($jobApplication->resume));
    }

    /** @test */
    public function it_validates_job_request_data()
    {
        $job = Job::factory()->create();

        Storage::fake('resumes');

        $data = [
            'phone_number' => '123456789',
            'cover_letter' => 'This is a cover letter.',
        ];
        
        $response = $this->post("api/jobs/$job->id", $data);

        $response->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJsonStructure(['status', 'message', 'errors']);
    }

    /** @test */
    public function it_does_not_accept_invalid_resume_types()
    {
        $job = Job::factory()->create();

        Storage::fake('resumes');

        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone_number' => '123456789',
            'cover_letter' => 'This is a cover letter.',
            'resume' => UploadedFile::fake()->create('resume.png')->mimeType('image/png'),
        ];
        
        $response = $this->post("api/jobs/$job->id", $data);

        $response->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJsonStructure(['status', 'message', 'errors']);
    }
}
