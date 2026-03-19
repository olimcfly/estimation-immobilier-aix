<?php
$page_title = 'Contact - Estimation Immobilière Lannion | Notre équipe locale';

$errors = [];
$success_message = '';
$form_data = [
  'nom' => '',
  'email' => '',
  'telephone' => '',
  'objet' => '',
  'message' => '',
  'website' => '',
  'captcha' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $form_data['nom'] = trim((string) ($_POST['nom'] ?? ''));
  $form_data['email'] = trim((string) ($_POST['email'] ?? ''));
  $form_data['telephone'] = trim((string) ($_POST['telephone'] ?? ''));
  $form_data['objet'] = trim((string) ($_POST['objet'] ?? ''));
  $form_data['message'] = trim((string) ($_POST['message'] ?? ''));
  $form_data['website'] = trim((string) ($_POST['website'] ?? ''));
  $form_data['captcha'] = trim((string) ($_POST['captcha'] ?? ''));

  // Honeypot anti-spam
  if ($form_data['website'] !== '') {
    $errors[] = 'Votre message a été identifié comme spam.';
  }

  if ($form_data['nom'] === '') {
    $errors[] = 'Le nom est obligatoire.';
  }

  if ($form_data['email'] === '' || !filter_var($form_data['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Veuillez renseigner une adresse email valide.';
  }

  if ($form_data['telephone'] !== '' && !preg_match('/^[0-9+().\-\s]{8,20}$/', $form_data['telephone'])) {
    $errors[] = 'Le numéro de téléphone semble invalide.';
  }

  if ($form_data['message'] === '' || mb_strlen($form_data['message']) < 10) {
    $errors[] = 'Le message doit contenir au moins 10 caractères.';
  }

  // Captcha simple
  if ($form_data['captcha'] !== '' && $form_data['captcha'] !== '7') {
    $errors[] = 'La vérification anti-robot est incorrecte.';
  }

  // Support optionnel reCAPTCHA
  $recaptcha_secret = getenv('RECAPTCHA_SECRET');
  $recaptcha_token = trim((string) ($_POST['g-recaptcha-response'] ?? ''));
  if ($recaptcha_secret && $recaptcha_token !== '') {
    $verify_context = stream_context_create([
      'http' => [
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => http_build_query([
          'secret' => $recaptcha_secret,
          'response' => $recaptcha_token,
          'remoteip' => $_SERVER['REMOTE_ADDR'] ?? null,
        ]),
        'timeout' => 6,
      ],
    ]);

    $verify_response = @file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $verify_context);
    $verify_data = $verify_response ? json_decode($verify_response, true) : null;
    if (!is_array($verify_data) || empty($verify_data['success'])) {
      $errors[] = 'La vérification reCAPTCHA a échoué. Merci de réessayer.';
    }
  }

  if (!$errors) {
    $to = getenv('CONTACT_OWNER_EMAIL') ?: 'contact@estimation-immobilier-lannion.fr';
    $subject = 'Nouveau message de contact - ' . htmlspecialchars($form_data['objet'], ENT_QUOTES, 'UTF-8');

    $safe_nom = htmlspecialchars($form_data['nom'], ENT_QUOTES, 'UTF-8');
    $safe_email = filter_var($form_data['email'], FILTER_SANITIZE_EMAIL);
    $safe_telephone = htmlspecialchars($form_data['telephone'], ENT_QUOTES, 'UTF-8');
    $safe_objet = htmlspecialchars($form_data['objet'], ENT_QUOTES, 'UTF-8');
    $safe_message = htmlspecialchars($form_data['message'], ENT_QUOTES, 'UTF-8');

    $body = "Nouveau message depuis le formulaire contact Lannion\n\n"
      . "Nom : {$safe_nom}\n"
      . "Email : {$safe_email}\n"
      . "Téléphone : {$safe_telephone}\n"
      . "Sujet : {$safe_objet}\n\n"
      . "Message :\n{$safe_message}\n";

    $headers = [
      'From: no-reply@estimation-immobilier-lannion.fr',
      'Reply-To: ' . $safe_email,
      'Content-Type: text/plain; charset=UTF-8',
    ];

    $mail_sent = @mail($to, $subject, $body, implode("\r\n", $headers));

    if ($mail_sent) {
      $success_message = 'Merci ! Votre message a bien été envoyé. Nous vous répondrons dans les 24 heures.';
      $form_data = [
        'nom' => '',
        'email' => '',
        'telephone' => '',
        'objet' => '',
        'message' => '',
        'website' => '',
        'captcha' => '',
      ];
    } else {
      $errors[] = 'Une erreur est survenue pendant l\'envoi. Merci de réessayer plus tard.';
    }
  }
}
?>

<section class="section page-hero">
  <div class="container">
    <div class="page-hero-inner">
      <p class="eyebrow">
        <i class="fas fa-envelope"></i> Contactez-nous
      </p>
      <h1>Parlons de votre projet immobilier</h1>
      <p class="lead">
        Nous sommes à votre écoute pour répondre à vos questions et vous accompagner dans votre estimation immobilière à Lannion.
      </p>
    </div>
  </div>
</section>

<!-- ================================================ -->
<!-- CONTACT LAYOUT - 2 COLUMNS -->
<!-- ================================================ -->
<section class="section">
  <div class="container">
    <div class="contact-layout">
      <!-- ============== COLONNE 1 : INFOS ============== -->
      <div>
        <div class="card contact-info">
          <h2 style="margin-top: 0;">
            <i class="fas fa-map-marker-alt"></i> Nos coordonnées
          </h2>

          <!-- Téléphone -->
          <div class="info-block">
            <p class="info-label">
              <i class="fas fa-phone"></i> Téléphone
            </p>
            <p class="info-value">
              <a href="tel:+33296053000">
                <strong>02 96 05 30 00</strong>
              </a>
            </p>
            <p style="font-size: var(--size-xs); color: var(--text-muted); margin: var(--space-2) 0 0 0;">
              Lun-Ven : 9h-18h | Sam : 10h-12h
            </p>
          </div>

          <!-- Email -->
          <div class="info-block">
            <p class="info-label">
              <i class="fas fa-envelope"></i> Email
            </p>
            <p class="info-value">
              <a href="mailto:contact@estimation-immobilier-lannion.fr">
                contact@estimation-immobilier-lannion.fr
              </a>
            </p>
            <p style="font-size: var(--size-xs); color: var(--text-muted); margin: var(--space-2) 0 0 0;">
              Réponse sous 24h
            </p>
          </div>

          <!-- Adresse -->
          <div class="info-block">
            <p class="info-label">
              <i class="fas fa-location-dot"></i> Adresse
            </p>
            <p class="info-value">
              5 Rue des Chapeliers<br>
              22300 Lannion<br>
              Bretagne, France
            </p>
          </div>

          <!-- Horaires -->
          <div class="info-block">
            <p class="info-label">
              <i class="fas fa-clock"></i> Horaires
            </p>
            <ul class="hours-list">
              <li>
                <span>Lundi - Vendredi</span>
                <strong>9h00 - 18h00</strong>
              </li>
              <li>
                <span>Samedi</span>
                <strong>10h00 - 12h00</strong>
              </li>
              <li>
                <span>Dimanche</span>
                <strong>Fermé</strong>
              </li>
            </ul>
          </div>
        </div>

        <!-- Réseaux sociaux -->
        <div class="card" style="margin-top: var(--space-6); padding: var(--space-6); text-align: center;">
          <h3 style="margin-top: 0; font-size: var(--size-lg);">
            <i class="fas fa-share-alt"></i> Nous suivre
          </h3>
          <div style="display: flex; justify-content: center; gap: var(--space-4); margin-top: var(--space-4);">
            <a href="#" class="btn btn-ghost" title="Facebook" style="width: 48px; height: 48px; padding: 0; display: flex; align-items: center; justify-content: center;">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="btn btn-ghost" title="Instagram" style="width: 48px; height: 48px; padding: 0; display: flex; align-items: center; justify-content: center;">
              <i class="fab fa-instagram"></i>
            </a>
            <a href="#" class="btn btn-ghost" title="LinkedIn" style="width: 48px; height: 48px; padding: 0; display: flex; align-items: center; justify-content: center;">
              <i class="fab fa-linkedin-in"></i>
            </a>
            <a href="#" class="btn btn-ghost" title="Twitter" style="width: 48px; height: 48px; padding: 0; display: flex; align-items: center; justify-content: center;">
              <i class="fab fa-twitter"></i>
            </a>
          </div>
        </div>

        <!-- Badges de confiance -->
        <div class="card" style="margin-top: var(--space-6); padding: var(--space-6); text-align: center;">
          <h3 style="margin-top: 0; font-size: var(--size-lg);">
            <i class="fas fa-shield-alt"></i> Garanties
          </h3>
          <div style="display: flex; flex-direction: column; gap: var(--space-3); margin-top: var(--space-4);">
            <div style="display: flex; align-items: center; gap: var(--space-2); font-size: var(--size-sm);">
              <i class="fas fa-lock" style="color: var(--success); font-weight: 700;"></i>
              <span>RGPD Conforme</span>
            </div>
            <div style="display: flex; align-items: center; gap: var(--space-2); font-size: var(--size-sm);">
              <i class="fas fa-check" style="color: var(--success); font-weight: 700;"></i>
              <span>Données sécurisées</span>
            </div>
            <div style="display: flex; align-items: center; gap: var(--space-2); font-size: var(--size-sm);">
              <i class="fas fa-zap" style="color: var(--success); font-weight: 700;"></i>
              <span>Réponse rapide</span>
            </div>
          </div>
        </div>
      </div>

      <!-- ============== COLONNE 2 : FORMULAIRE ============== -->
      <div>
        <div class="card contact-form-card" id="form-contact">
          <h2 style="margin-top: 0;">
            <i class="fas fa-comment-dots"></i> Envoyez un message
          </h2>

          <!-- Message de succès -->
          <?php if ($success_message): ?>
            <div class="alert alert-success" style="display: flex; align-items: flex-start; gap: var(--space-3); margin-bottom: var(--space-6);">
              <i class="fas fa-check-circle" style="flex-shrink: 0; margin-top: 2px; font-size: var(--size-lg);"></i>
              <div>
                <p style="margin: 0; font-weight: 600;">
                  <?= htmlspecialchars($success_message, ENT_QUOTES, 'UTF-8'); ?>
                </p>
              </div>
            </div>
          <?php endif; ?>

          <!-- Messages d'erreur -->
          <?php if ($errors): ?>
            <div style="background: var(--error-light); border: 1.5px solid var(--error); border-radius: var(--radius-lg); padding: var(--space-4); margin-bottom: var(--space-6);">
              <p style="margin: 0 0 var(--space-3) 0; font-weight: 600; color: var(--error); display: flex; align-items: center; gap: var(--space-2);">
                <i class="fas fa-exclamation-circle"></i> Veuillez corriger les erreurs suivantes :
              </p>
              <ul style="margin: 0; padding-left: var(--space-6); color: var(--error);">
                <?php foreach ($errors as $error): ?>
                  <li style="margin-bottom: var(--space-2); font-size: var(--size-sm);">
                    <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>

          <!-- Formulaire -->
          <form class="form-grid" action="/contact" method="post" novalidate>
            <!-- Nom -->
            <label for="nom" class="full-width">
              <span>
                <i class="fas fa-user"></i> Nom *
              </span>
              <input 
                type="text" 
                id="nom" 
                name="nom" 
                placeholder="Jean Dupont"
                required 
                value="<?= htmlspecialchars($form_data['nom'], ENT_QUOTES, 'UTF-8'); ?>"
              >
            </label>

            <!-- Email -->
            <label for="email" class="full-width">
              <span>
                <i class="fas fa-envelope"></i> Email *
              </span>
              <input 
                type="email" 
                id="email" 
                name="email" 
                placeholder="jean@exemple.com"
                required 
                value="<?= htmlspecialchars($form_data['email'], ENT_QUOTES, 'UTF-8'); ?>"
              >
            </label>

            <!-- Téléphone -->
            <label for="telephone">
              <span>
                <i class="fas fa-phone"></i> Téléphone
              </span>
              <input 
                type="tel" 
                id="telephone" 
                name="telephone" 
                placeholder="02 96 XX XX XX"
                value="<?= htmlspecialchars($form_data['telephone'], ENT_QUOTES, 'UTF-8'); ?>"
              >
            </label>

            <!-- Objet -->
            <label for="objet">
              <span>
                <i class="fas fa-tag"></i> Sujet *
              </span>
              <select id="objet" name="objet" required>
                <option value="" disabled <?= $form_data['objet'] === '' ? 'selected' : ''; ?>>
                  Choisir un sujet...
                </option>
                <option value="Estimation" <?= $form_data['objet'] === 'Estimation' ? 'selected' : ''; ?>>
                  <i class="fas fa-calculator"></i> Demande d'estimation
                </option>
                <option value="Information" <?= $form_data['objet'] === 'Information' ? 'selected' : ''; ?>>
                  <i class="fas fa-info-circle"></i> Information générale
                </option>
                <option value="Support" <?= $form_data['objet'] === 'Support' ? 'selected' : ''; ?>>
                  <i class="fas fa-headset"></i> Support client
                </option>
                <option value="Autre" <?= $form_data['objet'] === 'Autre' ? 'selected' : ''; ?>>
                  <i class="fas fa-ellipsis-h"></i> Autre
                </option>
              </select>
            </label>

            <!-- Message -->
            <label for="message" class="full-width">
              <span>
                <i class="fas fa-pen"></i> Message *
              </span>
              <textarea 
                id="message" 
                name="message" 
                rows="7" 
                placeholder="Décrivez votre projet ou vos questions..."
                required
              ><?= htmlspecialchars($form_data['message'], ENT_QUOTES, 'UTF-8'); ?></textarea>
            </label>

            <!-- Captcha -->
            <label for="captcha">
              <span>
                <i class="fas fa-shield-alt"></i> Vérification (optionnel)
              </span>
              <div style="display: flex; gap: var(--space-3); align-items: center;">
                <span style="background: var(--bg-alt); padding: var(--space-2) var(--space-3); border-radius: var(--radius-md); font-weight: 600; font-size: var(--size-base);">
                  3 + 4 = ?
                </span>
                <input 
                  type="text" 
                  id="captcha" 
                  name="captcha" 
                  inputmode="numeric"
                  placeholder="Votre réponse"
                  style="max-width: 120px;"
                  value="<?= htmlspecialchars($form_data['captcha'], ENT_QUOTES, 'UTF-8'); ?>"
                >
              </div>
            </label>

            <!-- Honeypot anti-spam (caché) -->
            <label for="website" style="position:absolute; left:-10000px; width:1px; height:1px; overflow:hidden;">
              Site web (laisser vide)
            </label>
            <input 
              type="text" 
              id="website" 
              name="website" 
              tabindex="-1" 
              autocomplete="off" 
              value="<?= htmlspecialchars($form_data['website'], ENT_QUOTES, 'UTF-8'); ?>" 
              style="position:absolute; left:-10000px; width:1px; height:1px; overflow:hidden;"
            >

            <!-- Bouton d'envoi -->
            <button type="submit" class="btn btn-primary full-width">
              <i class="fas fa-paper-plane"></i> Envoyer le message
            </button>

            <!-- Note -->
            <p style="font-size: var(--size-xs); color: var(--text-muted); margin: var(--space-3) 0 0 0; text-align: center;">
              Nous répondons à tous les messages sous 24h en jours ouvrables.
            </p>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ================================================ -->
<!-- CARTE GOOGLE -->
<!-- ================================================ -->
<section class="section section-alt">
  <div class="container">
    <div class="section-heading">
      <p class="eyebrow">
        <i class="fas fa-map-location-dot"></i> Nous Trouver
      </p>
      <h2>Localisation précise de nos bureaux</h2>
    </div>

    <div class="card" style="padding: 0; overflow: hidden; border-radius: var(--radius-xl);">
      <iframe
        title="Localisation - Estimation Immobilier Lannion"
        src="https://www.google.com/maps?q=Lannion%2022300&output=embed"
        width="100%"
        height="500"
        style="border: 0; display: block;"
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
        allowfullscreen>
      </iframe>
    </div>
  </div>
</section>

<!-- ================================================ -->
<!-- AVANTAGES DE NOUS CONTACTER -->
<!-- ================================================ -->
<section class="section">
  <div class="container">
    <div class="section-heading">
      <p class="eyebrow">
        <i class="fas fa-lightbulb"></i> Pourquoi Nous Contacter
      </p>
      <h2>Vos avantages</h2>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: var(--space-6);">
      <!-- Avantage 1 -->
      <article class="card feature-card">
        <div class="feature-icon">
          <i class="fas fa-hourglass-end"></i>
        </div>
        <h3>Réponse Rapide</h3>
        <p>
          Nous répondons à tous les messages sous 24h. Pas de délai inutile pour vos questions importantes.
        </p>
      </article>

      <!-- Avantage 2 -->
      <article class="card feature-card">
        <div class="feature-icon">
          <i class="fas fa-user-tie"></i>
        </div>
        <h3>Experts Locaux</h3>
        <p>
          Notre équipe connaît le marché immobilier de Lannion depuis plus de 25 ans. Expertise garantie.
        </p>
      </article>

      <!-- Avantage 3 -->
      <article class="card feature-card">
        <div class="feature-icon">
          <i class="fas fa-lock"></i>
        </div>
        <h3>Confidentialité</h3>
        <p>
          Vos données sont sécurisées et ne seront jamais partagées. RGPD 100% conforme.
        </p>
      </article>

      <!-- Avantage 4 -->
      <article class="card feature-card">
        <div class="feature-icon">
          <i class="fas fa-handshake"></i>
        </div>
        <h3>Engagement Personnel</h3>
        <p>
          Chaque client est important pour nous. Nous vous accompagnons vraiment dans votre projet.
        </p>
      </article>

      <!-- Avantage 5 -->
      <article class="card feature-card">
        <div class="feature-icon">
          <i class="fas fa-chart-line"></i>
        </div>
        <h3>Transparence</h3>
        <p>
          Pas de frais cachés. Toutes nos méthodologies et prix sont expliqués clairement.
        </p>
      </article>

      <!-- Avantage 6 -->
      <article class="card feature-card">
        <div class="feature-icon">
          <i class="fas fa-star"></i>
        </div>
        <h3>Satisfaction Client</h3>
        <p>
          4.8/5 de note moyenne. Plus de 3 800 clients satisfaits depuis 2023.
        </p>
      </article>
    </div>
  </div>
</section>

<!-- ================================================ -->
<!-- FAQ CONTACT -->
<!-- ================================================ -->
<section class="section section-alt">
  <div class="container">
    <div class="section-heading">
      <p class="eyebrow">
        <i class="fas fa-question-circle"></i> Questions Fréquentes
      </p>
      <h2>On répond à vos questions</h2>
    </div>

    <div class="faq-grid">
      <article class="card faq-card">
        <h3>
          <i class="fas fa-envelope"></i> Comment me contacter ?
        </h3>
        <p>
          Trois moyens : par téléphone (02 96 05 30 00), par email (contact@...), ou via ce formulaire. Nous répondons en priorité au mode choisi.
        </p>
      </article>

      <article class="card faq-card">
        <h3>
          <i class="fas fa-clock"></i> Quel est le meilleur moment ?
        </h3>
        <p>
          Nous sommes disponibles lundi-vendredi 9h-18h et samedi 10h-12h. Les messages reçus hors horaires sont traités le jour ouvrable suivant.
        </p>
      </article>

      <article class="card faq-card">
        <h3>
          <i class="fas fa-timer"></i> En combien de temps aurez-vous une réponse ?
        </h3>
        <p>
          Nous répondons à 95% des messages dans les 2h en heures ouvrables. Maximum 24h pour les questions plus complexes.
        </p>
      </article>

      <article class="card faq-card">
        <h3>
          <i class="fas fa-lock"></i> Mes données sont-elles sécurisées ?
        </h3>
        <p>
          Oui. Chiffrement SSL/TLS systématique, RGPD conforme, aucune vente de données. Votre confidentialité est notre priorité.
        </p>
      </article>

      <article class="card faq-card">
        <h3>
          <i class="fas fa-phone"></i> Puis-je appeler directement ?
        </h3>
        <p>
          Absolument ! Le téléphone (02 96 05 30 00) est parfois plus rapide pour une question simple. N'hésitez pas.
        </p>
      </article>

      <article class="card faq-card">
        <h3>
          <i class="fas fa-globe"></i> Livrez-vous en dehors de Lannion ?
        </h3>
        <p>
          Oui, nous couvrons toute la région Bretagne. Nos services d'estimation s'appliquent à Lannion et commune environnantes.
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
        <i class="fas fa-rocket"></i> Prêt à connaître la valeur de votre bien ?
      </p>
      <h2>Commencez votre estimation gratuite</h2>
      <p class="lead">
        Pas besoin de contact préalable. Faites une estimation en 3 minutes ou posez vos questions directement.
      </p>
      <div style="display: flex; flex-wrap: wrap; gap: var(--space-4); justify-content: center; margin-top: var(--space-6);">
        <a href="/estimation#form-estimation" class="btn btn-primary">
          <i class="fas fa-calculator"></i> Estimer mon bien
        </a>
        <a href="#form-contact" class="btn btn-secondary">
          <i class="fas fa-envelope"></i> Poser une question
        </a>
      </div>
    </div>
  </div>
</section>

<script>
  // Form interactions
  (function () {
    const form = document.querySelector('form[action="/contact"]');
    const inputs = form ? form.querySelectorAll('input, textarea, select') : [];

    inputs.forEach(input => {
      // Add focus effects
      input.addEventListener('focus', function() {
        this.parentElement.style.transform = 'scale(1.01)';
      });

      input.addEventListener('blur', function() {
        this.parentElement.style.transform = 'scale(1)';
      });
    });

    // Smooth scroll to form on error
    if (document.querySelector('.alert-error')) {
      document.getElementById('form-contact')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  })();
</script>
