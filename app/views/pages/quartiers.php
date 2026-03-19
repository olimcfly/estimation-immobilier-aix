<?php
$page_title = 'Quartiers de Lannion - Estimation Immobilière Lannion | Guide Détaillé';

$quartiers = [
    [
        'nom' => 'Centre-Ville',
        'description' => "Le cœur battant de Lannion, entre patrimoine historique, rues animées et offres culturelles. Idéal pour celles et ceux qui recherchent une vie urbaine active.",
        'prix_m2' => 3400,
        'prix_moyen' => 425000,
        'caracteristiques' => ['Commerces', 'Services', 'Écoles', 'Animations'],
        'population' => '~5000 habitants',
        'transports' => 'Gare SNCF, Bus urbains',
        'attractivite' => 'Haute',
        'coords' => '48.7322,-3.4580',
        'tendance' => '+5.2%',
    ],
    [
        'nom' => 'Trégor',
        'description' => 'Quartier résidentiel apprécié pour ses maisons familiales, son calme et ses perspectives ouvertes vers la campagne et le littoral.',
        'prix_m2' => 2800,
        'prix_moyen' => 350000,
        'caracteristiques' => ['Résidentiel', 'Maisons', 'Nature', 'Vue campagne/mer'],
        'population' => '~3500 habitants',
        'transports' => 'Bus de proximité, accès routiers rapides',
        'attractivite' => 'Moyenne à haute',
        'coords' => '48.7279,-3.4710',
        'tendance' => '+3.8%',
    ],
    [
        'nom' => 'Port',
        'description' => 'Secteur emblématique de Lannion, marqué par son histoire portuaire, ses maisons de caractère et ses vues recherchées sur l\'eau.',
        'prix_m2' => 3600,
        'prix_moyen' => 480000,
        'caracteristiques' => ['Patrimoine', 'Vue eau', 'Prestige', 'Maisons de caractère'],
        'population' => '~2200 habitants',
        'transports' => 'Accès centre-ville, axes doux piétons/vélos',
        'attractivite' => 'Très haute',
        'coords' => '48.7285,-3.4469',
        'tendance' => '+7.1%',
    ],
    [
        'nom' => 'Brélévenez',
        'description' => 'Quartier perché offrant de belles vues panoramiques, un environnement résidentiel paisible et un cadre patrimonial fort.',
        'prix_m2' => 3100,
        'prix_moyen' => 390000,
        'caracteristiques' => ['Panorama', 'Calme', 'Résidentiel', 'Patrimoine religieux'],
        'population' => '~2800 habitants',
        'transports' => 'Bus urbains, liaison rapide vers le centre',
        'attractivite' => 'Haute',
        'coords' => '48.7401,-3.4518',
        'tendance' => '+4.3%',
    ],
    [
        'nom' => 'Léguer',
        'description' => 'Zone résidentielle péri-urbaine conviviale, adaptée aux familles et bien connectée aux commerces et services essentiels.',
        'prix_m2' => 2900,
        'prix_moyen' => 360000,
        'caracteristiques' => ['Péri-urbain', 'Family friendly', 'Commerces proches', 'Cadre de vie pratique'],
        'population' => '~3200 habitants',
        'transports' => 'Bus, accès routier vers zones d\'activités',
        'attractivite' => 'Moyenne',
        'coords' => '48.7214,-3.4652',
        'tendance' => '+2.5%',
    ],
    [
        'nom' => 'Buttes',
        'description' => 'Quartier mixte offrant un équilibre entre ambiance résidentielle calme et proximité des services urbains.',
        'prix_m2' => 3050,
        'prix_moyen' => 380000,
        'caracteristiques' => ['Mixte', 'Calme', 'Services', 'Accessible'],
        'population' => '~2600 habitants',
        'transports' => 'Bus urbains, accès centre rapide',
        'attractivite' => 'Moyenne à haute',
        'coords' => '48.7350,-3.4600',
        'tendance' => '+3.2%',
    ],
];
?>

