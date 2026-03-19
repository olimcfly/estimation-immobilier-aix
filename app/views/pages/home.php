<?php
$cityName = defined('CITY_NAME') ? CITY_NAME : 'Lannion';
$regionName = defined('REGION_NAME') ? REGION_NAME : 'Bretagne';
$prixM2Moyen = defined('PRIX_M2_MOYEN') ? PRIX_M2_MOYEN : 3200;
$heroImageUrl = defined('HERO_IMAGE_URL')
    ? HERO_IMAGE_URL
    : 'https://images.unsplash.com/photo-1489515217757-5fd1be406fef?auto=format&fit=crop&w=1400&q=80';
$heroImageAlt = defined('HERO_IMAGE_ALT')
    ? HERO_IMAGE_ALT
    : 'Vue côtière du Trégor près de Lannion';
$featuredDistricts = defined('FEATURED_DISTRICTS') && is_array(FEATURED_DISTRICTS)
    ? FEATURED_DISTRICTS
    : ['Centre-Ville', 'Trégor', 'Port'];

$page_title = sprintf('Estimation Immobilière %s | Évaluez Votre Bien en 1 Minute', $cityName);
?>

<!-- ================================================ -->
<!-- HERO ULTRA-PREMIUM -->
<!-- ================================================ -->
<section class="section page-hero">
  <div class="container">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-8); align-items: center;">
      
      <!-- COLONNE GAUCHE: HEADLINE + COPY -->
      <div>
        <!-- Badge -->
        <p class="eyebrow">
          <i class="fas fa-certificate"></i> Estimation certifiée • Données 2024
        </p>

        <!-- H1 Principal -->
        <h1>
          Estimez votre bien immobilier à <?= htmlspecialchars($cityName); ?>
        </h1>

        <!-- Subheadline -->
        <p class="lead" style="margin-bottom: var(--space-6); color: rgba(255,255,255,0.85);">
          Découvrez la vraie valeur de votre propriété en moins d'une minute. Analyse précise basée sur 5000+ transactions réelles de votre région.
        </p>

        <!-- Image Hero -->
        <figure style="margin: var(--space-6) 0; border-radius: var(--radius-xl); overflow: hidden; border: 2px solid var(--accent); box-shadow: var(--shadow-lg);">
          <img 
            src="<?= htmlspecialchars($heroImageUrl); ?>" 
            alt="<?= htmlspecialchars($heroImageAlt); ?>" 
            style="width: 100%; height: auto; display: block; aspect-ratio: 16 / 9; object-fit: cover; transition: transform var(--trans-slow);"
            onmouseover="this.style.transform='scale(1.03)'"
            onmouseout="this.style.transform='scale(1)'"
          >
        </figure>

        <!-- Description -->
        <p style="margin-bottom: var(--space-6); line-height: var(--line-lg); color: rgba(255,255,255,0.85);">
          De <?= htmlspecialchars($featuredDistricts[0] ?? ''); ?> au cœur de la ville jusqu'aux hauteurs de <?= htmlspecialchars($featuredDistricts[2] ?? ''); ?>, nos estimations couvrent toute la zone de <?= htmlspecialchars($cityName); ?> et région.
        </p>

        <!-- Stat clé -->
        <div style="background: rgba(255,255,255,0.1); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.15); border-radius: var(--radius-lg); padding: var(--space-4); margin-bottom: var(--space-6);">
          <p style="font-size: var(--size-xs); color: var(--accent); text-transform: uppercase; font-weight: 600; margin-bottom: var(--space-2);">
            <i class="fas fa-chart-line"></i> Prix moyen constaté
          </p>
          <p style="font-family: var(--font-primary); font-size: var(--size-3xl); font-weight: 800; color: #fff; margin-bottom: 0;">
            <?= number_format((int) $prixM2Moyen, 0, ',', ' '); ?>€ / m²
          </p>
        </div>

        <!-- Trust Indicators -->
        <div style="display: flex; flex-direction: column; gap: var(--space-3); margin-bottom: var(--space-6); color: rgba(255,255,255,0.9);">
          <div style="display: flex; align-items: center; gap: var(--space-2);">
            <i class="fas fa-check-circle" style="color: var(--accent);"></i>
            <span>
              <strong><?= htmlspecialchars($featuredDistricts[0] ?? ''); ?></strong> • Quartier central très prisé
            </span>
          </div>
          <div style="display: flex; align-items: center; gap: var(--space-2);">
            <i class="fas fa-check-circle" style="color: var(--accent);"></i>
            <span>
              <strong><?= htmlspecialchars($featuredDistricts[1] ?? ''); ?></strong> • Ambiance littorale recherchée
            </span>
          </div>
          <div style="display: flex; align-items: center; gap: var(--space-2);">
            <i class="fas fa-check-circle" style="color: var(--accent);"></i>
            <span>
              <strong><?= htmlspecialchars($featuredDistricts[2] ?? ''); ?></strong> • Secteur patrimoine en hausse
            </span>
          </div>
        </div>

        <!-- Social Proof -->
        <div style="background: rgba(255,255,255,0.08); border-left: 4px solid var(--accent); border-radius: var(--radius-lg); padding: var(--space-4); margin-bottom: var(--space-6);">
          <p style="margin-bottom: var(--space-2); font-size: var(--size-xs); color: var(--accent); text-transform: uppercase; font-weight: 600; letter-spacing: 0.05em;">
            <i class="fas fa-quote-left"></i> Témoignage client
          </p>
          <p style="margin-bottom: var(--space-3); font-style: italic; line-height: var(--line-lg); color: rgba(255,255,255,0.9);">
            "L'estimation était très proche de l'offre reçue. Super rapide et fiable. Je recommande !"
          </p>
          <p style="margin-bottom: 0; font-size: var(--size-sm); color: rgba(255,255,255,0.6); font-weight: 600;">
            — Propriétaire • <?= htmlspecialchars($cityName); ?>
          </p>
        </div>

        <!-- Boutons CTA -->
        <div style="display: flex; gap: var(--space-4); flex-wrap: wrap;">
          <a href="#form-estimation" class="btn btn-primary">
            <i class="fas fa-bolt"></i> Estimer gratuitement
          </a>
          <a href="#how-it-works" class="btn btn-outline">
            <i class="fas fa-info-circle"></i> Comment ça marche
          </a>
        </div>
      </div>

      <!-- COLONNE DROITE: FORMULAIRE HERO -->
      <aside class="card" id="form-estimation" style="padding: var(--space-8); position: sticky; top: 100px; height: fit-content;">
        <!-- En-tête -->
        <h2 style="margin-bottom: var(--space-2); display: flex; align-items: center; gap: var(--space-2);">
          <i class="fas fa-calculator" style="color: var(--primary);"></i> Estimation gratuite
        </h2>
        <p style="margin-bottom: var(--space-6); color: var(--text-secondary); font-size: var(--size-sm);">
          Remplissez les infos de votre bien pour obtenir votre fourchette de prix estimée en 60 secondes.
        </p>

        <!-- Formulaire -->
        <form action="/estimation" method="post" class="form-grid" style="gap: var(--space-3);">
          
          <!-- Ville -->
          <label for="city" class="full-width">
            <span>
              <i class="fas fa-map-marker-alt"></i> Ville *
            </span>
            <input 
              type="text" 
              id="city" 
              name="city" 
              placeholder="<?= htmlspecialchars($cityName); ?>, Perros-Guirec..." 
              required
            >
          </label>

          <!-- Code postal -->
          <label for="postal_code" class="full-width">
            <span>
              <i class="fas fa-envelope"></i> Code postal *
            </span>
            <input 
              type="text" 
              id="postal_code" 
              name="postal_code" 
              placeholder="22300" 
              maxlength="5"
              required
            >
          </label>

          <!-- Type de bien -->
          <label for="property_type" class="full-width">
            <span>
              <i class="fas fa-home"></i> Type de bien *
            </span>
            <select id="property_type" name="property_type" required>
              <option value="">-- Sélectionner --</option>
              <option value="apartment">Appartement</option>
              <option value="house">Maison / Villa</option>
              <option value="studio">Studio</option>
              <option value="loft">Loft</option>
              <option value="townhouse">Maison de ville</option>
            </select>
          </label>

          <!-- Surface -->
          <label for="surface" class="full-width">
            <span>
              <i class="fas fa-ruler-combined"></i> Surface (m²) *
            </span>
            <input 
              type="number" 
              id="surface" 
              name="surface" 
              min="10" 
              max="500" 
              step="0.1"
              placeholder="85" 
              required
            >
          </label>

          <!-- Pièces -->
          <label for="rooms" class="full-width">
            <span>
              <i class="fas fa-door-open"></i> Pièces *
            </span>
            <input 
              type="number" 
              id="rooms" 
              name="rooms" 
              min="1" 
              max="10"
              placeholder="3" 
              required
            >
          </label>

          <!-- Année construction -->
          <label for="year_built" class="full-width">
            <span>
              <i class="fas fa-calendar"></i> Année construction *
            </span>
            <input 
              type="number" 
              id="year_built" 
              name="year_built" 
              min="1850" 
              max="2024"
              placeholder="2005" 
              required
            >
          </label>

          <!-- Étage -->
          <label for="floor" class="full-width">
            <span>
              <i class="fas fa-building"></i> Étage *
            </span>
            <select id="floor" name="floor" required>
              <option value="">-- Sélectionner --</option>
              <option value="0">Rez-de-chaussée</option>
              <option value="1">1er étage</option>
              <option value="2">2e étage</option>
              <option value="3">3e étage</option>
              <option value="4">4e étage</option>
              <option value="5plus">5+ étages</option>
            </select>
          </label>

          <!-- État général -->
          <label for="condition" class="full-width">
            <span>
              <i class="fas fa-tools"></i> État général *
            </span>
            <select id="condition" name="condition" required>
              <option value="">-- Sélectionner --</option>
              <option value="excellent">Excellent (neuf/rénové)</option>
              <option value="good">Bon (entretenu)</option>
              <option value="fair">Moyen (travaux à prévoir)</option>
              <option value="poor">Mauvais (gros travaux)</option>
            </select>
          </label>

          <!-- Chambres -->
          <label for="bedrooms">
            <span>
              <i class="fas fa-bed"></i> Chambres
            </span>
            <input 
              type="number" 
              id="bedrooms" 
              name="bedrooms" 
              min="0" 
              max="10"
              placeholder="2"
            >
          </label>

          <!-- Salles de bain -->
          <label for="bathrooms">
            <span>
              <i class="fas fa-bath"></i> Salles de bain
            </span>
            <input 
              type="number" 
              id="bathrooms" 
              name="bathrooms" 
              min="0" 
              max="5"
              placeholder="1"
            >
          </label>

          <!-- Bouton de soumission -->
          <button type="submit" class="btn btn-primary full-width" style="margin-top: var(--space-2);">
            <i class="fas fa-bolt"></i> Obtenir mon estimation
          </button>

          <!-- Reassurance -->
          <p class="text-center text-muted" style="font-size: var(--size-xs); margin-top: var(--space-3); margin-bottom: 0;">
            <i class="fas fa-check-circle"></i> Gratuit •
            <i class="fas fa-zap"></i> 60 secondes •
            <i class="fas fa-lock"></i> Sécurisé
          </p>
        </form>
      </aside>
    </div>
  </div>
