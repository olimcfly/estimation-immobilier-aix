<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Services\EstimationService;
use PHPUnit\Framework\TestCase;

final class EstimationServiceTest extends TestCase
{
    private EstimationService $service;

    protected function setUp(): void
    {
        $this->service = new EstimationService();
    }

    public function testEstimateReturnsAllExpectedKeys(): void
    {
        $result = $this->service->estimate('Lannion', 'Appartement', 80.0, 3);

        $expectedKeys = [
            'city', 'property_type', 'surface', 'rooms',
            'per_sqm_low', 'per_sqm_mid', 'per_sqm_high',
            'estimated_low', 'estimated_mid', 'estimated_high',
        ];

        foreach ($expectedKeys as $key) {
            $this->assertArrayHasKey($key, $result);
        }
    }

    public function testEstimateReturnsCorrectInputValues(): void
    {
        $result = $this->service->estimate('Lannion', 'Appartement', 80.0, 3);

        $this->assertSame('Lannion', $result['city']);
        $this->assertSame('Appartement', $result['property_type']);
        $this->assertSame(80.0, $result['surface']);
        $this->assertSame(3, $result['rooms']);
    }

    public function testEstimateLowLessThanMidLessThanHigh(): void
    {
        $result = $this->service->estimate('Lannion', 'Appartement', 80.0, 3);

        $this->assertLessThan($result['per_sqm_mid'], $result['per_sqm_low']);
        $this->assertLessThan($result['per_sqm_high'], $result['per_sqm_mid']);
        $this->assertLessThan($result['estimated_mid'], $result['estimated_low']);
        $this->assertLessThan($result['estimated_high'], $result['estimated_mid']);
    }

    public function testEstimateHighIsGreaterThanZero(): void
    {
        $result = $this->service->estimate('Lannion', 'Appartement', 80.0, 3);

        $this->assertGreaterThan(0, $result['estimated_low']);
        $this->assertGreaterThan(0, $result['estimated_mid']);
        $this->assertGreaterThan(0, $result['estimated_high']);
    }

    public function testLannionFactorIsApplied(): void
    {
        $lannion = $this->service->estimate('Lannion', 'Appartement', 80.0, 3);
        $generic = $this->service->estimate('Rennes', 'Appartement', 80.0, 3);

        $this->assertLessThan($generic['estimated_mid'], $lannion['estimated_mid']);
    }

    public function testMaisonTypeIsMoreExpensiveThanAppartement(): void
    {
        $appart = $this->service->estimate('Lannion', 'Appartement', 100.0, 4);
        $maison = $this->service->estimate('Lannion', 'Maison', 100.0, 4);

        $this->assertGreaterThan($appart['per_sqm_mid'], $maison['per_sqm_mid']);
    }

    public function testSmallSurfacePremium(): void
    {
        $small = $this->service->estimate('Lannion', 'Appartement', 25.0, 1);
        $normal = $this->service->estimate('Lannion', 'Appartement', 80.0, 3);

        $this->assertGreaterThan($normal['per_sqm_mid'], $small['per_sqm_mid']);
    }

    public function testLargeSurfaceDiscount(): void
    {
        $large = $this->service->estimate('Lannion', 'Appartement', 150.0, 5);
        $normal = $this->service->estimate('Lannion', 'Appartement', 80.0, 3);

        $this->assertLessThan($normal['per_sqm_mid'], $large['per_sqm_mid']);
    }
}