<section class="section page-hero">
  <div class="container">
    <div class="page-hero-inner">
      <p class="eyebrow">
        <i class="fas fa-map-marked-alt"></i> Quartiers de Lannion
      </p>
      <h1>Explorez les quartiers de Lannion</h1>
      <p class="lead">
        Comparez les prix au m², les tendances de marché et les points forts de chaque quartier pour affiner votre estimation immobilière.
      </p>
    </div>
  </div>
</section>

<!-- ================================================ -->
<!-- CARTE INTERACTIVE -->
<!-- ================================================ -->
<section class="section section-alt">
  <div class="container">
    <div class="section-heading">
      <p class="eyebrow">
        <i class="fas fa-map-pin"></i> Carte Interactive
      </p>
      <h2>Visualisez les quartiers sur la carte</h2>
    </div>

    <div class="card" style="padding: var(--space-6);">
      <p style="color: var(--text-secondary); margin-bottom: var(--space-4); font-size: var(--size-sm); display: flex; align-items: center; gap: var(--space-2);">
        <i class="fas fa-info-circle"></i> Cliquez sur un quartier pour centrer la carte et découvrir ses caractéristiques.
      </p>

      <div style="display: flex; flex-wrap: wrap; gap: var(--space-3); margin-bottom: var(--space-6);">
        <?php foreach ($quartiers as $index => $quartier): ?>
          <button
            type="button"
            class="btn btn-outline quartier-map-btn"
            data-nom="<?= htmlspecialchars($quartier['nom']); ?>"
            data-coords="<?= htmlspecialchars($quartier['coords']); ?>"
            data-zoom="15"
            data-index="<?= $index; ?>"
          >
            <i class="fas fa-location-dot"></i> <?= htmlspecialchars($quartier['nom']); ?>
          </button>
        <?php endforeach; ?>
      </div>

      <iframe
        id="google-map-quartiers"
        title="Carte des quartiers de Lannion"
        src="https://maps.google.com/maps?q=48.7322,-3.4580&z=13&output=embed"
        width="100%"
        height="480"
        style="border: 0; border-radius: var(--radius-xl); display: block;"
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
      ></iframe>
    </div>
  </div>
</section>

