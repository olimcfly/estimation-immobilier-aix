<?php 
$page_title = 'Podcast Immobilier - Estimation Lannion | Conseils & Tendances Immobiliers';

// Gestion de la liste d'attente
$waitlist_errors = [];
$waitlist_success_message = '';
$waitlist_form_data = [
  'waitlist_nom' => '',
  'waitlist_email' => '',
  'waitlist_website' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['waitlist_email'])) {
  $waitlist_form_data['waitlist_nom'] = trim((string) ($_POST['waitlist_nom'] ?? ''));
  $waitlist_form_data['waitlist_email'] = trim((string) ($_POST['waitlist_email'] ?? ''));
  $waitlist_form_data['waitlist_website'] = trim((string) ($_POST['waitlist_website'] ?? ''));

  // Honeypot anti-spam
  if ($waitlist_form_data['waitlist_website'] !== '') {
    $waitlist_errors[] = 'Votre demande a été identifiée comme spam.';
  }

  if ($waitlist_form_data['waitlist_nom'] === '') {
    $waitlist_errors[] = 'Le nom est obligatoire.';
  }

  if ($waitlist_form_data['waitlist_email'] === '' || !filter_var($waitlist_form_data['waitlist_email'], FILTER_VALIDATE_EMAIL)) {
    $waitlist_errors[] = 'Veuillez renseigner une adresse email valide.';
  }

  if (!$waitlist_errors) {
    $to = getenv('WAITLIST_EMAIL') ?: 'podcast@estimation-immobilier-lannion.fr';
    $subject = 'Nouveau sur la liste d\'attente du podcast - Lannion';

    $safe_nom = htmlspecialchars($waitlist_form_data['waitlist_nom'], ENT_QUOTES, 'UTF-8');
    $safe_email = filter_var($waitlist_form_data['waitlist_email'], FILTER_SANITIZE_EMAIL);

    $body = "Nouveau sur la liste d'attente du podcast\n\n"
      . "Nom : {$safe_nom}\n"
      . "Email : {$safe_email}\n"
      . "Date : " . date('Y-m-d H:i:s') . "\n";

    $headers = [
      'From: no-reply@estimation-immobilier-lannion.fr',
      'Content-Type: text/plain; charset=UTF-8',
    ];

    $mail_sent = @mail($to, $subject, $body, implode("\r\n", $headers));

    if ($mail_sent) {
      $waitlist_success_message = 'Merci ! Vous êtes inscrit sur la liste d\'attente. Nous vous contacterons lors du lancement.';
      $waitlist_form_data = [
        'waitlist_nom' => '',
        'waitlist_email' => '',
        'waitlist_website' => '',
      ];
    } else {
      $waitlist_errors[] = 'Une erreur est survenue. Merci de réessayer plus tard.';
    }
  }
}

// Thèmes à venir
$themes_podcast = [
  [
    'numero' => '1',
    'titre' => 'Les secrets pour vendre plus cher',
    'description' => 'Avec notre expert, découvrez les 7 facteurs clés qui font monter le prix de vente de 10 à 20%.',
  ],
  [
    'numero' => '2',
    'titre' => 'Tendances marché Lannion 2024',
    'description' => 'Analyse détaillée des quartiers à la hausse, des opportunités d\'investissement et des prix prévus.',
  ],
  [
    'numero' => '3',
    'titre' => 'Financement immobilier simplifié',
    'description' => 'Comment fonctionne un crédit immobilier ? Quels sont les pièges à éviter ? Nos réponses claires.',
  ],
  [
    'numero' => '4',
    'titre' => 'Estimation immobilière : comment ça marche ?',
    'description' => 'Plongée dans la méthodologie : comparables, ajustements, algorithmes. Comprendre le chiffre final.',
  ],
  [
    'numero' => '5',
    'titre' => 'Retours d\'expérience de vendeurs',
    'description' => 'Témoignages authentiques : comment ils ont réussi leur vente, les pièges rencontrés, les solutions.',
  ],
  [
    'numero' => '6',
    'titre' => 'Fiscalité immobilière expliquée',
    'description' => 'Plus-values, droits de mutation, impôts locaux. Les règles simplifiées pour les vendeurs et acheteurs.',
  ],
];
?>

