<?php
$city = (string) ($estimate['city'] ?? 'Lannion');
$cityLower = mb_strtolower($city);

$estimatedLow = (float) ($estimate['estimated_low'] ?? 0);
$estimatedMid = (float) ($estimate['estimated_mid'] ?? 0);
$estimatedHigh = (float) ($estimate['estimated_high'] ?? 0);
$perSqmLow = (float) ($estimate['per_sqm_low'] ?? 0);
$perSqmMid = (float) ($estimate['per_sqm_mid'] ?? 0);
$perSqmHigh = (float) ($estimate['per_sqm_high'] ?? 0);

$selectedNeighborhood = trim((string) ($_POST['quartier'] ?? $_GET['quartier'] ?? ($estimate['district'] ?? '')));

$neighborhoodDescriptions = [
    'centre-ville' => 'Secteur vivant et commerçant, très recherché pour la proximité immédiate des services.',
    'brélévenez' => 'Quartier résidentiel calme avec bonne tenue des prix sur les maisons familiales.',
    'ker huel' => 'Zone appréciée pour ses accès rapides et son cadre résidentiel équilibré.',
    'servel' => 'Ambiance de quartier avec une demande stable sur les biens bien entretenus.',
    'beg léguer' => 'Secteur côtier premium avec tension forte sur les biens disposant d\'un extérieur.',
];

if ($selectedNeighborhood === '') {
    $selectedNeighborhood = str_contains($cityLower, 'lannion') ? 'Centre-ville' : 'Quartier principal';
}

$neighborhoodKey = mb_strtolower($selectedNeighborhood);
$neighborhoodDescription = $neighborhoodDescriptions[$neighborhoodKey] ?? 'Quartier dynamique avec des transactions régulières sur les biens de qualité.';

$marketPosition = 'moyenne';
if ($perSqmMid < 2800) {
    $marketPosition = 'basse';
} elseif ($perSqmMid > 3600) {
    $marketPosition = 'haute';
}

$marketMessages = [
    'basse' => 'Marché porteur à Lannion. Excellent moment pour vendre!',
    'moyenne' => 'Estimation dans la fourchette de marché locale',
    'haute' => 'Bien situé et bien conservé. Forte demande à Lannion',
];
$marketMessage = $marketMessages[$marketPosition];

$personalAdvice = 'Positionnez votre prix proche de la médiane et préparez un dossier vendeur complet pour accélérer la décision des acquéreurs.';
if ($estimatedMid < 190000) {
    $personalAdvice = 'Misez sur une mise en valeur simple (photos pro, rafraîchissement léger) pour capter rapidement les primo-accédants de Lannion.';
} elseif ($estimatedMid > 330000) {
    $personalAdvice = 'Valorisez les prestations premium (diagnostics à jour, qualité des finitions, extérieurs) pour sécuriser une vente au meilleur prix.';
}

$barMax = max($estimatedHigh, 1);
$lowBar = max(8, (int) round(($estimatedLow / $barMax) * 100));
$midBar = max(8, (int) round(($estimatedMid / $barMax) * 100));
$highBar = max(8, (int) round(($estimatedHigh / $barMax) * 100));
?>

