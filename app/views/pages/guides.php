<?php 
$page_title = 'Guides Immobiliers - Estimation Lannion | Ressources Gratuites & Conseils';

// Données des guides
$guides = [
  [
    'id' => 1,
    'titre' => 'Le Guide Complet pour Vendre votre Maison',
    'description' => 'De la préparation à la signature : tous les étapes essentielles pour réussir votre vente immobilière.',
    'categorie' => 'Vente',
    'duree_lecture' => '8 min',
    'icon' => 'fas fa-home',
    'couleur' => '#003f87',
  ],
  [
    'id' => 2,
    'titre' => 'Estimation Immobilière : Comment ça Marche ?',
    'description' => 'Comprendre les méthodes d\'évaluation et pourquoi votre bien a la valeur qu\'on lui attribue.',
    'categorie' => 'Estimation',
    'duree_lecture' => '6 min',
    'icon' => 'fas fa-calculator',
    'couleur' => '#0052B4',
  ],
  [
    'id' => 3,
    'titre' => '10 Astuces pour Augmenter la Valeur de votre Bien',
    'description' => 'Petits travaux, staging, rénovations : maximisez le prix de vente avec ces conseils pratiques.',
    'categorie' => 'Valorisation',
    'duree_lecture' => '7 min',
    'icon' => 'fas fa-lightbulb',
    'couleur' => '#FFD700',
  ],
  [
    'id' => 4,
    'titre' => 'Les Tendances Immobilières à Lannion',
    'description' => 'Analyse des prix, des quartiers à la hausse et des opportunités d\'investissement pour 2024.',
    'categorie' => 'Marché',
    'duree_lecture' => '10 min',
    'icon' => 'fas fa-chart-line',
    'couleur' => '#10b981',
  ],
  [
    'id' => 5,
    'titre' => 'Financement : Préparer votre Projet d\'Achat',
    'description' => 'Comprendre les conditions de crédit, les apports et les aides pour acheter sereinement.',
    'categorie' => 'Financement',
    'duree_lecture' => '9 min',
    'icon' => 'fas fa-credit-card',
    'couleur' => '#3b82f6',
  ],
  [
    'id' => 6,
    'titre' => 'Fiscalité Immobilière : Tout ce que Vous Devez Savoir',
    'description' => 'Plus-values, droits de mutation, impôts locaux. Les points importants expliqués simplement.',
    'categorie' => 'Fiscal',
    'duree_lecture' => '11 min',
    'icon' => 'fas fa-file-invoice-dollar',
    'couleur' => '#ef4444',
  ],
];

// Catégories uniques
$categories = array_values(array_unique(array_column($guides, 'categorie')));
$categorie_active = isset($_GET['cat']) ? $_GET['cat'] : null;
$guides_filtres = $categorie_active ? array_filter($guides, fn($g) => $g['categorie'] === $categorie_active) : $guides;
?>

<section class="section page-hero">
  <div class="container">
    <div class="page-hero-inner">
      <p class="eyebrow">
        <i class="fas fa-book-open"></i> Guides Immobiliers
      </p>
      <h1>Ressources gratuites pour mieux comprendre l'immobilier</h1>
      <p class="lead">
        Guides pratiques, analyses de marché et conseils d'experts pour réussir votre projet immobilier à Lannion.
      </p>
    </div>
  </div>
</section>