<section class="section page-hero">
  <div class="container">
    <div class="page-hero-inner">
      <p class="eyebrow">
        <i class="fas fa-podcast"></i> Podcast Immobilier
      </p>
      <h1>Le podcast immobilier de Lannion</h1>
      <p class="lead">
        Conseils d'experts, analyses de marché et retours d'expérience. Chaque semaine, 20-30 minutes pour mieux comprendre l'immobilier.
      </p>
    </div>
  </div>
</section>

<!-- ================================================ -->
<!-- SECTION COMING SOON ATTRACTIVE -->
<!-- ================================================ -->
<section class="section section-alt">
  <div class="container" style="max-width: 800px;">
    <div class="card" style="padding: var(--space-10); text-align: center; background: linear-gradient(135deg, rgba(0, 63, 135, 0.05) 0%, rgba(255, 215, 0, 0.05) 100%);">
      <!-- Icône grande -->
      <div style="font-size: 4rem; margin-bottom: var(--space-4); opacity: 0.9;">
        🎙️
      </div>

      <!-- Titre -->
      <h2 style="margin-top: 0; color: var(--primary);">
        Lancement très bientôt !
      </h2>

      <!-- Description -->
      <p style="font-size: var(--size-lg); color: var(--text-secondary); margin-bottom: var(--space-6); line-height: var(--line-lg);">
        Nous préparons les premiers épisodes du podcast. Un contenu riche, des experts passionnés, et des insights précieux sur le marché immobilier de Lannion et région.
      </p>

      <!-- Date estimée -->
      <div style="background: var(--secondary); border: 2px solid var(--accent); border-radius: var(--radius-lg); padding: var(--space-4) var(--space-6); display: inline-block; margin-bottom: var(--space-6);">
        <p style="margin: 0; font-size: var(--size-sm); color: var(--text-muted); font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em;">
          Lancement prévu
        </p>
        <p style="margin: var(--space-2) 0 0 0; font-family: var(--font-primary); font-size: var(--size-2xl); font-weight: 800; color: var(--accent);">
          Q2 2024
        </p>
      </div>

      <!-- Compteur d'attente -->
      <div style="background: var(--bg-alt); border-radius: var(--radius-lg); padding: var(--space-4); margin-bottom: var(--space-6);">
        <p style="margin: 0 0 var(--space-2) 0; font-size: var(--size-sm); color: var(--text-muted);">
          <i class="fas fa-users"></i> Déjà sur la liste d'attente
        </p>
        <p style="margin: 0; font-family: var(--font-primary); font-size: var(--size-3xl); font-weight: 800; color: var(--primary);">
          487<span style="font-size: 0.6em; color: var(--accent);">+</span>
        </p>
      </div>

      <!-- Avantages d'être dans la liste -->
      <div style="display: flex; justify-content: center; gap: var(--space-6); margin-bottom: var(--space-6); flex-wrap: wrap; font-size: var(--size-sm); color: var(--text-secondary);">
        <div style="display: flex; align-items: center; gap: var(--space-2);">
          <i class="fas fa-bell" style="color: var(--accent);"></i>
          Notification du lancement
        </div>
        <div style="display: flex; align-items: center; gap: var(--space-2);">
          <i class="fas fa-star" style="color: var(--accent);"></i>
          Accès prioritaire
        </div>
        <div style="display: flex; align-items: center; gap: var(--space-2);">
          <i class="fas fa-gift" style="color: var(--accent);"></i>
          Bonus exclusif
        </div>
      </div>

      <p style="margin: 0; color: var(--text-muted); font-size: var(--size-sm);">
        Rejoignez la liste d'attente ci-dessous pour être parmi les premiers à écouter !
      </p>
    </div>
  </div>
