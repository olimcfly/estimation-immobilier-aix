<?php
$page_title = 'Quartiers de Lannion - Estimation Immobilière Lannion';

$quartiers = [
    [
        'nom' => 'Centre-Ville',
        'description' => "Le cœur battant de Lannion, entre patrimoine historique, rues animées et offres culturelles. Idéal pour celles et ceux qui recherchent une vie urbaine active.",
        'prix_m2' => 3400,
        'caracteristiques' => ['Commerces', 'Services', 'Écoles', 'Animations'],
        'population' => '~5000 habitants',
        'transports' => 'Gare SNCF, Bus urbains',
        'attractivite' => 'Haute',
        'coords' => '48.7322,-3.4580',
    ],
    [
        'nom' => 'Trégor',
        'description' => 'Quartier résidentiel apprécié pour ses maisons familiales, son calme et ses perspectives ouvertes vers la campagne et le littoral.',
        'prix_m2' => 2800,
        'caracteristiques' => ['Résidentiel', 'Maisons', 'Nature', 'Vue campagne/mer'],
        'population' => '~3500 habitants',
        'transports' => 'Bus de proximité, accès routiers rapides',
        'attractivite' => 'Moyenne à haute',
        'coords' => '48.7279,-3.4710',
    ],
    [
        'nom' => 'Port',
        'description' => 'Secteur emblématique de Lannion, marqué par son histoire portuaire, ses maisons de caractère et ses vues recherchées sur l’eau.',
        'prix_m2' => 3600,
        'caracteristiques' => ['Patrimoine', 'Vue eau', 'Prestige', 'Maisons de caractère'],
        'population' => '~2200 habitants',
        'transports' => 'Accès centre-ville, axes doux piétons/vélos',
        'attractivite' => 'Très haute',
        'coords' => '48.7285,-3.4469',
    ],
    [
        'nom' => 'Brélévenez',
        'description' => 'Quartier perché offrant de belles vues panoramiques, un environnement résidentiel paisible et un cadre patrimonial fort.',
        'prix_m2' => 3100,
        'caracteristiques' => ['Panorama', 'Calme', 'Résidentiel', 'Patrimoine religieux'],
        'population' => '~2800 habitants',
        'transports' => 'Bus urbains, liaison rapide vers le centre',
        'attractivite' => 'Haute',
        'coords' => '48.7401,-3.4518',
    ],
    [
        'nom' => 'Léguer',
        'description' => 'Zone résidentielle péri-urbaine conviviale, adaptée aux familles et bien connectée aux commerces et services essentiels.',
        'prix_m2' => 2900,
        'caracteristiques' => ['Péri-urbain', 'Family friendly', 'Commerces proches', 'Cadre de vie pratique'],
        'population' => '~3200 habitants',
        'transports' => 'Bus, accès routier vers zones d’activités',
        'attractivite' => 'Moyenne',
        'coords' => '48.7214,-3.4652',
    ],
];
?>

