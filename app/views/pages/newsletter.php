<?php 
$page_title = 'Newsletter - Estimation Immobilière Lannion | Conseils & Tendances Immobiliers';

$newsletter_errors = [];
$newsletter_success_message = '';
$newsletter_form_data = [
  'newsletter_email' => '',
  'newsletter_website' => '',
  'newsletter_acceptation' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['newsletter_email'])) {
  $newsletter_form_data['newsletter_email'] = trim((string) ($_POST['newsletter_email'] ?? ''));
  $newsletter_form_data['newsletter_website'] = trim((string) ($_POST['newsletter_website'] ?? ''));
  $newsletter_form_data['newsletter_acceptation'] = trim((string) ($_POST['newsletter_acceptation'] ?? ''));

  // Honeypot anti-spam
  if ($newsletter_form_data['newsletter_website'] !== '') {
    $newsletter_errors[] = 'Votre souscription a été identifiée comme spam.';
  }

  if ($newsletter_form_data['newsletter_email'] === '' || !filter_var($newsletter_form_data['newsletter_email'], FILTER_VALIDATE_EMAIL)) {
    $newsletter_errors[] = 'Veuillez renseigner une adresse email valide.';
  }

  if ($newsletter_form_data['newsletter_acceptation'] !== 'on') {
    $newsletter_errors[] = 'Vous devez accepter de recevoir la newsletter pour vous inscrire.';
  }

  if (!$newsletter_errors) {
    $to = getenv('NEWSLETTER_EMAIL') ?: 'newsletter@estimation-immobilier-lannion.fr';
    $subject = 'Nouvelle inscription newsletter - Lannion';

    $safe_email = filter_var($newsletter_form_data['newsletter_email'], FILTER_SANITIZE_EMAIL);

    $body = "Nouvelle inscription à la newsletter\n\n"
      . "Email : {$safe_email}\n"
      . "Date d'inscription : " . date('Y-m-d H:i:s') . "\n";

    $headers = [
      'From: no-reply@estimation-immobilier-lannion.fr',
      'Content-Type: text/plain; charset=UTF-8',
    ];

    $mail_sent = @mail($to, $subject, $body, implode("\r\n", $headers));

    if ($mail_sent) {
      $newsletter_success_message = 'Bienvenue ! Consultez votre email pour confirmer votre inscription.';
      $newsletter_form_data = [
        'newsletter_email' => '',
        'newsletter_website' => '',
        'newsletter_acceptation' => '',
      ];
    } else {
      $newsletter_errors[] = 'Une erreur est survenue. Merci de réessayer plus tard.';
    }
  }
}
?>

<section class="section page-hero">
  <div class="container">
    <div class="page-hero-inner">
      <p class="eyebrow">
        <i class="fas fa-envelope-open-text"></i> Newsletter
      </p>
      <h1>Recevez nos conseils immobiliers chaque semaine</h1>
      <p class="lead">
        Analyses du marché, tendances des prix, conseils de vente et alertes sur votre quartier. 100% gratuit, pas de spam.
      </p>
    </div>
  </div>
</section>