</section>

<!-- ================================================ -->
<!-- PROCESSUS EXPLICITE -->
<!-- ================================================ -->
<section class="section section-alt" id="how-it-works">
  <div class="container">
    <div class="section-heading">
      <p class="eyebrow">
        <i class="fas fa-bolt"></i> Processus rapide
      </p>
      <h2>Comment fonctionne l'estimation ?</h2>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: var(--space-6);">
      <!-- Étape 1 -->
      <article class="card feature-card">
        <div class="feature-icon">
          <i class="fas fa-edit"></i>
        </div>
        <div style="font-family: var(--font-primary); font-size: var(--size-3xl); font-weight: 800; color: var(--accent); margin-bottom: var(--space-2);">1</div>
        <h3>Remplissez le formulaire</h3>
        <p>
          Localisation, type, surface, pièces, état. Information essentielles en quelques secondes.
        </p>
      </article>

      <!-- Étape 2 -->
      <article class="card feature-card">
        <div class="feature-icon">
          <i class="fas fa-database"></i>
        </div>
        <div style="font-family: var(--font-primary); font-size: var(--size-3xl); font-weight: 800; color: var(--accent); margin-bottom: var(--space-2);">2</div>
        <h3>Analyse des données</h3>
        <p>
          Notre moteur compare avec 5000+ transactions réelles de votre quartier pour précision maximale.
        </p>
      </article>

      <!-- Étape 3 -->
      <article class="card feature-card">
        <div class="feature-icon">
          <i class="fas fa-chart-bar"></i>
        </div>
        <div style="font-family: var(--font-primary); font-size: var(--size-3xl); font-weight: 800; color: var(--accent); margin-bottom: var(--space-2);">3</div>
        <h3>Recevez l'estimation</h3>
        <p>
          Fourchette de prix, analyse comparative et insights sur votre marché local en quelques secondes.
        </p>
      </article>
    </div>
  </div>