</section>

<!-- ================================================ -->
<!-- FORMULAIRE LISTE D'ATTENTE -->
<!-- ================================================ -->
<section class="section">
  <div class="container" style="max-width: 700px;">
    <div class="card" style="padding: var(--space-8);">
      <h2 style="margin-top: 0; text-align: center; margin-bottom: var(--space-2);">
        <i class="fas fa-envelope-circle-check"></i> Soyez informé du lancement
      </h2>
      <p style="text-align: center; color: var(--text-secondary); margin-bottom: var(--space-6);">
        Inscrivez-vous pour recevoir une notification lors de la sortie du premier épisode.
      </p>

      <!-- Message de succès -->
      <?php if ($waitlist_success_message): ?>
        <div class="alert alert-success" style="display: flex; align-items: flex-start; gap: var(--space-3); margin-bottom: var(--space-6);">
          <i class="fas fa-check-circle" style="flex-shrink: 0; margin-top: 2px; font-size: var(--size-lg);"></i>
          <div>
            <p style="margin: 0; font-weight: 600;">
              <?= htmlspecialchars($waitlist_success_message, ENT_QUOTES, 'UTF-8'); ?>
            </p>
          </div>
        </div>
      <?php endif; ?>

      <!-- Messages d'erreur -->
      <?php if ($waitlist_errors): ?>
        <div style="background: var(--error-light); border: 1.5px solid var(--error); border-radius: var(--radius-lg); padding: var(--space-4); margin-bottom: var(--space-6);">
          <ul style="margin: 0; padding-left: var(--space-6); color: var(--error);">
            <?php foreach ($waitlist_errors as $error): ?>
              <li style="margin-bottom: var(--space-2); font-size: var(--size-sm);">
                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <!-- Formulaire -->
      <form class="form-grid" action="/podcast" method="post" novalidate style="gap: var(--space-4);">
        <!-- Nom -->
        <label for="waitlist_nom">
          <span>
            <i class="fas fa-user"></i> Nom *
          </span>
          <input 
            type="text" 
            id="waitlist_nom" 
            name="waitlist_nom" 
            placeholder="Jean Dupont"
            required
            value="<?= htmlspecialchars($waitlist_form_data['waitlist_nom'], ENT_QUOTES, 'UTF-8'); ?>"
          >
        </label>

        <!-- Email -->
        <label for="waitlist_email" class="full-width">
          <span>
            <i class="fas fa-envelope"></i> Email *
          </span>
          <input 
            type="email" 
            id="waitlist_email" 
            name="waitlist_email" 
            placeholder="vous@exemple.com" 
            required
            value="<?= htmlspecialchars($waitlist_form_data['waitlist_email'], ENT_QUOTES, 'UTF-8'); ?>"
          >
        </label>

        <!-- Honeypot -->
        <label for="waitlist_website" style="position:absolute; left:-10000px; width:1px; height:1px; overflow:hidden;">
          Site web
        </label>
        <input 
          type="text" 
          id="waitlist_website" 
          name="waitlist_website" 
          tabindex="-1" 
          autocomplete="off"
          value="<?= htmlspecialchars($waitlist_form_data['waitlist_website'], ENT_QUOTES, 'UTF-8'); ?>"
          style="position:absolute; left:-10000px; width:1px; height:1px; overflow:hidden;"
        >

        <!-- Bouton -->
        <button type="submit" class="btn btn-primary full-width">
          <i class="fas fa-bell"></i> S'inscrire à la liste d'attente
        </button>

        <p style="font-size: var(--size-xs); color: var(--text-muted); text-align: center; margin: var(--space-3) 0 0 0;">
          Nous vous contacterons une seule fois, lors du lancement. Pas de spam promis !
        </p>
      </form>
    </div>
  </div>
</section>