<!-- ================================================ -->
<!-- FORMULAIRE D'INSCRIPTION -->
<!-- ================================================ -->
<section class="section">
  <div class="container" style="max-width: 700px;">
    <div class="card" style="padding: var(--space-8);">
      <h2 style="margin-top: 0; text-align: center; margin-bottom: var(--space-2);">
        <i class="fas fa-bell"></i> S'abonner à la newsletter
      </h2>
      <p style="text-align: center; color: var(--text-secondary); margin-bottom: var(--space-6);">
        Recevez nos analyses du marché et conseils de vente. Un email par semaine, le mardi matin.
      </p>

      <!-- Message de succès -->
      <?php if ($newsletter_success_message): ?>
        <div class="alert alert-success" style="display: flex; align-items: flex-start; gap: var(--space-3); margin-bottom: var(--space-6);">
          <i class="fas fa-check-circle" style="flex-shrink: 0; margin-top: 2px; font-size: var(--size-lg);"></i>
          <div>
            <p style="margin: 0; font-weight: 600;">
              <?= htmlspecialchars($newsletter_success_message, ENT_QUOTES, 'UTF-8'); ?>
            </p>
            <p style="margin: var(--space-2) 0 0 0; font-size: var(--size-sm); color: inherit;">
              Pensez à vérifier votre dossier spam si vous ne recevez pas le mail de confirmation.
            </p>
          </div>
        </div>
      <?php endif; ?>

      <!-- Messages d'erreur -->
      <?php if ($newsletter_errors): ?>
        <div style="background: var(--error-light); border: 1.5px solid var(--error); border-radius: var(--radius-lg); padding: var(--space-4); margin-bottom: var(--space-6);">
          <ul style="margin: 0; padding-left: var(--space-6); color: var(--error);">
            <?php foreach ($newsletter_errors as $error): ?>
              <li style="margin-bottom: var(--space-2); font-size: var(--size-sm);">
                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <!-- Formulaire -->
      <form class="form-grid" action="/newsletter" method="post" novalidate style="gap: var(--space-4);">
        <!-- Email -->
        <label for="newsletter_email" class="full-width">
          <span>
            <i class="fas fa-envelope"></i> Votre email *
          </span>
          <input 
            type="email" 
            id="newsletter_email" 
            name="newsletter_email" 
            placeholder="vous@exemple.com" 
            required
            value="<?= htmlspecialchars($newsletter_form_data['newsletter_email'], ENT_QUOTES, 'UTF-8'); ?>"
          >
        </label>

        <!-- Acceptation RGPD -->
        <div class="form-checkbox full-width">
          <input 
            type="checkbox" 
            id="newsletter_acceptation" 
            name="newsletter_acceptation" 
            required
            <?= $newsletter_form_data['newsletter_acceptation'] === 'on' ? 'checked' : ''; ?>
          >
          <label for="newsletter_acceptation" style="margin: 0; font-weight: 500; font-size: var(--size-sm); color: var(--text); cursor: pointer;">
            J'accepte de recevoir la newsletter et je peux me désinscrire à tout moment. Nous respectons votre vie privée.
          </label>
        </div>

        <!-- Honeypot -->
        <label for="newsletter_website" style="position:absolute; left:-10000px; width:1px; height:1px; overflow:hidden;">
          Site web
        </label>
        <input 
          type="text" 
          id="newsletter_website" 
          name="newsletter_website" 
          tabindex="-1" 
          autocomplete="off"
          value="<?= htmlspecialchars($newsletter_form_data['newsletter_website'], ENT_QUOTES, 'UTF-8'); ?>"
          style="position:absolute; left:-10000px; width:1px; height:1px; overflow:hidden;"
        >

        <!-- Bouton -->
        <button type="submit" class="btn btn-primary full-width">
          <i class="fas fa-check-circle"></i> Je m'abonne (gratuit)
        </button>
      </form>

      <!-- Notes de confiance -->
      <div style="display: flex; justify-content: space-around; margin-top: var(--space-8); padding-top: var(--space-6); border-top: 1px solid var(--border);">
        <div style="text-align: center; font-size: var(--size-xs); color: var(--text-muted);">
          <i class="fas fa-lock" style="color: var(--success); font-size: var(--size-lg); display: block; margin-bottom: var(--space-1);"></i>
          Sécurisé
        </div>
        <div style="text-align: center; font-size: var(--size-xs); color: var(--text-muted);">
          <i class="fas fa-times" style="color: var(--error); font-size: var(--size-lg); display: block; margin-bottom: var(--space-1);"></i>
          Pas de spam
        </div>
        <div style="text-align: center; font-size: var(--size-xs); color: var(--text-muted);">
          <i class="fas fa-link-slash" style="color: var(--success); font-size: var(--size-lg); display: block; margin-bottom: var(--space-1);"></i>
          Facile à quitter
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ================================================ -->
<!-- CE QUE VOUS RECEVREZ -->
<!-- ================================================ -->
<section class="section section-alt">
  <div class="container">
    <div class="section-heading">
      <p class="eyebrow">
        <i class="fas fa-gift"></i> Ce que vous recevrez
      </p>
      <h2>Chaque semaine, du contenu utile</h2>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: var(--space-6);">
      <!-- Type 1 -->
      <article class="card feature-card">
        <div class="feature-icon">
          <i class="fas fa-chart-line"></i>
        </div>
        <h3>Analyses Marché</h3>
        <p>
          Tendances des prix à Lannion et région. Quels quartiers montent ? Où investir ? Données actualisées chaque semaine.
        </p>
      </article>

      <!-- Type 2 -->
      <article class="card feature-card">
        <div class="feature-icon">
          <i class="fas fa-home"></i>
        </div>
        <h3>Conseils de Vente</h3>
        <p>
          Comment valoriser votre bien ? Erreurs à éviter, staging, pricing. Retours d'expérience concrets et applicables.
        </p>
      </article>

      <!-- Type 3 -->
      <article class="card feature-card">
        <div class="feature-icon">
          <i class="fas fa-bell"></i>
        </div>
        <h3>Alertes & Nouveautés</h3>
        <p>
          Nouveaux bien, changements de tendance, événements locaux. Restez informé avant tout le monde.
        </p>
      </article>

      <!-- Type 4 -->
      <article class="card feature-card">
        <div class="feature-icon">
          <i class="fas fa-map-location-dot"></i>
        </div>
        <h3>Guides Quartiers</h3>
        <p>
          Deep dives sur les quartiers. Démographie, commerces, transports, ambiance. Tout pour bien connaître votre secteur.
        </p>
      </article>

      <!-- Type 5 -->
      <article class="card feature-card">
        <div class="feature-icon">
          <i class="fas fa-lightbulb"></i>
        </div>
        <h3>Astuces & Bonnes Pratiques</h3>
        <p>
          Les secrets des meilleures ventes. Petits trucs qui font la différence. Savoir-faire accumulé depuis 25 ans.
        </p>
      </article>

      <!-- Type 6 -->
      <article class="card feature-card">
        <div class="feature-icon">
          <i class="fas fa-envelope"></i>
        </div>
        <h3>Exclusivités Abonnés</h3>
        <p>
          Accès en avant-première à nouvelles fonctionnalités, réductions spéciales, contenu réservé. Avantage VIP.
        </p>
      </article>
    </div>
  </div>
