<?php

declare(strict_types=1);

namespace App\Services;

final class EstimationService
{
    private ?PerplexityService $perplexityService;

    public function __construct(?PerplexityService $perplexityService = null)
    {
        $this->perplexityService = $perplexityService;
    }

    public function estimate(
        string $city,
        string $propertyType,
        float $surface,
        int $rooms,
        string $quartier = '',
        string $etat = '',
        int $etage = -1,
        int $anneeConstruction = 0,
    ): array {
        $basePerSqm = $this->resolveBasePrice($city, $propertyType);

        $cityFactor = $this->resolveCityFactor($city);
        $typeFactor = $this->resolvePropertyTypeFactor($propertyType);
        $surfaceFactor = $this->resolveSurfaceFactor($surface);
        $roomsFactor = $this->resolveRoomsFactor($rooms);
        $quartierFactor = $this->resolveQuartierFactor($quartier);
        $etatFactor = $this->resolveEtatFactor($etat);
        $etageFactor = $this->resolveEtageFactor($etage, $propertyType);
        $ageFactor = $this->resolveAgeFactor($anneeConstruction);

        $perSqmMid = round(
            $basePerSqm * $cityFactor * $typeFactor * $surfaceFactor * $roomsFactor
            * $quartierFactor * $etatFactor * $etageFactor * $ageFactor,
            2
        );

        $perSqmLow = round($perSqmMid * 0.9, 2);
        $perSqmHigh = round($perSqmMid * 1.1, 2);

        $estimatedLow = round($perSqmLow * $surface, 2);
        $estimatedMid = round($perSqmMid * $surface, 2);
        $estimatedHigh = round($perSqmHigh * $surface, 2);

        return [
            'city' => $city,
            'property_type' => $propertyType,
            'surface' => $surface,
            'rooms' => $rooms,
            'quartier' => $quartier,
            'etat' => $etat,
            'etage' => $etage,
            'annee_construction' => $anneeConstruction,
            'per_sqm_low' => $perSqmLow,
            'per_sqm_mid' => $perSqmMid,
            'per_sqm_high' => $perSqmHigh,
            'estimated_low' => $estimatedLow,
            'estimated_mid' => $estimatedMid,
            'estimated_high' => $estimatedHigh,
        ];
    }

    /**
     * Try to get a market-based price via Perplexity, fallback to configured average.
     */
    private function resolveBasePrice(string $city, string $propertyType): float
    {
        if ($this->perplexityService !== null) {
            try {
                $market = $this->perplexityService->fetchMarketRange($city, $propertyType);
                if (isset($market['mid']) && $market['mid'] > 0) {
                    return (float) $market['mid'];
                }
            } catch (\Throwable) {
                // Fallback to local base
            }
        }

        return defined('PRIX_M2_MOYEN') ? (float) PRIX_M2_MOYEN : 4200.0;
    }

    private function resolveCityFactor(string $city): float
    {
        $cityLower = mb_strtolower($city);

        if (str_contains($cityLower, 'aix')) {
            return 1.0; // Already using Aix base price
        }

        if (str_contains($cityLower, 'paris')) {
            return 2.05;
        }

        if (str_contains($cityLower, 'lyon')) {
            return 1.17;
        }

        if (str_contains($cityLower, 'marseille')) {
            return 0.72;
        }

        if (str_contains($cityLower, 'nice')) {
            return 1.02;
        }

        return 0.87;
    }

    private function resolvePropertyTypeFactor(string $propertyType): float
    {
        $propertyTypeLower = mb_strtolower($propertyType);

        if (str_contains($propertyTypeLower, 'maison') || str_contains($propertyTypeLower, 'villa')) {
            return 1.10;
        }

        if (str_contains($propertyTypeLower, 'studio')) {
            return 1.15;
        }

        if (str_contains($propertyTypeLower, 'loft')) {
            return 1.20;
        }

        if (str_contains($propertyTypeLower, 'terrain')) {
            return 0.35;
        }

        return 1.0; // Appartement par défaut
    }

