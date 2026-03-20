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
        if (!defined('PRIX_M2_MOYEN')) {
            define('PRIX_M2_MOYEN', 4800);
        }
        $this->service = new EstimationService();
    }

    public function testEstimateReturnsAllExpectedKeys(): void
    {
        $result = $this->service->estimate('Aix-en-Provence', 'Appartement', 80.0, 3);

        $expectedKeys = [
            'city', 'property_type', 'surface', 'rooms',
            'quartier', 'etat', 'etage', 'annee_construction',
            'per_sqm_low', 'per_sqm_mid', 'per_sqm_high',
            'estimated_low', 'estimated_mid', 'estimated_high',
        ];

        foreach ($expectedKeys as $key) {
            $this->assertArrayHasKey($key, $result);
        }
    }

    public function testEstimateReturnsCorrectInputValues(): void
    {
        $result = $this->service->estimate('Aix-en-Provence', 'Appartement', 80.0, 3);

        $this->assertSame('Aix-en-Provence', $result['city']);
        $this->assertSame('Appartement', $result['property_type']);
        $this->assertSame(80.0, $result['surface']);
        $this->assertSame(3, $result['rooms']);
    }

    public function testEstimateLowLessThanMidLessThanHigh(): void
    {
        $result = $this->service->estimate('Aix-en-Provence', 'Appartement', 80.0, 3);

        $this->assertLessThan($result['per_sqm_mid'], $result['per_sqm_low']);
        $this->assertLessThan($result['per_sqm_high'], $result['per_sqm_mid']);
        $this->assertLessThan($result['estimated_mid'], $result['estimated_low']);
        $this->assertLessThan($result['estimated_high'], $result['estimated_mid']);
    }

    public function testEstimateHighIsGreaterThanZero(): void
    {
        $result = $this->service->estimate('Aix-en-Provence', 'Appartement', 80.0, 3);

        $this->assertGreaterThan(0, $result['estimated_low']);
        $this->assertGreaterThan(0, $result['estimated_mid']);
        $this->assertGreaterThan(0, $result['estimated_high']);
    }

    public function testMaisonTypeIsMoreExpensiveThanAppartement(): void
    {
        $appart = $this->service->estimate('Aix-en-Provence', 'Appartement', 100.0, 4);
        $maison = $this->service->estimate('Aix-en-Provence', 'Maison', 100.0, 4);

        $this->assertGreaterThan($appart['per_sqm_mid'], $maison['per_sqm_mid']);
    }

    public function testSmallSurfacePremium(): void
    {
        $small = $this->service->estimate('Aix-en-Provence', 'Appartement', 25.0, 1);
        $normal = $this->service->estimate('Aix-en-Provence', 'Appartement', 80.0, 3);

        $this->assertGreaterThan($normal['per_sqm_mid'], $small['per_sqm_mid']);
    }

    public function testLargeSurfaceDiscount(): void
    {
        $large = $this->service->estimate('Aix-en-Provence', 'Appartement', 150.0, 5);
        $normal = $this->service->estimate('Aix-en-Provence', 'Appartement', 80.0, 3);

        $this->assertLessThan($normal['per_sqm_mid'], $large['per_sqm_mid']);
    }

    public function testQuartierMazarinPremium(): void
    {
        $mazarin = $this->service->estimate('Aix-en-Provence', 'Appartement', 80.0, 3, 'Mazarin');
        $noQuartier = $this->service->estimate('Aix-en-Provence', 'Appartement', 80.0, 3);

        $this->assertGreaterThan($noQuartier['estimated_mid'], $mazarin['estimated_mid']);
    }

    public function testQuartierJasDeBouffanDiscount(): void
    {
        $jas = $this->service->estimate('Aix-en-Provence', 'Appartement', 80.0, 3, 'Jas de Bouffan');
        $noQuartier = $this->service->estimate('Aix-en-Provence', 'Appartement', 80.0, 3);

        $this->assertLessThan($noQuartier['estimated_mid'], $jas['estimated_mid']);
    }

    public function testEtatNeufPremium(): void
    {
        $neuf = $this->service->estimate('Aix-en-Provence', 'Appartement', 80.0, 3, '', 'Neuf');
        $normal = $this->service->estimate('Aix-en-Provence', 'Appartement', 80.0, 3);

        $this->assertGreaterThan($normal['estimated_mid'], $neuf['estimated_mid']);
    }

    public function testEtatTravauxDiscount(): void
    {
        $travaux = $this->service->estimate('Aix-en-Provence', 'Appartement', 80.0, 3, '', 'À rénover');
        $normal = $this->service->estimate('Aix-en-Provence', 'Appartement', 80.0, 3);

        $this->assertLessThan($normal['estimated_mid'], $travaux['estimated_mid']);
    }

    public function testHighFloorPremiumForAppartement(): void
    {
        $highFloor = $this->service->estimate('Aix-en-Provence', 'Appartement', 80.0, 3, '', '', 6);
        $groundFloor = $this->service->estimate('Aix-en-Provence', 'Appartement', 80.0, 3, '', '', 0);

        $this->assertGreaterThan($groundFloor['estimated_mid'], $highFloor['estimated_mid']);
    }

    public function testFloorFactorIgnoredForMaison(): void
    {
        $maison5 = $this->service->estimate('Aix-en-Provence', 'Maison', 100.0, 4, '', '', 5);
        $maison0 = $this->service->estimate('Aix-en-Provence', 'Maison', 100.0, 4, '', '', 0);

        $this->assertSame($maison5['estimated_mid'], $maison0['estimated_mid']);
    }

    public function testRecentConstructionPremium(): void
    {
        $currentYear = (int) date('Y');
        $recent = $this->service->estimate('Aix-en-Provence', 'Appartement', 80.0, 3, '', '', -1, $currentYear - 1);
        $old = $this->service->estimate('Aix-en-Provence', 'Appartement', 80.0, 3, '', '', -1, $currentYear - 40);

        $this->assertGreaterThan($old['estimated_mid'], $recent['estimated_mid']);
    }
}