<!-- ================================================ -->
<!-- POURQUOI ÉCOUTER CE PODCAST -->
<!-- ================================================ -->
<section class="section section-alt">
  <div class="container">
    <div class="section-heading">
      <p class="eyebrow">
        <i class="fas fa-star"></i> Pourquoi Écouter
      </p>
      <h2>Ce qu'on vous propose</h2>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: var(--space-6);">
      <!-- Avantage 1 -->
      <article class="card feature-card">
        <div class="feature-icon">
          <i class="fas fa-user-tie"></i>
        </div>
        <h3>Experts Locaux</h3>
        <p>
          Interviews avec nos spécialistes immobiliers basés à Lannion. 25+ ans d'expérience accumulée. Conseils vrais et applicables.
        </p>
      </article>

      <!-- Avantage 2 -->
      <article class="card feature-card">
        <div class="feature-icon">
          <i class="fas fa-chart-line"></i>
        </div>
        <h3>Analyses Profondes</h3>
        <p>
          Plus qu'une simple information : nous analysons les tendances, les causes et les conséquences pour vous et votre investissement.
        </p>
      </article>

      <!-- Avantage 3 -->
      <article class="card feature-card">
        <div class="feature-icon">
          <i class="fas fa-comments"></i>
        </div>
        <h3>Retours d'Expérience</h3>
        <p>
          Des vendeurs, des acheteurs, des investisseurs partagent leurs histoires vraies. Les bons coups et les erreurs à éviter.
        </p>
      </article>

      <!-- Avantage 4 -->
      <article class="card feature-card">
        <div class="feature-icon">
          <i class="fas fa-clock"></i>
        </div>
        <h3>Format Pratique</h3>
        <p>
          20-30 minutes par semaine. Parfait pour écouter en voiture, en faisant du sport, en cuisinant. Flexible et utile.
        </p>
      </article>

      <!-- Avantage 5 -->
      <article class="card feature-card">
        <div class="feature-icon">
          <i class="fas fa-lightbulb"></i>
        </div>
        <h3>Concepts Expliqués</h3>
        <p>
          Estimation, financement, fiscalité, tendances. Rien n'est trop technique. Tout est expliqué clairement et simplement.
        </p>
      </article>

      <!-- Avantage 6 -->
      <article class="card feature-card">
        <div class="feature-icon">
          <i class="fas fa-headphones"></i>
        </div>
        <h3>Format Audio</h3>
        <p>
          Écoutez sur Spotify, Apple Podcasts, YouTube et autres. Téléchargez les épisodes pour écouter hors ligne. Votre choix.
        </p>
      </article>
    </div>
  </div>
</section>

<!-- ================================================ -->
<!-- PROCHAINS ÉPISODES -->
<!-- ================================================ -->
<section class="section">
  <div class="container">
    <div class="section-heading">
      <p class="eyebrow">
        <i class="fas fa-list-check"></i> Au Programme
      </p>
      <h2>Les premiers épisodes à venir</h2>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: var(--space-6);">
      <?php foreach ($themes_podcast as $theme): ?>
        <article class="card" style="padding: var(--space-6); border-top: 4px solid var(--primary);">
          <!-- Numéro -->
          <div style="display: flex; align-items: center; gap: var(--space-3); margin-bottom: var(--space-4);">
            <span style="background: var(--primary); color: white; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-full); font-family: var(--font-primary); font-size: var(--size-2xl); font-weight: 800;">
              #<?= htmlspecialchars($theme['numero']); ?>
            </span>
            <div style="flex: 1;">
              <p style="margin: 0; font-size: var(--size-xs); color: var(--text-muted); text-transform: uppercase; font-weight: 600;">
                Épisode <?= htmlspecialchars($theme['numero']); ?>
              </p>
            </div>
          </div>

          <!-- Titre -->
          <h3 style="margin: 0 0 var(--space-3) 0; font-size: var(--size-lg); color: var(--text);">
            <?= htmlspecialchars($theme['titre']); ?>
          </h3>

          <!-- Description -->
          <p style="margin: 0; color: var(--text-secondary); font-size: var(--size-sm); line-height: var(--line-lg);">
            <?= htmlspecialchars($theme['description']); ?>
          </p>
        </article>
      <?php endforeach; ?>
    </div>

    <!-- Note -->
    <div style="text-align: center; margin-top: var(--space-8); padding: var(--space-6); background: var(--bg-alt); border-radius: var(--radius-lg);">
      <p style="margin: 0; color: var(--text-secondary); font-size: var(--size-sm);">
        <i class="fas fa-info-circle"></i> Plus d'épisodes à venir après le lancement. Le programme sera ajusté selon vos retours et intérêts.
      </p>
    </div>
  </div>