<!-- ================================================ -->
<!-- GRILLE QUARTIERS AVEC STATS -->
<!-- ================================================ -->
<section class="section">
  <div class="container">
    <div class="section-heading">
      <p class="eyebrow">
        <i class="fas fa-chart-bar"></i> Détails par Quartier
      </p>
      <h2>Prix et caractéristiques clés</h2>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: var(--space-6);">
      <?php foreach ($quartiers as $index => $quartier): ?>
        <article class="card quartier-card" data-quartier="<?= htmlspecialchars($quartier['nom']); ?>">
          <!-- En-tête avec prix et tendance -->
          <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: var(--space-3); margin-bottom: var(--space-4); padding-bottom: var(--space-4); border-bottom: 1px solid var(--border-light);">
            <div style="flex: 1;">
              <h3 style="margin: 0 0 var(--space-1) 0; font-size: var(--size-2xl);"><?= htmlspecialchars($quartier['nom']); ?></h3>
              <p style="margin: 0; font-size: var(--size-sm); color: var(--text-muted);">
                <i class="fas fa-users"></i> <?= htmlspecialchars($quartier['population']); ?>
              </p>
            </div>
            <div style="text-align: right;">
              <div style="background: linear-gradient(135deg, rgba(0, 63, 135, 0.1), rgba(255, 215, 0, 0.08)); border-radius: var(--radius-lg); padding: var(--space-3) var(--space-4);">
                <p style="margin: 0; font-weight: 700; font-size: var(--size-lg); color: var(--primary);">
                  <?= number_format((int) $quartier['prix_m2'], 0, ',', ' '); ?> €/m²
                </p>
                <p style="margin: var(--space-1) 0 0 0; font-size: var(--size-xs); color: var(--text-secondary);">
                  <i class="fas fa-arrow-trend-up"></i> <?= htmlspecialchars($quartier['tendance']); ?>
                </p>
              </div>
            </div>
          </div>

          <!-- Description -->
          <p style="color: var(--text-secondary); font-size: var(--size-sm); margin-bottom: var(--space-4); line-height: var(--line-lg);">
            <?= htmlspecialchars($quartier['description']); ?>
          </p>

          <!-- Prix moyen -->
          <div style="background: var(--bg-alt); border-radius: var(--radius-lg); padding: var(--space-3) var(--space-4); margin-bottom: var(--space-4); border-left: 4px solid var(--accent);">
            <p style="margin: 0; font-size: var(--size-xs); color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Prix moyen estimé</p>
            <p style="margin: var(--space-1) 0 0 0; font-family: var(--font-primary); font-size: var(--size-2xl); font-weight: 800; color: var(--primary);">
              <?= number_format((int) $quartier['prix_moyen'], 0, ',', ' '); ?> €
            </p>
          </div>

          <!-- Caractéristiques -->
          <div style="margin-bottom: var(--space-4);">
            <p style="font-size: var(--size-xs); font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted); margin-bottom: var(--space-2);">
              <i class="fas fa-check-circle"></i> Caractéristiques
            </p>
            <div style="display: flex; flex-wrap: wrap; gap: var(--space-2);">
              <?php foreach ($quartier['caracteristiques'] as $caracteristique): ?>
                <span class="badge badge-primary">
                  <?= htmlspecialchars($caracteristique); ?>
                </span>
              <?php endforeach; ?>
            </div>
          </div>

          <!-- Infos détaillées -->
          <div style="display: grid; gap: var(--space-3); font-size: var(--size-sm); margin-bottom: var(--space-4); padding: var(--space-4) 0; border-top: 1px solid var(--border-light); border-bottom: 1px solid var(--border-light);">
            <div style="display: flex; gap: var(--space-3);">
              <span style="color: var(--primary); font-weight: 600; min-width: 120px;">
                <i class="fas fa-bus"></i> Transports
              </span>
              <span style="color: var(--text-secondary);">
                <?= htmlspecialchars($quartier['transports']); ?>
              </span>
            </div>
            <div style="display: flex; gap: var(--space-3);">
              <span style="color: var(--primary); font-weight: 600; min-width: 120px;">
                <i class="fas fa-star"></i> Attractivité
              </span>
              <span style="color: var(--text-secondary);">
                <?= htmlspecialchars($quartier['attractivite']); ?>
              </span>
            </div>
          </div>

          <!-- CTA Bouton -->
          <a href="/estimation#form-estimation" class="btn btn-primary full-width">
            <i class="fas fa-calculator"></i> Estimer mon bien ici
          </a>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ================================================ -->