</section>

<!-- ================================================ -->
<!-- FRÉQUENCE & FORMAT -->
<!-- ================================================ -->
<section class="section">
  <div class="container" style="max-width: 800px;">
    <div class="section-heading">
      <p class="eyebrow">
        <i class="fas fa-calendar"></i> Fréquence
      </p>
      <h2>Un email par semaine, le mardi matin</h2>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: var(--space-6);">
      <!-- Fréquence 1 -->
      <div class="card" style="padding: var(--space-6); text-align: center;">
        <div style="font-size: var(--size-4xl); color: var(--accent); margin-bottom: var(--space-3);">
          1x
        </div>
        <h3 style="margin: 0 0 var(--space-2) 0; font-size: var(--size-lg);">Par Semaine</h3>
        <p style="margin: 0; color: var(--text-secondary); font-size: var(--size-sm);">
          Un seul email le mardi matin. Pas d'inondation de messages.
        </p>
      </div>

      <!-- Fréquence 2 -->
      <div class="card" style="padding: var(--space-6); text-align: center;">
        <div style="font-size: var(--size-4xl); color: var(--accent); margin-bottom: var(--space-3);">
          5-7 min
        </div>
        <h3 style="margin: 0 0 var(--space-2) 0; font-size: var(--size-lg);">Durée Moyenne</h3>
        <p style="margin: 0; color: var(--text-secondary); font-size: var(--size-sm);">
          Contenu condensé et précis. Pas de blabla inutile.
        </p>
      </div>

      <!-- Fréquence 3 -->
      <div class="card" style="padding: var(--space-6); text-align: center;">
        <div style="font-size: var(--size-4xl); color: var(--accent); margin-bottom: var(--space-3);">
          ∞
        </div>
        <h3 style="margin: 0 0 var(--space-2) 0; font-size: var(--size-lg);">Pratique</h3>
        <p style="margin: 0; color: var(--text-secondary); font-size: var(--size-sm);">
          Applicable immédiatement. Chaque conseil a une valeur directe.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- ================================================ -->