</section>

<!-- ================================================ -->
<!-- AVANTAGES CLÉS -->
<!-- ================================================ -->
<section class="section">
  <div class="container">
    <div class="section-heading">
      <p class="eyebrow">
        <i class="fas fa-crown"></i> Nos avantages
      </p>
      <h2>L'estimation immobilière fiable et rapide</h2>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: var(--space-6);">
      <!-- Avantage 1 -->
      <article class="card feature-card">
        <div class="feature-icon">
          <i class="fas fa-database"></i>
        </div>
        <h3>Données actualisées</h3>
        <p>
          Base de 5000+ transactions récentes. Marché temps réel, jamais de données obsolètes. Toujours à jour.
        </p>
      </article>

      <!-- Avantage 2 -->
      <article class="card feature-card">
        <div class="feature-icon">
          <i class="fas fa-robot"></i>
        </div>
        <h3>Algorithme intelligent</h3>
        <p>
          Machine learning entraîné sur les tendances de <?= htmlspecialchars($cityName); ?>. Précision ±5% en conditions normales.
        </p>
      </article>

      <!-- Avantage 3 -->
      <article class="card feature-card">
        <div class="feature-icon">
          <i class="fas fa-clock"></i>
        </div>
        <h3>Résultat immédiat</h3>
        <p>
          Pas d'attente, pas de formulaire complexe. Estimation complète en moins de 60 secondes. Rapide et efficace.
        </p>
      </article>

      <!-- Avantage 4 -->
      <article class="card feature-card">
        <div class="feature-icon">
          <i class="fas fa-shield-alt"></i>
        </div>
        <h3>100% confidentiel</h3>
        <p>
          Vos données ne sont jamais vendues. RGPD conforme. Chiffrement SSL/TLS de bout en bout. Sécurisé.
        </p>
      </article>

      <!-- Avantage 5 -->
      <article class="card feature-card">
        <div class="feature-icon">
          <i class="fas fa-handshake"></i>
        </div>
        <h3>Support expert</h3>
        <p>
          Experts immobiliers locaux disponibles pour clarifier votre estimation et vous conseiller personnellement.
        </p>
      </article>

      <!-- Avantage 6 -->
      <article class="card feature-card">
        <div class="feature-icon">
          <i class="fas fa-star"></i>
        </div>
        <h3>Gratuit et sans engagement</h3>
        <p>
          Estimation complète 100% gratuite. Zéro obligation. Utilisez-la pour explorer vos options librement.
        </p>
      </article>
    </div>
  </div>