    private function resolveSurfaceFactor(float $surface): float
    {
        if ($surface < 20) {
            return 1.18;
        }

        if ($surface < 30) {
            return 1.12;
        }

        if ($surface < 50) {
            return 1.05;
        }

        if ($surface > 200) {
            return 0.88;
        }

        if ($surface > 140) {
            return 0.92;
        }

        if ($surface > 100) {
            return 0.96;
        }

        return 1.0;
    }

    private function resolveRoomsFactor(int $rooms): float
    {
        return match (true) {
            $rooms <= 1 => 1.05,
            $rooms === 2 => 1.02,
            $rooms >= 7 => 0.93,
            $rooms >= 6 => 0.95,
            default => 1.0,
        };
    }

    /**
     * Prix au m² par quartier d'Aix-en-Provence (données DVF + notaires 2024).
     */
    private function resolveQuartierFactor(string $quartier): float
    {
        if ($quartier === '') {
            return 1.0;
        }

        $q = mb_strtolower(trim($quartier));

        $factors = [
            'centre historique' => 1.12,
            'mazarin' => 1.18,
            'quartier mazarin' => 1.18,
            'jas de bouffan' => 0.88,
            'pont de l\'arc' => 0.95,
            'pont de larc' => 0.95,
            'les milles' => 0.85,
            'puyricard' => 1.05,
            'luynes' => 0.90,
            'la torse' => 1.08,
            'encagnane' => 0.82,
            'la duranne' => 0.92,
            'meyreuil' => 0.80,
            'le tholonet' => 1.15,
            'saint-mitre' => 0.87,
        ];

        foreach ($factors as $name => $factor) {
            if (str_contains($q, $name)) {
                return $factor;
            }
        }

        return 1.0;
    }

    /**
     * Facteur état du bien.
     */
    private function resolveEtatFactor(string $etat): float
    {
        if ($etat === '') {
            return 1.0;
        }

        $e = mb_strtolower(trim($etat));

        return match (true) {
            str_contains($e, 'neuf') || str_contains($e, 'excellent') => 1.12,
            str_contains($e, 'bon') || str_contains($e, 'rénové') || str_contains($e, 'renove') => 1.05,
            str_contains($e, 'correct') || str_contains($e, 'moyen') => 1.0,
            str_contains($e, 'travaux') || str_contains($e, 'rénover') || str_contains($e, 'renover') => 0.85,
            default => 1.0,
        };
    }

    /**
     * Facteur étage (pour appartements uniquement).
     */
    private function resolveEtageFactor(int $etage, string $propertyType): float
    {
        if ($etage < 0) {
            return 1.0;
        }

        $isAppartement = !str_contains(mb_strtolower($propertyType), 'maison')
            && !str_contains(mb_strtolower($propertyType), 'villa')
            && !str_contains(mb_strtolower($propertyType), 'terrain');

        if (!$isAppartement) {
            return 1.0;
        }

        return match (true) {
            $etage === 0 => 0.95,     // RDC : décote
            $etage === 1 => 0.98,
            $etage >= 5 => 1.08,      // Étages élevés : prime vue
            $etage >= 3 => 1.04,
            default => 1.0,
        };
    }

    /**
     * Facteur ancienneté de construction.
     */
    private function resolveAgeFactor(int $anneeConstruction): float
    {
        if ($anneeConstruction <= 0) {
            return 1.0;
        }

        $currentYear = (int) date('Y');
        $age = $currentYear - $anneeConstruction;

        return match (true) {
            $age <= 2 => 1.10,       // Neuf / VEFA
            $age <= 10 => 1.05,      // Récent
            $age <= 30 => 1.0,       // Standard
            $age <= 50 => 0.97,      // Années 70-90
            $age <= 80 => 0.94,      // Après-guerre
            default => 1.0,          // Ancien / charme (haussmannien, etc.)
        };
    }
}