</section>

<!-- ================================================ -->
<!-- FORMAT & PLATEFORME -->
<!-- ================================================ -->
<section class="section section-alt">
  <div class="container">
    <div class="section-heading">
      <p class="eyebrow">
        <i class="fas fa-microphone"></i> Comment Écouter
      </p>
      <h2>Disponible sur toutes les plateformes</h2>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: var(--space-6);">
      <!-- Plateforme 1 -->
      <div class="card" style="padding: var(--space-6); text-align: center;">
        <div style="font-size: var(--size-4xl); color: var(--primary); margin-bottom: var(--space-3);">
          <i class="fab fa-spotify"></i>
        </div>
        <h3 style="margin: 0 0 var(--space-2) 0; font-size: var(--size-lg);">Spotify</h3>
        <p style="margin: 0; color: var(--text-secondary); font-size: var(--size-sm);">
          L'appli la plus populaire. Écoute fluide et listes personnalisées.
        </p>
      </div>

      <!-- Plateforme 2 -->
      <div class="card" style="padding: var(--space-6); text-align: center;">
        <div style="font-size: var(--size-4xl); color: var(--primary); margin-bottom: var(--space-3);">
          <i class="fab fa-apple"></i>
        </div>
        <h3 style="margin: 0 0 var(--space-2) 0; font-size: var(--size-lg);">Apple Podcasts</h3>
        <p style="margin: 0; color: var(--text-secondary); font-size: var(--size-sm);">
          Native sur les appareils Apple. Intégration parfaite avec Siri.
        </p>
      </div>

      <!-- Plateforme 3 -->
      <div class="card" style="padding: var(--space-6); text-align: center;">
        <div style="font-size: var(--size-4xl); color: var(--primary); margin-bottom: var(--space-3);">
          <i class="fab fa-youtube"></i>
        </div>
        <h3 style="margin: 0 0 var(--space-2) 0; font-size: var(--size-lg);">YouTube</h3>
        <p style="margin: 0; color: var(--text-secondary); font-size: var(--size-sm);">
          Version audio + vidéo pour les visuels. Partage facile.
        </p>
      </div>

      <!-- Plateforme 4 -->
      <div class="card" style="padding: var(--space-6); text-align: center;">
        <div style="font-size: var(--size-4xl); color: var(--primary); margin-bottom: var(--space-3);">
          <i class="fas fa-globe"></i>
        </div>
        <h3 style="margin: 0 0 var(--space-2) 0; font-size: var(--size-lg);">Site Web</h3>
        <p style="margin: 0; color: var(--text-secondary); font-size: var(--size-sm);">
          Lecteur intégré avec transcriptions et timestamps.
        </p>
      </div>

      <!-- Plateforme 5 -->
      <div class="card" style="padding: var(--space-6); text-align: center;">
        <div style="font-size: var(--size-4xl); color: var(--primary); margin-bottom: var(--space-3);">
          <i class="fas fa-download"></i>
        </div>
        <h3 style="margin: 0 0 var(--space-2) 0; font-size: var(--size-lg);">Téléchargement</h3>
        <p style="margin: 0; color: var(--text-secondary); font-size: var(--size-sm);">
          Téléchargez les MP3 pour écouter hors ligne.
        </p>
      </div>

      <!-- Plateforme 6 -->
      <div class="card" style="padding: var(--space-6); text-align: center;">
        <div style="font-size: var(--size-4xl); color: var(--primary); margin-bottom: var(--space-3);">
          <i class="fas fa-rss"></i>
        </div>
        <h3 style="margin: 0 0 var(--space-2) 0; font-size: var(--size-lg);">Flux RSS</h3>
        <p style="margin: 0; color: var(--text-secondary); font-size: var(--size-sm);">
          S'abonner directement via votre appli podcast préférée.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- ================================================ -->