</section>

<!-- ================================================ -->
<!-- EXEMPLE DE RÉSULTAT -->
<!-- ================================================ -->
<section class="section section-alt" id="example-result">
  <div class="container">
    <div class="section-heading">
      <p class="eyebrow">
        <i class="fas fa-eye"></i> Exemple de résultat
      </p>
      <h2>Voici ce que vous recevrez</h2>
    </div>

    <div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: var(--space-8); align-items: start;">
      <!-- Résumé principal -->
      <div class="card" style="padding: var(--space-8);">
        <p class="eyebrow">
          <i class="fas fa-check-circle"></i> Estimation pour
        </p>
        <h2 style="margin-bottom: var(--space-6);">
          T3 • <?= htmlspecialchars($cityName); ?> <?= htmlspecialchars($featuredDistricts[0] ?? ''); ?>
        </h2>
        <p style="color: var(--text-secondary); margin-bottom: var(--space-6);">
          85 m² • Année 2005 • État bon
        </p>

        <!-- KPI Grid -->
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: var(--space-4); margin-bottom: var(--space-6);">
          <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: var(--radius-lg); padding: var(--space-4); text-align: center;">
            <p style="margin-bottom: var(--space-2); font-size: var(--size-xs); color: var(--text-muted); text-transform: uppercase; font-weight: 600;">
              <i class="fas fa-arrow-down"></i> Minimum
            </p>
            <p style="margin-bottom: 0; font-family: var(--font-primary); font-size: var(--size-2xl); font-weight: 800; color: var(--success);">
              290 K€
            </p>
          </div>

          <div style="background: linear-gradient(135deg, rgba(0, 63, 135, 0.1), rgba(255, 215, 0, 0.1)); border: 2px solid var(--primary); border-radius: var(--radius-lg); padding: var(--space-4); text-align: center;">
            <p style="margin-bottom: var(--space-2); font-size: var(--size-xs); color: var(--text-muted); text-transform: uppercase; font-weight: 600;">
              <i class="fas fa-target"></i> Estimation
            </p>
            <p style="margin-bottom: 0; font-family: var(--font-primary); font-size: var(--size-2xl); font-weight: 800; color: var(--primary);">
              315 K€
            </p>
          </div>

          <div style="background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.3); border-radius: var(--radius-lg); padding: var(--space-4); text-align: center;">
            <p style="margin-bottom: var(--space-2); font-size: var(--size-xs); color: var(--text-muted); text-transform: uppercase; font-weight: 600;">
              <i class="fas fa-arrow-up"></i> Maximum
            </p>
            <p style="margin-bottom: 0; font-family: var(--font-primary); font-size: var(--size-2xl); font-weight: 800; color: var(--info);">
              340 K€
            </p>
          </div>
        </div>

        <!-- Prix au m² -->
        <div style="background: var(--bg-alt); border-radius: var(--radius-lg); padding: var(--space-4); margin-bottom: var(--space-4);">
          <p style="margin-bottom: var(--space-2); font-size: var(--size-xs); color: var(--text-muted); text-transform: uppercase; font-weight: 600;">
            <i class="fas fa-coins"></i> Prix au m²
          </p>
          <p style="margin-bottom: 0; font-family: var(--font-primary); font-size: var(--size-2xl); font-weight: 800; color: var(--primary);">
            €<?= number_format($prixM2Moyen, 0, ',', ' '); ?>
          </p>
          <p style="margin-top: var(--space-2); margin-bottom: 0; font-size: var(--size-xs); color: var(--text-muted);">
            Moyenne quartier: €3,000 - €3,450
          </p>
        </div>
      </div>

      <!-- Insights -->
      <div style="display: flex; flex-direction: column; gap: var(--space-4);">
        <!-- Tendance marché -->
        <div class="card" style="padding: var(--space-6); border-left: 4px solid var(--primary);">
          <h3 style="margin-bottom: var(--space-3); display: flex; align-items: center; gap: var(--space-2); color: var(--primary);">
            <i class="fas fa-chart-line"></i> Tendance marché
          </h3>
          <p style="margin-bottom: var(--space-2);">
            <i class="fas fa-arrow-trend-up" style="color: var(--success);"></i>
            <strong style="color: var(--success);">Marché haussier</strong>
          </p>
          <p style="margin-bottom: 0; color: var(--text-secondary); font-size: var(--size-sm);">
            Marché actif sur <?= htmlspecialchars($cityName); ?> ces 12 derniers mois. Demande strong.
          </p>
        </div>

        <!-- Facteurs clés -->
        <div class="card" style="padding: var(--space-6); border-left: 4px solid var(--accent);">
          <h3 style="margin-bottom: var(--space-3); display: flex; align-items: center; gap: var(--space-2); color: var(--primary);">
            <i class="fas fa-info-circle"></i> Facteurs clés
          </h3>
          <ul style="list-style: none;">
            <li style="margin-bottom: var(--space-2); font-size: var(--size-sm);">
              <span style="color: var(--primary); font-weight: 700;">✓</span> Localisation recherchée
            </li>
            <li style="margin-bottom: var(--space-2); font-size: var(--size-sm);">
              <span style="color: var(--primary); font-weight: 700;">✓</span> Bien entretenu (+5%)
            </li>
            <li style="font-size: var(--size-sm);">
              <span style="color: var(--primary); font-weight: 700;">•</span> Proximité <?= htmlspecialchars($featuredDistricts[2] ?? ''); ?> (+2%)
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ================================================ -->
<!-- FAQ -->
<!-- ================================================ -->
<section class="section" id="faq">
  <div class="container">
    <div class="section-heading">
      <p class="eyebrow">
        <i class="fas fa-comments"></i> Questions fréquentes
      </p>
      <h2>Vos réponses rapides</h2>
    </div>

    <div class="faq-grid">
      <article class="card faq-card">
        <h3>
          <i class="fas fa-question-circle"></i> L'estimation est-elle gratuite ?
        </h3>
        <p>
          Oui, 100% gratuit et sans engagement. Utilisez-la autant que vous le souhaitez pour explorer différents scénarios.
        </p>
      </article>

      <article class="card faq-card">
        <h3>
          <i class="fas fa-question-circle"></i> Combien de temps faut-il ?
        </h3>
        <p>
          Estimation immédiate après validation du formulaire. Vous avez votre fourchette de prix en moins de 60 secondes.
        </p>
      </article>

      <article class="card faq-card">
        <h3>
          <i class="fas fa-question-circle"></i> À quelle précision m'attendre ?
        </h3>
        <p>
          Précision moyenne ±5% basée sur données réelles. Varie selon l'état du bien, localisation exacte, et marché local.
        </p>
      </article>

      <article class="card faq-card">
        <h3>
          <i class="fas fa-question-circle"></i> Mes données sont-elles sécurisées ?
        </h3>
        <p>
          Oui. Chiffrement SSL/TLS, stockage sécurisé, conformité RGPD. Vos données ne sont jamais vendues à des tiers.
        </p>
      </article>

      <article class="card faq-card">
        <h3>
          <i class="fas fa-question-circle"></i> Serai-je harcelé par des appels commerciaux ?
        </h3>
        <p>
          Non. Nous respectons votre choix. Désinscription en un clic si vous le souhaitez. Contrôle total en vos mains.
        </p>
      </article>

      <article class="card faq-card">
        <h3>
          <i class="fas fa-question-circle"></i> Puis-je faire plusieurs estimations ?
        </h3>
        <p>
          Oui ! Estimez votre bien, celui d'un ami, explorez différents scénarios. Aucune limite, c'est gratuit.
        </p>
      </article>
    </div>
  </div>
</section>

<!-- ================================================ -->
<!-- CTA FINAL HAUTE CONVERSION -->
<!-- ================================================ -->
<section class="section">
  <div class="container">
    <div class="cta-final card">
      <p class="eyebrow">
        <i class="fas fa-rocket"></i> N'attendez plus pour connaître la vraie valeur
      </p>
      <h2>Estimez votre bien à <?= htmlspecialchars($cityName); ?> en 60 secondes</h2>
      <p class="lead">
        Découvrez la valeur précise de votre propriété. De <?= htmlspecialchars($featuredDistricts[0] ?? ''); ?> au cœur de la ville jusqu'aux hauteurs, nos estimations couvrent toute la zone.
      </p>
      <a href="#form-estimation" class="btn btn-primary">
        <i class="fas fa-calculator"></i> Commencer l'estimation gratuitement
      </a>
      <p class="text-muted" style="font-size: var(--size-sm); margin: var(--space-4) 0 0;">
        <i class="fas fa-clock"></i> 60 secondes •
        <i class="fas fa-lock"></i> Sécurisé •
        <i class="fas fa-check-circle"></i> Sans engagement
      </p>
    </div>
  </div>
</section>
