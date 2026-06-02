<?php

namespace Tests\Feature;

use App\Models\OilCheck;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_form_page_loads_successfully(): void
    {
        $response = $this->get('/');

        $response
            ->assertOk()
            ->assertSee('Oil Change Checker')
            ->assertSee('Current Odometer (km)')
            ->assertSee('Date of Previous Oil Change')
            ->assertSee('Odometer at Previous Oil Change (km)');
    }

    public function test_submission_persists_record_and_redirects_to_unique_result_page(): void
    {
        Carbon::setTestNow('2026-06-01');

        $payload = [
            'current_odometer' => 89500,
            'last_change_odometer' => 84000,
            'last_change_date' => '2025-12-01',
        ];

        $response = $this->post('/check', $payload);

        $oilCheck = OilCheck::query()->latest('id')->first();

        $this->assertNotNull($oilCheck);
        $this->assertSame(89500.0, (float) $oilCheck->current_odometer);
        $this->assertSame(84000.0, (float) $oilCheck->last_change_odometer);
        $this->assertSame('2025-12-01', Carbon::parse($oilCheck->last_change_date)->toDateString());
        $this->assertTrue($oilCheck->needs_change);

        $response->assertRedirect(route('oil-change.result', $oilCheck));

        Carbon::setTestNow();
    }

    public function test_rejects_when_current_odometer_is_less_than_previous_change_odometer(): void
    {
        Carbon::setTestNow('2026-06-01');

        $response = $this->from('/')
            ->post('/check', [
                'current_odometer' => 50000,
                'last_change_odometer' => 51000,
                'last_change_date' => '2026-01-10',
            ]);

        $response
            ->assertRedirect('/')
            ->assertSessionHasErrors([
                'current_odometer' => 'The current odometer must be greater than or equal to the odometer at previous oil change.',
            ]);

        $this->assertDatabaseCount('oil_checks', 0);

        Carbon::setTestNow();
    }

    public function test_rejects_today_as_previous_oil_change_date(): void
    {
        Carbon::setTestNow('2026-06-01');

        $response = $this->from('/')
            ->post('/check', [
                'current_odometer' => 70000,
                'last_change_odometer' => 65000,
                'last_change_date' => '2026-06-01',
            ]);

        $response
            ->assertRedirect('/')
            ->assertSessionHasErrors([
                'last_change_date' => 'The date of previous oil change must be in the past.',
            ]);

        $this->assertDatabaseCount('oil_checks', 0);

        Carbon::setTestNow();
    }

    public function test_exact_thresholds_do_not_mark_due_but_crossing_either_threshold_does(): void
    {
        Carbon::setTestNow('2026-06-01');

        $exactThreshold = $this->post('/check', [
            'current_odometer' => 45000,
            'last_change_odometer' => 40000,
            'last_change_date' => '2025-12-01',
        ]);

        $exactOilCheck = OilCheck::query()->latest('id')->first();
        $this->assertNotNull($exactOilCheck);
        $this->assertFalse($exactOilCheck->needs_change);
        $exactThreshold->assertRedirect(route('oil-change.result', $exactOilCheck));

        $overDistance = $this->post('/check', [
            'current_odometer' => 50001,
            'last_change_odometer' => 45000,
            'last_change_date' => '2025-12-01',
        ]);

        $distanceOilCheck = OilCheck::query()->latest('id')->first();
        $this->assertNotNull($distanceOilCheck);
        $this->assertTrue($distanceOilCheck->needs_change);
        $overDistance->assertRedirect(route('oil-change.result', $distanceOilCheck));

        $overTime = $this->post('/check', [
            'current_odometer' => 50000,
            'last_change_odometer' => 46000,
            'last_change_date' => '2025-11-30',
        ]);

        $timeOilCheck = OilCheck::query()->latest('id')->first();
        $this->assertNotNull($timeOilCheck);
        $this->assertTrue($timeOilCheck->needs_change);
        $overTime->assertRedirect(route('oil-change.result', $timeOilCheck));

        Carbon::setTestNow();
    }

    public function test_result_page_shows_submitted_values_and_reasoning_after_redirect(): void
    {
        Carbon::setTestNow('2026-06-01');

        $postResponse = $this->post('/check', [
            'current_odometer' => 25000,
            'last_change_odometer' => 17000,
            'last_change_date' => '2025-12-01',
        ]);

        $oilCheck = OilCheck::query()->latest('id')->first();
        $this->assertNotNull($oilCheck);

        $postResponse->assertRedirect(route('oil-change.result', $oilCheck));

        $resultResponse = $this->get(route('oil-change.result', $oilCheck));

        $resultResponse
            ->assertOk()
            ->assertSee('Oil Change Required')
            ->assertSee('This vehicle is not within the recommended maintenance interval.')
            ->assertSee('8,000 km driven (limit: 5000 km)')
            ->assertSee('6 months since last service (limit: 6 months)')
            ->assertSee('25,000 km')
            ->assertSee('17,000 km')
            ->assertSee('Dec 01, 2025')
            ->assertSee('Check another vehicle');

        Carbon::setTestNow();
    }
}