<!-- TÉMOIGNAGES -->
<!-- ================================================ -->
<section class="section section-alt">
  <div class="container">
    <div class="section-heading">
      <p class="eyebrow">
        <i class="fas fa-star"></i> Témoignages
      </p>
      <h2>Ce que disent nos abonnés</h2>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: var(--space-6);">
      <!-- Témoignage 1 -->
      <article class="card" style="padding: var(--space-6); border-left: 4px solid var(--accent);">
        <div style="display: flex; align-items: center; gap: var(--space-2); margin-bottom: var(--space-3);">
          <div style="color: var(--accent); font-size: var(--size-lg);">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
          </div>
        </div>
        <p style="margin: 0 0 var(--space-3) 0; font-size: var(--size-sm); color: var(--text);">
          "Les conseils de la newsletter m'ont permis de vendre ma maison 15% plus cher. Les astuces sur la présentation du bien étaient vraiment utiles !"
        </p>
        <p style="margin: 0; font-weight: 600; color: var(--primary); font-size: var(--size-sm);">
          Mélanie R., Lannion
        </p>
      </article>

      <!-- Témoignage 2 -->
      <article class="card" style="padding: var(--space-6); border-left: 4px solid var(--accent);">
        <div style="display: flex; align-items: center; gap: var(--space-2); margin-bottom: var(--space-3);">
          <div style="color: var(--accent); font-size: var(--size-lg);">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
          </div>
        </div>
        <p style="margin: 0 0 var(--space-3) 0; font-size: var(--size-sm); color: var(--text);">
          "Restez informé sur les tendances du marché sans passer des heures sur Internet. Email parfait, court et précis. Exactement ce qu'il me fallait !"
        </p>
        <p style="margin: 0; font-weight: 600; color: var(--primary); font-size: var(--size-sm);">
          Pierre D., Trégor
        </p>
      </article>

      <!-- Témoignage 3 -->
      <article class="card" style="padding: var(--space-6); border-left: 4px solid var(--accent);">
        <div style="display: flex; align-items: center; gap: var(--space-2); margin-bottom: var(--space-3);">
          <div style="color: var(--accent); font-size: var(--size-lg);">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
          </div>
        </div>
        <p style="margin: 0 0 var(--space-3) 0; font-size: var(--size-sm); color: var(--text);">
          "Excellent service ! La newsletter est informatif et pratique. J'ai recommandé à mes amis. Continuez comme ça !"
        </p>
        <p style="margin: 0; font-weight: 600; color: var(--primary); font-size: var(--size-sm);">
          Valérie T., Brélévenez
        </p>
      </article>
    </div>
  </div>
</section>