<!-- ================================================ -->
<!-- FILTRES PAR CATÉGORIE -->
<!-- ================================================ -->
<section class="section section-alt">
  <div class="container">
    <div class="section-heading">
      <p class="eyebrow">
        <i class="fas fa-filter"></i> Filtrer par Catégorie
      </p>
      <h2>Trouvez les guides qui vous intéressent</h2>
    </div>

    <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: var(--space-3); margin-bottom: var(--space-8);">
      <!-- Tous les guides -->
      <a 
        href="/guides" 
        class="btn <?= !$categorie_active ? 'btn-primary' : 'btn-outline'; ?>"
      >
        <i class="fas fa-book"></i> Tous les guides
      </a>

      <!-- Par catégorie -->
      <?php foreach ($categories as $cat): ?>
        <a 
          href="/guides?cat=<?= urlencode($cat); ?>" 
          class="btn <?= $categorie_active === $cat ? 'btn-primary' : 'btn-outline'; ?>"
        >
          <?php 
            $icon = match($cat) {
              'Vente' => 'fas fa-home',
              'Estimation' => 'fas fa-calculator',
              'Valorisation' => 'fas fa-lightbulb',
              'Marché' => 'fas fa-chart-line',
              'Financement' => 'fas fa-credit-card',
              'Fiscal' => 'fas fa-file-invoice-dollar',
              default => 'fas fa-book'
            };
          ?>
          <i class="<?= $icon; ?>"></i> <?= htmlspecialchars($cat); ?>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ================================================ -->
<!-- GRILLE DE GUIDES -->
<!-- ================================================ -->
<section class="section">
  <div class="container">
    <?php if (!$guides_filtres): ?>
      <div class="card" style="padding: var(--space-8); text-align: center;">
        <p style="color: var(--text-muted); margin: 0;">
          Aucun guide trouvé dans cette catégorie. Réessayez ou consultez tous les guides.
        </p>
      </div>
    <?php else: ?>
      <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: var(--space-6);">
        <?php foreach ($guides_filtres as $guide): ?>
          <article class="card" style="padding: 0; overflow: hidden; display: flex; flex-direction: column; transition: all var(--trans-base);">
            <!-- En-tête coloré -->
            <div style="background: <?= htmlspecialchars($guide['couleur']); ?>; padding: var(--space-6); color: white; display: flex; align-items: center; justify-content: center; min-height: 120px;">
              <i class="<?= htmlspecialchars($guide['icon']); ?>" style="font-size: var(--size-5xl); opacity: 0.9;"></i>
            </div>

            <!-- Contenu -->
            <div style="padding: var(--space-6); flex: 1; display: flex; flex-direction: column;">
              <!-- Catégorie badge -->
              <div style="margin-bottom: var(--space-3);">
                <span class="badge badge-primary">
                  <?= htmlspecialchars($guide['categorie']); ?>
                </span>
              </div>

              <!-- Titre -->
              <h3 style="margin: 0 0 var(--space-2) 0; font-size: var(--size-xl); color: var(--text);">
                <?= htmlspecialchars($guide['titre']); ?>
              </h3>

              <!-- Description -->
              <p style="margin: 0 0 var(--space-4) 0; color: var(--text-secondary); font-size: var(--size-sm); line-height: var(--line-lg); flex: 1;">
                <?= htmlspecialchars($guide['description']); ?>
              </p>

              <!-- Métadonnées -->
              <div style="display: flex; align-items: center; gap: var(--space-4); padding-top: var(--space-4); border-top: 1px solid var(--border-light); font-size: var(--size-xs); color: var(--text-muted);">
                <span>
                  <i class="fas fa-clock"></i> <?= htmlspecialchars($guide['duree_lecture']); ?>
                </span>
                <span>
                  <i class="fas fa-file-pdf"></i> PDF
                </span>
              </div>

              <!-- Boutons CTA -->
              <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-3); margin-top: var(--space-4);">
                <a href="#" class="btn btn-primary btn-sm" style="justify-content: center;">
                  <i class="fas fa-eye"></i> Lire
                </a>
                <a href="#" class="btn btn-outline btn-sm" style="justify-content: center;">
                  <i class="fas fa-download"></i> PDF
                </a>
              </div>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>