<!-- COMPARATIF PRIX -->
<!-- ================================================ -->
<section class="section section-alt">
  <div class="container">
    <div class="section-heading">
      <p class="eyebrow">
        <i class="fas fa-chart-line"></i> Comparatif des Prix
      </p>
      <h2>Évolution des prix au m² par quartier</h2>
    </div>

    <div class="card" style="padding: var(--space-8); overflow-x: auto;">
      <table style="width: 100%; border-collapse: collapse; font-size: var(--size-sm);">
        <thead>
          <tr style="border-bottom: 2px solid var(--border);">
            <th style="padding: var(--space-3) var(--space-4); text-align: left; font-weight: 700; color: var(--primary); text-transform: uppercase; letter-spacing: 0.05em;">
              Quartier
            </th>
            <th style="padding: var(--space-3) var(--space-4); text-align: right; font-weight: 700; color: var(--primary); text-transform: uppercase; letter-spacing: 0.05em;">
              Prix/m²
            </th>
            <th style="padding: var(--space-3) var(--space-4); text-align: right; font-weight: 700; color: var(--primary); text-transform: uppercase; letter-spacing: 0.05em;">
              Prix Moyen
            </th>
            <th style="padding: var(--space-3) var(--space-4); text-align: center; font-weight: 700; color: var(--primary); text-transform: uppercase; letter-spacing: 0.05em;">
              Tendance
            </th>
            <th style="padding: var(--space-3) var(--space-4); text-align: center; font-weight: 700; color: var(--primary); text-transform: uppercase; letter-spacing: 0.05em;">
              Dynamisme
            </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($quartiers as $quartier): 
            $prix_m2 = (int) $quartier['prix_m2'];
            $prix_moyen = (int) $quartier['prix_moyen'];
            $tendance = $quartier['tendance'];
            $dynamisme = match(true) {
              str_contains($quartier['attractivite'], 'Très haute') => '★★★★★',
              str_contains($quartier['attractivite'], 'Haute') => '★★★★',
              str_contains($quartier['attractivite'], 'Moyenne à haute') => '★★★★',
              default => '★★★'
            };
          ?>
            <tr style="border-bottom: 1px solid var(--border-light); transition: background var(--trans-fast);" onmouseover="this.style.background='var(--bg-alt)'" onmouseout="this.style.background='transparent'">
              <td style="padding: var(--space-3) var(--space-4); font-weight: 600; color: var(--text);">
                <?= htmlspecialchars($quartier['nom']); ?>
              </td>
              <td style="padding: var(--space-3) var(--space-4); text-align: right; color: var(--primary); font-weight: 700;">
                <?= number_format($prix_m2, 0, ',', ' '); ?> €
              </td>
              <td style="padding: var(--space-3) var(--space-4); text-align: right; color: var(--text-secondary);">
                <?= number_format($prix_moyen, 0, ',', ' '); ?> €
              </td>
              <td style="padding: var(--space-3) var(--space-4); text-align: center;">
                <span style="background: rgba(16, 185, 129, 0.1); color: var(--success); padding: var(--space-2) var(--space-3); border-radius: var(--radius-md); font-weight: 700; font-size: var(--size-xs);">
                  <?= htmlspecialchars($tendance); ?>
                </span>
              </td>
              <td style="padding: var(--space-3) var(--space-4); text-align: center; color: var(--accent); font-weight: 700; font-size: var(--size-sm);">
                <?= $dynamisme; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<!-- ================================================ -->