<!-- ================================================ -->
<!-- EXEMPLE D'EMAIL -->
<!-- ================================================ -->
<section class="section">
  <div class="container">
    <div class="section-heading">
      <p class="eyebrow">
        <i class="fas fa-envelope"></i> Aperçu
      </p>
      <h2>À quoi ressemble un email de notre newsletter</h2>
    </div>

    <div class="card" style="padding: var(--space-8); background: linear-gradient(135deg, #f9fafb 0%, #ffffff 100%);">
      <!-- Mock email -->
      <div style="max-width: 600px; margin: 0 auto; border: 1px solid var(--border); border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-lg);">
        <!-- Header -->
        <div style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); padding: var(--space-6); text-align: center; color: white;">
          <h2 style="margin: 0; font-family: var(--font-primary); font-size: var(--size-2xl);">
            📊 Newsletter Lannion
          </h2>
          <p style="margin: var(--space-2) 0 0 0; font-size: var(--size-sm); opacity: 0.9;">
            Semaine du 15 janvier 2024
          </p>
        </div>

        <!-- Contenu -->
        <div style="padding: var(--space-6);">
          <!-- Titre 1 -->
          <h3 style="margin: 0 0 var(--space-2) 0; color: var(--primary);">
            📈 Analyse : Prix en hausse de +4.2% à Lannion
          </h3>
          <p style="margin: 0 0 var(--space-4) 0; color: var(--text-secondary); font-size: var(--size-sm); line-height: var(--line-lg);">
            Le prix moyen au m² atteint 3 100 €. Port et Centre-Ville tirent la tendance. Les bonnes affaires se font rares.
          </p>

          <hr style="border: none; border-top: 1px solid var(--border); margin: var(--space-4) 0;">

          <!-- Titre 2 -->
          <h3 style="margin: var(--space-4) 0 var(--space-2) 0; color: var(--primary);">
            💡 Conseil : 5 astuces pour vendre plus cher
          </h3>
          <ul style="margin: 0 0 var(--space-4) 0; padding-left: var(--space-6); color: var(--text-secondary); font-size: var(--size-sm); line-height: var(--line-lg);">
            <li>Parking : point clé souvent oublié</li>
            <li>Lumière naturelle : montrez-la bien</li>
            <li>Photos : investir dans un photographe</li>
            <li>Timing : vendre en printemps rapporte 8% plus</li>
            <li>Staging : rendre neutre et attrayant</li>
          </ul>

          <hr style="border: none; border-top: 1px solid var(--border); margin: var(--space-4) 0;">

          <!-- CTA -->
          <div style="background: var(--bg-alt); border-radius: var(--radius-lg); padding: var(--space-4); text-align: center;">
            <p style="margin: 0 0 var(--space-3) 0; font-weight: 600; color: var(--text);">
              Prêt à estimer votre bien ?
            </p>
            <a href="#" style="display: inline-block; background: var(--primary); color: white; padding: var(--space-2) var(--space-4); border-radius: var(--radius-lg); text-decoration: none; font-weight: 600; font-size: var(--size-sm);">
              Commencer une estimation
            </a>
          </div>
        </div>

        <!-- Footer -->
        <div style="background: var(--bg-alt); padding: var(--space-4); text-align: center; font-size: var(--size-xs); color: var(--text-muted); border-top: 1px solid var(--border);">
          <p style="margin: 0 0 var(--space-2) 0;">
            Estimation Immobilier Lannion | 5 Rue des Chapeliers, 22300 Lannion
          </p>
          <p style="margin: 0;">
            <a href="#" style="color: var(--primary); text-decoration: none;">Se désabonner</a> | 
            <a href="#" style="color: var(--primary); text-decoration: none;">Nous contacter</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ================================================ -->