<!-- ================================================ -->
<!-- POURQUOI CES GUIDES -->
<!-- ================================================ -->
<section class="section section-alt">
  <div class="container">
    <div class="section-heading">
      <p class="eyebrow">
        <i class="fas fa-star"></i> Pourquoi Lire Nos Guides
      </p>
      <h2>Ressources fiables et gratuites</h2>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: var(--space-6);">
      <!-- Avantage 1 -->
      <article class="card feature-card">
        <div class="feature-icon">
          <i class="fas fa-check-circle"></i>
        </div>
        <h3>100% Gratuit</h3>
        <p>
          Aucun coût, aucun engagement. Téléchargez les guides en PDF et consultez-les quand vous le souhaitez.
        </p>
      </article>

      <!-- Avantage 2 -->
      <article class="card feature-card">
        <div class="feature-icon">
          <i class="fas fa-user-tie"></i>
        </div>
        <h3>Expertise Locale</h3>
        <p>
          Rédigés par nos experts immobiliers avec 25+ ans d'expérience. Conseils basés sur la connaissance réelle du marché.
        </p>
      </article>

      <!-- Avantage 3 -->
      <article class="card feature-card">
        <div class="feature-icon">
          <i class="fas fa-lightbulb"></i>
        </div>
        <h3>Pratique & Applicable</h3>
        <p>
          Pas de théorie creuse. Chaque conseil est actionnable immédiatement. Des étapes concrètes et faciles à suivre.
        </p>
      </article>

      <!-- Avantage 4 -->
      <article class="card feature-card">
        <div class="feature-icon">
          <i class="fas fa-smartphone"></i>
        </div>
        <h3>Tous les Formats</h3>
        <p>
          Consultez en ligne ou téléchargez en PDF. Lisible sur tous les appareils : ordinateur, tablette, mobile.
        </p>
      </article>

      <!-- Avantage 5 -->
      <article class="card feature-card">
        <div class="feature-icon">
          <i class="fas fa-chart-line"></i>
        </div>
        <h3>À Jour</h3>
        <p>
          Guides régulièrement mis à jour avec les dernières tendances, lois et données du marché immobilier.
        </p>
      </article>

      <!-- Avantage 6 -->
      <article class="card feature-card">
        <div class="feature-icon">
          <i class="fas fa-rocket"></i>
        </div>
        <h3>Gain de Temps</h3>
        <p>
          L'essentiel synthétisé et expliqué clairement. Gagnez des heures de recherche en ligne non fiable.
        </p>
      </article>
    </div>
  </div>
</section>