<section class="section page-hero">
  <div class="container">
    <div class="page-hero-inner card">
      <p class="eyebrow">
        <i class="fas fa-map-marker-alt"></i> Quartiers de Lannion
      </p>
      <h1>Guide détaillé des quartiers de Lannion</h1>
      <p class="lead">
        Comparez les prix au m², les ambiances de vie et les points forts des principaux quartiers pour affiner votre estimation immobilière.
      </p>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <article class="card" style="padding: 2rem; margin-bottom: 2rem;">
      <h2 style="margin-top: 0;">Carte interactive des quartiers</h2>
      <p style="color: var(--muted); margin-bottom: 1rem;">
        Cliquez sur un quartier pour recentrer la carte Google Maps.
      </p>

      <div style="display: flex; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 1rem;">
        <?php foreach ($quartiers as $index => $quartier): ?>
          <button
            type="button"
            class="btn btn-outline quartier-map-btn"
            data-nom="<?= htmlspecialchars($quartier['nom']); ?>"
            data-coords="<?= htmlspecialchars($quartier['coords']); ?>"
            data-zoom="15"
            style="padding: 0.55rem 1rem;"
          >
            <i class="fas fa-location-arrow"></i> <?= htmlspecialchars($quartier['nom']); ?>
          </button>
        <?php endforeach; ?>
      </div>

      <iframe
        id="google-map-quartiers"
        title="Carte des quartiers de Lannion"
        src="https://maps.google.com/maps?q=48.7322,-3.4580&z=13&output=embed"
        width="100%"
        height="420"
        style="border: 0; border-radius: 14px;"
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
      ></iframe>
    </article>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(270px, 1fr)); gap: 1.2rem;">
      <?php foreach ($quartiers as $quartier): ?>
        <article class="card" style="padding: 1.2rem; display: flex; flex-direction: column; gap: 0.8rem;">
          <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 0.8rem;">
            <h3 style="margin: 0;"><?= htmlspecialchars($quartier['nom']); ?></h3>
            <span style="background: rgba(29, 78, 216, 0.1); color: #1d4ed8; border-radius: 999px; padding: 0.35rem 0.75rem; font-weight: 700; white-space: nowrap;">
              <?= number_format((int) $quartier['prix_m2'], 0, ',', ' '); ?> €/m²
            </span>
          </div>

          <p style="margin: 0; color: var(--muted);"><?= htmlspecialchars($quartier['description']); ?></p>

          <ul style="margin: 0; padding-left: 1.2rem; color: var(--muted);">
            <?php foreach ($quartier['caracteristiques'] as $caracteristique): ?>
              <li><?= htmlspecialchars($caracteristique); ?></li>
            <?php endforeach; ?>
          </ul>

          <div style="display: grid; gap: 0.45rem; font-size: 0.95rem;">
            <p style="margin: 0;"><strong>Population :</strong> <?= htmlspecialchars($quartier['population']); ?></p>
            <p style="margin: 0;"><strong>Transports :</strong> <?= htmlspecialchars($quartier['transports']); ?></p>
            <p style="margin: 0;"><strong>Attractivité :</strong> <?= htmlspecialchars($quartier['attractivite']); ?></p>
          </div>

          <a href="/estimation#form-estimation" class="btn btn-primary" style="margin-top: auto;">
            <i class="fas fa-calculator"></i> Estimer mon bien dans ce quartier
          </a>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <article class="card" style="padding: 2rem;">
      <h2 style="margin-top: 0;">Galerie photos de Lannion</h2>
      <p style="color: var(--muted); margin-bottom: 1rem;">
        Aperçu visuel des ambiances de quartiers entre centre historique, berges et secteurs résidentiels.
      </p>

      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 0.9rem;">
        <figure style="margin: 0;">
          <img src="https://images.unsplash.com/photo-1501854140801-50d01698950b?auto=format&fit=crop&w=1200&q=80" alt="Centre-ville et patrimoine urbain" style="width: 100%; height: 200px; object-fit: cover; border-radius: 12px;">
          <figcaption style="font-size: 0.9rem; color: var(--muted); margin-top: 0.4rem;">Centre-Ville</figcaption>
        </figure>
        <figure style="margin: 0;">
          <img src="https://images.unsplash.com/photo-1470770841072-f978cf4d019e?auto=format&fit=crop&w=1200&q=80" alt="Paysage naturel du Trégor" style="width: 100%; height: 200px; object-fit: cover; border-radius: 12px;">
          <figcaption style="font-size: 0.9rem; color: var(--muted); margin-top: 0.4rem;">Trégor</figcaption>
        </figure>
        <figure style="margin: 0;">
          <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80" alt="Ambiance portuaire et vue sur l'eau" style="width: 100%; height: 200px; object-fit: cover; border-radius: 12px;">
          <figcaption style="font-size: 0.9rem; color: var(--muted); margin-top: 0.4rem;">Port</figcaption>
        </figure>
        <figure style="margin: 0;">
          <img src="https://images.unsplash.com/photo-1469474968028-56623f02e42e?auto=format&fit=crop&w=1200&q=80" alt="Point de vue en hauteur sur Brélévenez" style="width: 100%; height: 200px; object-fit: cover; border-radius: 12px;">
          <figcaption style="font-size: 0.9rem; color: var(--muted); margin-top: 0.4rem;">Brélévenez</figcaption>
        </figure>
        <figure style="margin: 0;">
          <img src="https://images.unsplash.com/photo-1494526585095-c41746248156?auto=format&fit=crop&w=1200&q=80" alt="Quartier résidentiel de Léguer" style="width: 100%; height: 200px; object-fit: cover; border-radius: 12px;">
          <figcaption style="font-size: 0.9rem; color: var(--muted); margin-top: 0.4rem;">Léguer</figcaption>
        </figure>
      </div>
    </article>
  </div>
</section>

<script>
  (function () {
    const mapIframe = document.getElementById('google-map-quartiers');
    const buttons = document.querySelectorAll('.quartier-map-btn');

    if (!mapIframe || !buttons.length) {
      return;
    }

    buttons.forEach((button) => {
      button.addEventListener('click', () => {
        const coords = button.getAttribute('data-coords');
        const zoom = button.getAttribute('data-zoom') || '14';

        if (!coords) {
          return;
        }

        mapIframe.setAttribute('src', `https://maps.google.com/maps?q=${coords}&z=${zoom}&output=embed`);

        buttons.forEach((btn) => btn.classList.remove('active'));
        button.classList.add('active');
      });
    });
  })();
</script>
