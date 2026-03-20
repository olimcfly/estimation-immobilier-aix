<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Services\LeadScoringService;
use PHPUnit\Framework\TestCase;

final class LeadScoringServiceTest extends TestCase
{
    private LeadScoringService $service;

    protected function setUp(): void
    {
        $this->service = new LeadScoringService();
    }

    public function testHighBudgetUrgentSaleIsHot(): void
    {
        $score = $this->service->score(500000.0, 'rapide', 'vente');
        $this->assertSame('chaud', $score);
    }

    public function testMediumBudgetMediumUrgencyIsWarm(): void
    {
        $score = $this->service->score(300000.0, 'moyen', 'succession');
        $this->assertSame('tiede', $score);
    }

    public function testLowBudgetSlowCuriosityIsCold(): void
    {
        $score = $this->service->score(100000.0, 'pas pressé', 'curiosité');
        $this->assertSame('froid', $score);
    }

    public function testDivorceMotivationScoresAsHigh(): void
    {
        $score = $this->service->score(450000.0, 'rapide', 'divorce');
        $this->assertSame('chaud', $score);
    }

    public function testBoundaryWarmScore(): void
    {
        // Budget 250k=2 + moyen=2 + curiosité=1 = 5 = warm threshold
        $score = $this->service->score(250000.0, 'moyen', 'curiosité');
        $this->assertSame('tiede', $score);
    }

    public function testBoundaryHotScore(): void
    {
        // Budget 450k=3 + rapide=3 + succession=2 = 8 = hot threshold
        $score = $this->service->score(450000.0, 'rapide', 'succession');
        $this->assertSame('chaud', $score);
    }

    public function testCaseInsensitivity(): void
    {
        $score = $this->service->score(500000.0, 'RAPIDE', 'VENTE');
        $this->assertSame('chaud', $score);
    }
}