<!-- ================================================ -->
<!-- GUIDES EN VEDETTE -->
<!-- ================================================ -->
<section class="section">
  <div class="container">
    <div class="section-heading">
      <p class="eyebrow">
        <i class="fas fa-fire"></i> Plus Populaires
      </p>
      <h2>Les guides les plus téléchargés</h2>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: var(--space-6);">
      <!-- Guide populaire 1 -->
      <article class="card" style="padding: var(--space-6); border-top: 4px solid var(--accent);">
        <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: var(--space-3); margin-bottom: var(--space-4);">
          <h3 style="margin: 0; flex: 1;">
            Le Guide Complet pour Vendre votre Maison
          </h3>
          <span style="background: rgba(255, 215, 0, 0.2); color: #c4860c; padding: var(--space-2) var(--space-3); border-radius: var(--radius-md); font-weight: 700; font-size: var(--size-xs); white-space: nowrap;">
            ⭐ #1
          </span>
        </div>
        <p style="color: var(--text-secondary); font-size: var(--size-sm); margin-bottom: var(--space-4);">
          2 847 téléchargements | 4.9/5 ⭐
        </p>
        <p style="color: var(--text-secondary); margin-bottom: var(--space-4);">
          De la préparation à la signature, toutes les étapes pour réussir votre vente immobilière avec confiance.
        </p>
        <div style="display: flex; gap: var(--space-3);">
          <a href="#" class="btn btn-primary btn-sm">
            <i class="fas fa-eye"></i> Consulter
          </a>
          <a href="#" class="btn btn-outline btn-sm">
            <i class="fas fa-download"></i> Télécharger
          </a>
        </div>
      </article>

      <!-- Guide populaire 2 -->
      <article class="card" style="padding: var(--space-6); border-top: 4px solid var(--accent);">
        <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: var(--space-3); margin-bottom: var(--space-4);">
          <h3 style="margin: 0; flex: 1;">
            10 Astuces pour Augmenter la Valeur de votre Bien
          </h3>
          <span style="background: rgba(255, 215, 0, 0.2); color: #c4860c; padding: var(--space-2) var(--space-3); border-radius: var(--radius-md); font-weight: 700; font-size: var(--size-xs); white-space: nowrap;">
            ⭐ #2
          </span>
        </div>
        <p style="color: var(--text-secondary); font-size: var(--size-sm); margin-bottom: var(--space-4);">
          1 923 téléchargements | 4.8/5 ⭐
        </p>
        <p style="color: var(--text-secondary); margin-bottom: var(--space-4);">
          Petits travaux, staging, rénovations : maximisez le prix de vente avec ces conseils pratiques et éprouvés.
        </p>
        <div style="display: flex; gap: var(--space-3);">
          <a href="#" class="btn btn-primary btn-sm">
            <i class="fas fa-eye"></i> Consulter
          </a>
          <a href="#" class="btn btn-outline btn-sm">
            <i class="fas fa-download"></i> Télécharger
          </a>
        </div>
      </article>

      <!-- Guide populaire 3 -->
      <article class="card" style="padding: var(--space-6); border-top: 4px solid var(--accent);">
        <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: var(--space-3); margin-bottom: var(--space-4);">
          <h3 style="margin: 0; flex: 1;">
            Les Tendances Immobilières à Lannion
          </h3>
          <span style="background: rgba(255, 215, 0, 0.2); color: #c4860c; padding: var(--space-2) var(--space-3); border-radius: var(--radius-md); font-weight: 700; font-size: var(--size-xs); white-space: nowrap;">
            ⭐ #3
          </span>
        </div>
        <p style="color: var(--text-secondary); font-size: var(--size-sm); margin-bottom: var(--space-4);">
          1 456 téléchargements | 4.9/5 ⭐
        </p>
        <p style="color: var(--text-secondary); margin-bottom: var(--space-4);">
          Analyse des prix, quartiers à la hausse et opportunités d'investissement pour 2024. Données détaillées et actualisées.
        </p>
        <div style="display: flex; gap: var(--space-3);">
          <a href="#" class="btn btn-primary btn-sm">
            <i class="fas fa-eye"></i> Consulter
          </a>
          <a href="#" class="btn btn-outline btn-sm">
            <i class="fas fa-download"></i> Télécharger
          </a>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- ================================================ -->
<!-- NEWSLETTER GUIDES -->
<!-- ================================================ -->
<section class="section section-alt">
  <div class="container" style="max-width: 700px;">
    <div class="card" style="padding: var(--space-8); background: linear-gradient(135deg, rgba(0, 63, 135, 0.05) 0%, rgba(255, 215, 0, 0.05) 100%); text-align: center;">
      <p class="eyebrow">
        <i class="fas fa-bell"></i> Nouveaux Guides
      </p>
      <h2 style="margin-top: 0;">Soyez informé des nouveaux guides</h2>
      <p style="color: var(--text-secondary); margin-bottom: var(--space-4);">
        Recevez une notification par email dès qu'un nouveau guide est publié. Réservé aux abonnés à la newsletter.
      </p>

      <form style="display: flex; gap: var(--space-3); flex-direction: column;">
        <input 
          type="email" 
          placeholder="votre@email.com" 
          style="padding: var(--space-3) var(--space-4); border: 1.5px solid var(--border); border-radius: var(--radius-md); font-family: var(--font-secondary); font-size: var(--size-sm);"
          required
        >
        <button type="submit" class="btn btn-primary full-width">
          <i class="fas fa-paper-plane"></i> M'avertir des nouveaux guides
        </button>
      </form>

      <p style="font-size: var(--size-xs); color: var(--text-muted); margin: var(--space-4) 0 0 0;">
        Nous ne spam pas. Un email par guide. Vous pouvez vous désabonner à tout moment.
      </p>
    </div>
  </div>
</section>