<style>
  .lannion-insights {
    margin-top: 1.2rem;
    display: grid;
    gap: 1rem;
  }

  .insight-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 1rem;
  }

  .bar-chart {
    display: grid;
    gap: 0.85rem;
    margin-top: 0.5rem;
  }

  .bar-row {
    display: grid;
    grid-template-columns: 80px 1fr auto;
    align-items: center;
    gap: 0.8rem;
  }

  .bar-track {
    height: 12px;
    border-radius: 999px;
    background: rgba(15, 23, 42, 0.1);
    overflow: hidden;
  }

  .bar-fill {
    height: 100%;
    border-radius: 999px;
  }

  .bar-fill.low { background: #e24b4a; }
  .bar-fill.mid { background: var(--primary); }
  .bar-fill.high { background: #22c55e; }

  .cta-inline {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.8rem;
    margin-top: 1rem;
  }

  @media (max-width: 720px) {
    .cta-inline {
      grid-template-columns: 1fr;
    }

    .bar-row {
      grid-template-columns: 62px 1fr;
    }

    .bar-row .bar-value {
      grid-column: 1 / -1;
    }
  }
</style>

<section class="estimation-result">
  <div class="container">
    <div class="result-layout">
      <article class="card result-summary">
        <div class="result-header">
          <p class="eyebrow"><i class="fas fa-check-circle"></i> Estimation obtenue</p>
          <h2>Votre estimation à <?= e($city) ?></h2>
          <p class="muted">Voici la fourchette de valeur calculée pour votre bien immobilier.</p>
        </div>

        <div class="kpi-grid">
          <div class="kpi-box kpi-low">
            <p class="kpi-label"><i class="fas fa-arrow-down"></i> Estimation basse</p>
            <p class="kpi-value"><?= number_format($estimatedLow, 0, ',', ' ') ?> €</p>
          </div>
          <div class="kpi-box kpi-mid">
            <p class="kpi-label"><i class="fas fa-bullseye"></i> Estimation moyenne</p>
            <p class="kpi-value"><?= number_format($estimatedMid, 0, ',', ' ') ?> €</p>
          </div>
          <div class="kpi-box kpi-high">
            <p class="kpi-label"><i class="fas fa-arrow-up"></i> Estimation haute</p>
            <p class="kpi-value"><?= number_format($estimatedHigh, 0, ',', ' ') ?> €</p>
          </div>
        </div>

        <div class="result-detail">
          <p class="detail-label">Prix/m² appliqué</p>
          <p class="detail-value"><?= number_format($perSqmMid, 0, ',', ' ') ?> €/m²</p>
          <p class="detail-info">Fourchette : <?= number_format($perSqmLow, 0, ',', ' ') ?> - <?= number_format($perSqmHigh, 0, ',', ' ') ?> €/m²</p>
        </div>

        <div class="lannion-insights">
          <article class="insight-card">
            <p class="detail-label" style="margin-bottom: 0.45rem;">Quartier sélectionné</p>
            <p style="margin: 0 0 0.35rem; font-weight: 700;"><?= e($selectedNeighborhood) ?></p>
            <p class="muted" style="margin: 0; font-size: 0.92rem;"><?= e($neighborhoodDescription) ?></p>
          </article>

          <article class="insight-card">
            <p class="detail-label" style="margin-bottom: 0.45rem;">Graphique estimation</p>
            <div class="bar-chart" aria-label="Graphique d'estimation bas, moyen, haut">
              <div class="bar-row">
                <span>Bas</span>
                <div class="bar-track"><div class="bar-fill low" style="width: <?= $lowBar ?>%"></div></div>
                <span class="bar-value"><?= number_format($estimatedLow, 0, ',', ' ') ?> €</span>
              </div>
              <div class="bar-row">
                <span>Moyen</span>
                <div class="bar-track"><div class="bar-fill mid" style="width: <?= $midBar ?>%"></div></div>
                <span class="bar-value"><?= number_format($estimatedMid, 0, ',', ' ') ?> €</span>
              </div>
              <div class="bar-row">
                <span>Haut</span>
                <div class="bar-track"><div class="bar-fill high" style="width: <?= $highBar ?>%"></div></div>
                <span class="bar-value"><?= number_format($estimatedHigh, 0, ',', ' ') ?> €</span>
              </div>
            </div>
          </article>

          <article class="insight-card">
            <p class="detail-label" style="margin-bottom: 0.45rem;">Comparable local</p>
            <p style="margin: 0;">À Lannion, les biens similaires se vendent entre <strong><?= number_format($estimatedLow, 0, ',', ' ') ?> €</strong> et <strong><?= number_format($estimatedHigh, 0, ',', ' ') ?> €</strong>.</p>
          </article>

          <article class="insight-card">
            <p class="detail-label" style="margin-bottom: 0.45rem;">Conseil personnalisé</p>
            <p style="margin: 0 0 0.5rem;"><strong><?= e($marketMessage) ?></strong></p>
            <p style="margin: 0;" class="muted"><?= e($personalAdvice) ?></p>
          </article>
        </div>
      </article>

      <div class="result-cta-section">
        <article class="card lead-cta">
          <div class="cta-header">
            <p class="eyebrow"><i class="fas fa-handshake"></i> Passer à l'action</p>
            <h3>Transformez cette estimation en projet</h3>
            <p class="muted">Activez la prochaine étape selon votre objectif à Lannion.</p>
          </div>

          <div class="cta-benefits">
            <p class="benefit"><i class="fas fa-check"></i> Analyse personnalisée</p>
            <p class="benefit"><i class="fas fa-check"></i> Positionnement marché local</p>
            <p class="benefit"><i class="fas fa-check"></i> Accompagnement de vente</p>
          </div>

          <div class="cta-inline">
            <a href="#lead-form" class="btn btn-primary btn-full">
              <i class="fas fa-bullseye"></i> Capturer mon lead
            </a>
            <a href="/biens-similaires?ville=<?= urlencode($city) ?>" class="btn btn-secondary btn-full">
              <i class="fas fa-search"></i> Voir les biens similaires
            </a>
          </div>
        </article>
      </div>
    </div>
  </div>
</section>

<section class="lead-section">
  <div class="container">
    <article class="card" id="lead-form">
      <div class="form-header">
        <p class="eyebrow"><i class="fas fa-form"></i> Finalisez votre demande</p>
        <h3>Vos coordonnées pour être rappelé</h3>
        <p class="muted">Nous vous recontacterons dans les 2 heures pour affiner votre stratégie de vente.</p>
      </div>

      <form action="/lead" method="post" class="form-grid form-lead">
        <input type="hidden" name="ville" value="<?= e($city) ?>">
        <input type="hidden" name="estimation" value="<?= e((string) $estimatedMid) ?>">

        <div class="form-section">
          <h4><i class="fas fa-user"></i> Vos informations</h4>

          <div class="form-row">
            <label for="nom">
              <span>Nom complet *</span>
              <input type="text" id="nom" name="nom" placeholder="Jean Dupont" required>
            </label>

            <label for="email">
              <span>Email *</span>
              <input type="email" id="email" name="email" placeholder="jean@example.com" required>
            </label>
          </div>

          <div class="form-row">
            <label for="telephone">
              <span>Téléphone *</span>
              <input type="tel" id="telephone" name="telephone" placeholder="06 12 34 56 78" required>
            </label>

            <label for="nom_contact">
              <span>Préféré pour le contact</span>
              <select id="nom_contact" name="contact_prefere">
                <option value="">-- Choisir --</option>
                <option value="telephone">Téléphone</option>
                <option value="email">Email</option>
                <option value="sms">SMS</option>
              </select>
            </label>
          </div>
        </div>

        <div class="form-section">
          <h4><i class="fas fa-calendar-alt"></i> Votre projet</h4>

          <div class="form-row">
            <label for="urgence">
              <span>Délai de vente *</span>
              <select id="urgence" name="urgence" required>
                <option value="">-- Sélectionner --</option>
                <option value="rapide">Rapide (moins de 3 mois)</option>
                <option value="moyen">Moyen (3-6 mois)</option>
                <option value="long">Long terme (6+ mois)</option>
              </select>
            </label>

            <label for="motivation">
              <span>Raison de la vente *</span>
              <select id="motivation" name="motivation" required>
                <option value="">-- Sélectionner --</option>
                <option value="vente">Vente classique</option>
                <option value="succession">Succession</option>
                <option value="divorce">Divorce/Séparation</option>
                <option value="investissement">Investissement</option>
                <option value="autre">Autre</option>
              </select>
            </label>
          </div>

          <label for="message" class="full-width">
            <span>Message (optionnel)</span>
            <textarea id="message" name="message" placeholder="Parlez-nous de votre projet..." rows="4" style="width: 100%; padding: 0.9rem 1rem; border: 2px solid var(--border); border-radius: 10px; font-family: inherit; resize: vertical;"></textarea>
          </label>
        </div>

        <div class="form-actions">
          <button type="submit" class="btn btn-primary btn-full">
            <i class="fas fa-check"></i> Enregistrer et être recontacté
          </button>
          <p class="form-legal">
            <i class="fas fa-lock"></i> Vos données sont sécurisées et confidentielles. <a href="/mentions-legales">En savoir plus</a>
          </p>
        </div>
      </form>
    </article>
  </div>
</section>