<!-- GALERIE PHOTOS -->
<!-- ================================================ -->
<section class="section">
  <div class="container">
    <div class="section-heading">
      <p class="eyebrow">
        <i class="fas fa-image"></i> Galerie Visuelle
      </p>
      <h2>Ambiances et paysages de Lannion</h2>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: var(--space-4);">
      <!-- Centre-Ville -->
      <figure style="margin: 0;">
        <div style="position: relative; overflow: hidden; border-radius: var(--radius-xl); height: 240px; background: var(--bg-alt);">
          <img 
            src="https://images.unsplash.com/photo-1511818966892-d7d671e672a2?auto=format&fit=crop&w=500&q=80" 
            alt="Centre-ville de Lannion" 
            style="width: 100%; height: 100%; object-fit: cover; transition: transform var(--trans-base);"
            onmouseover="this.style.transform='scale(1.08)'"
            onmouseout="this.style.transform='scale(1)'"
          >
          <div style="position: absolute; inset: 0; background: linear-gradient(180deg, transparent 50%, rgba(0,0,0,0.4)); border-radius: var(--radius-xl);"></div>
        </div>
        <figcaption style="font-weight: 600; color: var(--text); margin-top: var(--space-2); font-size: var(--size-sm);">
          <i class="fas fa-building"></i> Centre-Ville
        </figcaption>
      </figure>

      <!-- Trégor -->
      <figure style="margin: 0;">
        <div style="position: relative; overflow: hidden; border-radius: var(--radius-xl); height: 240px; background: var(--bg-alt);">
          <img 
            src="https://images.unsplash.com/photo-1470770841072-f978cf4d019e?auto=format&fit=crop&w=500&q=80" 
            alt="Quartier Trégor" 
            style="width: 100%; height: 100%; object-fit: cover; transition: transform var(--trans-base);"
            onmouseover="this.style.transform='scale(1.08)'"
            onmouseout="this.style.transform='scale(1)'"
          >
          <div style="position: absolute; inset: 0; background: linear-gradient(180deg, transparent 50%, rgba(0,0,0,0.4)); border-radius: var(--radius-xl);"></div>
        </div>
        <figcaption style="font-weight: 600; color: var(--text); margin-top: var(--space-2); font-size: var(--size-sm);">
          <i class="fas fa-tree"></i> Trégor
        </figcaption>
      </figure>

      <!-- Port -->
      <figure style="margin: 0;">
        <div style="position: relative; overflow: hidden; border-radius: var(--radius-xl); height: 240px; background: var(--bg-alt);">
          <img 
            src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=500&q=80" 
            alt="Quartier Port de Lannion" 
            style="width: 100%; height: 100%; object-fit: cover; transition: transform var(--trans-base);"
            onmouseover="this.style.transform='scale(1.08)'"
            onmouseout="this.style.transform='scale(1)'"
          >
          <div style="position: absolute; inset: 0; background: linear-gradient(180deg, transparent 50%, rgba(0,0,0,0.4)); border-radius: var(--radius-xl);"></div>
        </div>
        <figcaption style="font-weight: 600; color: var(--text); margin-top: var(--space-2); font-size: var(--size-sm);">
          <i class="fas fa-water"></i> Port
        </figcaption>
      </figure>

      <!-- Brélévenez -->
      <figure style="margin: 0;">
        <div style="position: relative; overflow: hidden; border-radius: var(--radius-xl); height: 240px; background: var(--bg-alt);">
          <img 
            src="https://images.unsplash.com/photo-1469474968028-56623f02e42e?auto=format&fit=crop&w=500&q=80" 
            alt="Brélévenez - vue panoramique" 
            style="width: 100%; height: 100%; object-fit: cover; transition: transform var(--trans-base);"
            onmouseover="this.style.transform='scale(1.08)'"
            onmouseout="this.style.transform='scale(1)'"
          >
          <div style="position: absolute; inset: 0; background: linear-gradient(180deg, transparent 50%, rgba(0,0,0,0.4)); border-radius: var(--radius-xl);"></div>
        </div>
        <figcaption style="font-weight: 600; color: var(--text); margin-top: var(--space-2); font-size: var(--size-sm);">
          <i class="fas fa-mountain"></i> Brélévenez
        </figcaption>
      </figure>

      <!-- Léguer -->
      <figure style="margin: 0;">
        <div style="position: relative; overflow: hidden; border-radius: var(--radius-xl); height: 240px; background: var(--bg-alt);">
          <img 
            src="https://images.unsplash.com/photo-1494526585095-c41746248156?auto=format&fit=crop&w=500&q=80" 
            alt="Quartier résidentiel Léguer" 
            style="width: 100%; height: 100%; object-fit: cover; transition: transform var(--trans-base);"
            onmouseover="this.style.transform='scale(1.08)'"
            onmouseout="this.style.transform='scale(1)'"
          >
          <div style="position: absolute; inset: 0; background: linear-gradient(180deg, transparent 50%, rgba(0,0,0,0.4)); border-radius: var(--radius-xl);"></div>
        </div>
        <figcaption style="font-weight: 600; color: var(--text); margin-top: var(--space-2); font-size: var(--size-sm);">
          <i class="fas fa-home"></i> Léguer
        </figcaption>
      </figure>

      <!-- Buttes -->
      <figure style="margin: 0;">
        <div style="position: relative; overflow: hidden; border-radius: var(--radius-xl); height: 240px; background: var(--bg-alt);">
          <img 
            src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=500&q=80" 
            alt="Quartier Buttes" 
            style="width: 100%; height: 100%; object-fit: cover; transition: transform var(--trans-base);"
            onmouseover="this.style.transform='scale(1.08)'"
            onmouseout="this.style.transform='scale(1)'"
          >
          <div style="position: absolute; inset: 0; background: linear-gradient(180deg, transparent 50%, rgba(0,0,0,0.4)); border-radius: var(--radius-xl);"></div>
        </div>
        <figcaption style="font-weight: 600; color: var(--text); margin-top: var(--space-2); font-size: var(--size-sm);">
          <i class="fas fa-road"></i> Buttes
        </figcaption>
      </figure>
    </div>
  </div>