<!-- ================================================ -->
<!-- FAQ GUIDES -->
<!-- ================================================ -->
<section class="section">
  <div class="container">
    <div class="section-heading">
      <p class="eyebrow">
        <i class="fas fa-question-circle"></i> Questions
      </p>
      <h2>Vos questions sur nos guides</h2>
    </div>

    <div class="faq-grid">
      <article class="card faq-card">
        <h3>
          <i class="fas fa-coins"></i> Les guides sont-ils payants ?
        </h3>
        <p>
          Non ! Tous nos guides sont complètement gratuits. Aucun coût caché, aucun engagement. Téléchargez et utilisez-les librement.
        </p>
      </article>

      <article class="card faq-card">
        <h3>
          <i class="fas fa-file-pdf"></i> Quels formats proposez-vous ?
        </h3>
        <p>
          Chaque guide est disponible en consultation en ligne (HTML) et téléchargement (PDF). Lisibles sur tous les appareils.
        </p>
      </article>

      <article class="card faq-card">
        <h3>
          <i class="fas fa-calendar"></i> Quand de nouveaux guides seront-ils publiés ?
        </h3>
        <p>
          Nous publions 1 à 2 nouveaux guides par mois. Abonnez-vous à la newsletter pour être averti immédiatement.
        </p>
      </article>

      <article class="card faq-card">
        <h3>
          <i class="fas fa-share-alt"></i> Puis-je partager les guides ?
        </h3>
        <p>
          Oui ! Vous pouvez partager les liens avec vos amis et famille. Ils pourront consulter et télécharger aussi.
        </p>
      </article>

      <article class="card faq-card">
        <h3>
          <i class="fas fa-user-check"></i> Sont-ils vérifiés et à jour ?
        </h3>
        <p>
          Oui, tous les guides sont rédigés par nos experts et régulièrement mis à jour. Les données sont vérifiées et actuelles.
        </p>
      </article>

      <article class="card faq-card">
        <h3>
          <i class="fas fa-comments"></i> Puis-je donner un avis sur un guide ?
        </h3>
        <p>
          Absolument ! Votre feedback nous aide à améliorer nos ressources. Contactez-nous pour partager votre avis.
        </p>
      </article>
    </div>
  </div>
</section>

<!-- ================================================ -->
<!-- ACCOMPAGNEMENT PERSONNALISÉ -->
<!-- ================================================ -->
<section class="section section-alt">
  <div class="container" style="max-width: 700px;">
    <div class="card" style="padding: var(--space-8);">
      <h2 style="margin-top: 0; text-align: center;">
        <i class="fas fa-handshake"></i> Besoin d'Aide Personnalisée ?
      </h2>
      <p style="text-align: center; color: var(--text-secondary); margin-bottom: var(--space-6);">
        Les guides couvrent beaucoup de sujet, mais chaque situation est unique. Nos experts sont disponibles pour vous accompagner personnellement.
      </p>

      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: var(--space-4); margin-bottom: var(--space-6);">
        <a href="/contact" class="btn btn-primary" style="justify-content: center;">
          <i class="fas fa-envelope"></i> Nous contacter
        </a>
        <a href="/#form-estimation" class="btn btn-secondary" style="justify-content: center;">
          <i class="fas fa-calculator"></i> Faire une estimation
        </a>
      </div>

      <p style="text-align: center; font-size: var(--size-sm); color: var(--text-muted); margin: 0;">
        Réponse en moins de 2h en heures ouvrables.
      </p>
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
        <i class="fas fa-star"></i> Prêt à approfondir vos connaissances ?
      </p>
      <h2>Commencez par un guide</h2>
      <p class="lead">
        6 guides complets, gratuits et à jour. Tout ce qu'il faut savoir pour réussir votre projet immobilier.
      </p>
      <a href="/guides#guides" class="btn btn-primary">
        <i class="fas fa-arrow-down"></i> Voir tous les guides
      </a>
    </div>
  </div>
</section>

<script>
  // Filter buttons smooth behavior
  (function () {
    const buttons = document.querySelectorAll('a[href*="/guides?cat="]');
    buttons.forEach(btn => {
      btn.addEventListener('click', function(e) {
        // Smooth scroll to guides section
        setTimeout(() => {
          const guidesSection = document.querySelector('.section:has(> .container > [style*="grid"])');
          guidesSection?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 100);
      });
    });
  })();
</script>