<!-- FAQ NEWSLETTER -->
<!-- ================================================ -->
<section class="section section-alt">
  <div class="container">
    <div class="section-heading">
      <p class="eyebrow">
        <i class="fas fa-question-circle"></i> Questions
      </p>
      <h2>Questions fréquentes</h2>
    </div>

    <div class="faq-grid">
      <article class="card faq-card">
        <h3>
          <i class="fas fa-envelope"></i> À quelle fréquence recevrai-je des emails ?
        </h3>
        <p>
          Un email chaque mardi matin, c'est tout. Pas d'inondation. Juste du contenu dense et utile pour vous.
        </p>
      </article>

      <article class="card faq-card">
        <h3>
          <i class="fas fa-lock"></i> Mes données sont-elles sécurisées ?
        </h3>
        <p>
          Absolument. RGPD conforme, chiffrement SSL/TLS. Vos données ne sont jamais vendues ou partagées. Confidentialité garantie.
        </p>
      </article>

      <article class="card faq-card">
        <h3>
          <i class="fas fa-link-slash"></i> Comment me désabonner ?
        </h3>
        <p>
          Un lien de désabonnement est présent en bas de chaque email. Un seul clic et c'est fini, sans complications.
        </p>
      </article>

      <article class="card faq-card">
        <h3>
          <i class="fas fa-coins"></i> C'est payant ?
        </h3>
        <p>
          Non ! La newsletter est 100% gratuite. Aucun coût caché, aucun upsell agressif. Du contenu utile, c'est tout.
        </p>
      </article>

      <article class="card faq-card">
        <h3>
          <i class="fas fa-pen"></i> Puis-je modifier mes préférences ?
        </h3>
        <p>
          Plus tard, oui ! Après quelques emails, vous pourrez choisir les thèmes qui vous intéressent (prix, conseils, etc.).
        </p>
      </article>

      <article class="card faq-card">
        <h3>
          <i class="fas fa-user-check"></i> L'inscription est rapide ?
        </h3>
        <p>
          30 secondes ! Email + confirmation. C'est tout. Pas de formulaire à rallonge. Inscription express.
        </p>
      </article>
    </div>
  </div>
</section>

<!-- ================================================ -->
<!-- GARANTIE -->
<!-- ================================================ -->
<section class="section">
  <div class="container" style="max-width: 700px;">
    <div class="card" style="padding: var(--space-8); background: linear-gradient(135deg, rgba(0, 63, 135, 0.05) 0%, rgba(255, 215, 0, 0.05) 100%); text-align: center;">
      <h2 style="margin-top: 0;">
        <i class="fas fa-handshake"></i> Notre Garantie
      </h2>
      <p style="color: var(--text-secondary); margin-bottom: var(--space-4);">
        Si la newsletter ne vous convient pas dans les 7 jours, vous pouvez vous désabonner sans raison, sans honte.
      </p>
      <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: var(--space-3); margin-bottom: var(--space-4);">
        <span class="badge badge-success">
          <i class="fas fa-check"></i> Gratuit
        </span>
        <span class="badge badge-success">
          <i class="fas fa-times"></i> Pas de spam
        </span>
        <span class="badge badge-success">
          <i class="fas fa-lock"></i> Sécurisé
        </span>
      </div>
      <p style="font-size: var(--size-sm); color: var(--text-muted); margin: 0;">
        Nous pensons vraiment que cette newsletter vous plaira. Mais si ce n'est pas le cas, zéro problème.
      </p>
    </div>
  </div>
</section>

<!-- ================================================ -->
<!-- CTA FINAL -->
<!-- ================================================ -->
<section class="section section-alt">
  <div class="container" style="max-width: 700px;">
    <div class="cta-final card">
      <p class="eyebrow">
        <i class="fas fa-rocket"></i> Prêt à rester informé ?
      </p>
      <h2>Rejoignez 1 500+ abonnés</h2>
      <p class="lead">
        Un email par semaine, du vrai contenu utile. Aucun spam, aucun engagement long. Juste l'essentiel immobilier de Lannion.
      </p>
      <a href="#form-newsletter" class="btn btn-primary">
        <i class="fas fa-bell"></i> M'abonner (gratuit)
      </a>
    </div>
  </div>
</section>

<script>
  // Newsletter form smooth behavior
  (function () {
    const form = document.querySelector('form[action="/newsletter"]');
    if (!form) return;

    const inputs = form.querySelectorAll('input');
    inputs.forEach(input => {
      input.addEventListener('focus', function() {
        if (this.type === 'email' || this.type === 'checkbox') {
          this.parentElement.style.transform = 'scale(1.01)';
        }
      });

      input.addEventListener('blur', function() {
        this.parentElement.style.transform = 'scale(1)';
      });
    });
  })();
</script>
