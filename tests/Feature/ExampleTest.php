<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Movement;
use App\Services\Contracts\WorkSchedulingServiceContract;
use App\Services\WorkSchedulingService;
use Tests\TestCase;

class ExampleTest extends TestCase
{

    private WorkSchedulingServiceContract $workSchedulingService;


    protected function setUp(): void
    {
        $this->workSchedulingService = app()->make(WorkSchedulingService::class);
        parent::setUp();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testCanGetTime()
    {
        $time = $this->workSchedulingService->calculateTotalWorkingTime(1, 2023, 1);

         dd($time);
    }

    public function test_can_calculate_absened_days()
    {
        $time = $this->workSchedulingService->calculateEmployeeMissedDays();

        dd($time);
    }
}
