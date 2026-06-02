<?php

namespace Tests\Unit;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    #[DataProvider('dueStatusCases')]
    public function test_due_status_rules(int $kmSinceChange, int $monthsSinceChange, bool $expected): void
    {
        $isDue = $kmSinceChange > 5000 || $monthsSinceChange > 6;

        $this->assertSame($expected, $isDue);
    }

    public static function dueStatusCases(): array
    {
        return [
            'both below threshold' => [
                'kmSinceChange' => 4200,
                'monthsSinceChange' => 4,
                'expected' => false,
            ],
            'exactly at both thresholds' => [
                'kmSinceChange' => 5000,
                'monthsSinceChange' => 6,
                'expected' => false,
            ],
            'distance threshold exceeded' => [
                'kmSinceChange' => 5001,
                'monthsSinceChange' => 2,
                'expected' => true,
            ],
            'time threshold exceeded' => [
                'kmSinceChange' => 1200,
                'monthsSinceChange' => 7,
                'expected' => true,
            ],
        ];
    }
}