<!-- FAQ PODCAST -->
<!-- ================================================ -->
<section class="section">
  <div class="container">
    <div class="section-heading">
      <p class="eyebrow">
        <i class="fas fa-question-circle"></i> Questions
      </p>
      <h2>Vos questions sur le podcast</h2>
    </div>

    <div class="faq-grid">
      <article class="card faq-card">
        <h3>
          <i class="fas fa-calendar"></i> Quand sera lancé le podcast ?
        </h3>
        <p>
          Lancement prévu pour Q2 2024 (avril-juin). Inscrivez-vous à la liste d'attente pour être averti le jour du lancement.
        </p>
      </article>

      <article class="card faq-card">
        <h3>
          <i class="fas fa-hourglass-end"></i> Quelle sera la fréquence ?
        </h3>
        <p>
          Un nouvel épisode chaque mardi matin. 20-30 minutes d'expertise et d'analyses. Régulier et prévisible.
        </p>
      </article>

      <article class="card faq-card">
        <h3>
          <i class="fas fa-coins"></i> Le podcast sera-t-il gratuit ?
        </h3>
        <p>
          Oui ! Complètement gratuit. Aucun abonnement premium, aucun contenu réservé. Accès libre sur toutes les plateformes.
        </p>
      </article>

      <article class="card faq-card">
        <h3>
          <i class="fas fa-share-alt"></i> Puis-je proposer un thème d'épisode ?
        </h3>
        <p>
          Absolument ! Vos suggestions sont bienvenues. Contactez-nous via le formulaire de contact. Les meilleur thèmes seront couverts.
        </p>
      </article>

      <article class="card faq-card">
        <h3>
          <i class="fas fa-download"></i> Puis-je télécharger les épisodes ?
        </h3>
        <p>
          Oui, sur tous les lecteurs de podcast standards. Vous pouvez télécharger les MP3 pour écouter hors ligne aussi.
        </p>
      </article>

      <article class="card faq-card">
        <h3>
          <i class="fas fa-search"></i> Y aura-t-il des transcriptions ?
        </h3>
        <p>
          Oui ! Chaque épisode sera transcrit intégralement. Utile pour relire, chercher une info spécifique ou pour l'accessibilité.
        </p>
      </article>
    </div>
  </div>
</section>

<!-- ================================================ -->
<!-- CTA FINAL -->
<!-- ================================================ -->
<section class="section section-alt">
  <div class="container">
    <div class="cta-final card">
      <p class="eyebrow">
        <i class="fas fa-bell"></i> Ne Manquez pas le Lancement !
      </p>
      <h2>Rejoignez la liste d'attente</h2>
      <p class="lead">
        Soyez parmi les premiers à écouter notre podcast dès sa sortie. Notifications du lancement + accès prioritaire aux bonus exclusifs.
      </p>
      <a href="#form-waitlist" class="btn btn-primary">
        <i class="fas fa-paper-plane"></i> S'inscrire maintenant
      </a>
    </div>
  </div>
</section>

<script>
  // Scroll to form on button click
  (function () {
    const ctaButton = document.querySelector('.cta-final .btn-primary');
    if (!ctaButton) return;

    ctaButton.addEventListener('click', function(e) {
      e.preventDefault();
      const form = document.querySelector('form[action="/podcast"]');
      form?.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
  })();
</script>