</section>

<!-- ================================================ -->
<!-- FAQ QUARTIERS -->
<!-- ================================================ -->
<section class="section section-alt">
  <div class="container">
    <div class="section-heading">
      <p class="eyebrow">
        <i class="fas fa-question-circle"></i> Questions Fréquentes
      </p>
      <h2>Vos questions sur les quartiers</h2>
    </div>

    <div class="faq-grid">
      <article class="card faq-card">
        <h3>
          <i class="fas fa-question-circle"></i> Quel est le quartier le plus dynamique ?
        </h3>
        <p>
          Le Port affiche la tendance la plus forte (+7.1%) grâce à sa rénovation urbaine en cours et son attrait pour les investisseurs immobiliers. Centre-Ville et Brélévenez suivent étroitement.
        </p>
      </article>

      <article class="card faq-card">
        <h3>
          <i class="fas fa-question-circle"></i> Quel quartier pour une famille ?
        </h3>
        <p>
          Trégor et Léguer offrent un excellent rapport qualité/prix avec des maisons familiales, des espaces verts et une ambiance calme. Buttes est aussi un bon compromis entre services et tranquillité.
        </p>
      </article>

      <article class="card faq-card">
        <h3>
          <i class="fas fa-question-circle"></i> Où trouver le meilleur investissement ?
        </h3>
        <p>
          Port et Centre-Ville combinent forte attractivité et bonnes perspectives de plusvalue. Les prix au m² y sont plus élevés mais l'évolution positive les justifie.
        </p>
      </article>

      <article class="card faq-card">
        <h3>
          <i class="fas fa-question-circle"></i> Existe-t-il un quartier tranquille et accessible ?
        </h3>
        <p>
          Brélévenez et Buttes incarnent ce balance parfait : cadre résidentiel paisible avec accès rapide aux services du centre-ville via les transports.
        </p>
      </article>

      <article class="card faq-card">
        <h3>
          <i class="fas fa-question-circle"></i> Les prix varient-ils beaucoup d'un quartier à l'autre ?
        </h3>
        <p>
          Oui, de 2 800 €/m² (Trégor) à 3 600 €/m² (Port). L'écart reflète l'attractivité, la proximité des services et le charme du quartier. Tous les prix restent compétitifs pour la région.
        </p>
      </article>

      <article class="card faq-card">
        <h3>
          <i class="fas fa-question-circle"></i> Comment choisir son quartier pour vendre ?
        </h3>
        <p>
          Votre bien s'adapte à un profil de client. Utilisez notre estimation pour connaître le prix du marché, puis explorez les tendances de votre quartier pour fixer le bon prix de vente.
        </p>
      </article>
    </div>
  </div>
</section>

<!-- ================================================ -->
<!-- CTA FINAL -->
<!-- ================================================ -->
<section class="section">
  <div class="container">
    <div class="cta-final card">
      <p class="eyebrow">
        <i class="fas fa-lightbulb"></i> Prêt à connaître la valeur de votre bien ?
      </p>
      <h2>Estimez votre propriété dès maintenant</h2>
      <p class="lead">
        Quel que soit votre quartier, notre outil vous donne une estimation fiable et précise en quelques secondes.
      </p>
      <a href="/estimation#form-estimation" class="btn btn-primary">
        <i class="fas fa-calculator"></i> Commencer une estimation
      </a>
    </div>
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
        const zoom = button.getAttribute('data-zoom') || '15';
        const nom = button.getAttribute('data-nom');

        if (!coords) {
          return;
        }

        // Update map
        mapIframe.setAttribute('src', `https://maps.google.com/maps?q=${coords}&z=${zoom}&output=embed`);

        // Update button states
        buttons.forEach((btn) => btn.classList.remove('active'));
        button.classList.add('active');

        // Smooth scroll to map
        mapIframe.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
      });
    });

    // Set first button as active on load
    if (buttons.length > 0) {
      buttons[0].classList.add('active');
    }
  })();
</script>
