<?php
$page_title = 'Contact - Estimation Immobilière Lannion | Notre équipe locale';

$errors = [];
$success_message = '';
$form_data = [
  'nom' => '',
  'email' => '',
  'telephone' => '',
  'message' => '',
  'website' => '',
  'captcha' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $form_data['nom'] = trim((string) ($_POST['nom'] ?? ''));
  $form_data['email'] = trim((string) ($_POST['email'] ?? ''));
  $form_data['telephone'] = trim((string) ($_POST['telephone'] ?? ''));
  $form_data['message'] = trim((string) ($_POST['message'] ?? ''));
  $form_data['website'] = trim((string) ($_POST['website'] ?? ''));
  $form_data['captcha'] = trim((string) ($_POST['captcha'] ?? ''));

  // Honeypot anti-spam : ce champ doit rester vide.
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

  // Captcha simple (optionnel mais recommandé)
  if ($form_data['captcha'] !== '' && $form_data['captcha'] !== '7') {
    $errors[] = 'La vérification anti-robot est incorrecte.';
  }

  // Support optionnel reCAPTCHA v2/v3 si configuré côté serveur.
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
    $subject = 'Nouveau message de contact - Lannion';

    $safe_nom = htmlspecialchars($form_data['nom'], ENT_QUOTES, 'UTF-8');
    $safe_email = filter_var($form_data['email'], FILTER_SANITIZE_EMAIL);
    $safe_telephone = htmlspecialchars($form_data['telephone'], ENT_QUOTES, 'UTF-8');
    $safe_message = htmlspecialchars($form_data['message'], ENT_QUOTES, 'UTF-8');

    $body = "Nouveau message depuis le formulaire contact Lannion\n\n"
      . "Nom : {$safe_nom}\n"
      . "Email : {$safe_email}\n"
      . "Téléphone : {$safe_telephone}\n\n"
      . "Message :\n{$safe_message}\n";

    $headers = [
      'From: no-reply@estimation-immobilier-lannion.fr',
      'Reply-To: ' . $safe_email,
      'Content-Type: text/plain; charset=UTF-8',
    ];

    $mail_sent = @mail($to, $subject, $body, implode("\r\n", $headers));

    if ($mail_sent) {
      $success_message = 'Merci, votre message a bien été envoyé. Nous vous répondrons rapidement.';
      $form_data = [
        'nom' => '',
        'email' => '',
        'telephone' => '',
        'message' => '',
        'website' => '',
        'captcha' => '',
      ];
    } else {
      $errors[] = 'Une erreur est survenue pendant l’envoi. Merci de réessayer plus tard.';
    }
  }
}
?>

<section class="section page-hero">
  <div class="container">
    <div class="page-hero-inner card">
      <p class="eyebrow"><i class="fas fa-envelope"></i> Contact Lannion</p>
      <h1>Contactez-nous à Lannion</h1>
      <p class="lead">
        Nous sommes à votre écoute pour répondre à toutes vos questions concernant l'estimation et la vente de votre bien immobilier à Lannion.
      </p>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="contact-layout">
      <article class="card contact-info">
        <h2><i class="fas fa-map-marker-alt"></i> Nos coordonnées</h2>

        <div class="info-block">
          <p class="info-label"><i class="fas fa-phone"></i> Téléphone direct</p>
          <p class="info-value"><a href="tel:+33296000000">02 96 00 00 00</a></p>
        </div>
      </article>

        <div class="info-block">
          <p class="info-label"><i class="fas fa-envelope"></i> Email contact</p>
          <p class="info-value">
            <a href="mailto:contact@estimation-immobilier-lannion.fr">contact@estimation-immobilier-lannion.fr</a>
          </p>
        </div>

        <div class="info-block">
          <p class="info-label"><i class="fas fa-map-marker-alt"></i> Adresse locale</p>
          <p class="info-value">
            5 Rue des Chapeliers<br>
            22300 Lannion<br>
            France
          </p>
        </div>

        <div class="info-block">
          <p class="info-label"><i class="fas fa-clock"></i> Horaires d'ouverture</p>
          <ul class="hours-list">
            <li><span>Lundi - Vendredi :</span> <strong>9h - 18h</strong></li>
            <li><span>Samedi :</span> <strong>10h - 12h</strong></li>
            <li><span>Dimanche :</span> <strong>Fermé</strong></li>
          </ul>
        </div>
      </article>

      <article class="card contact-form-card" id="form-contact">
        <h2><i class="fas fa-comment-dots"></i> Envoyez-nous un message</h2>

        <?php if ($success_message): ?>
          <p class="form-intro" style="color: #1a7f37;"><i class="fas fa-check-circle"></i> <?= htmlspecialchars($success_message, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>

        <?php if ($errors): ?>
          <div class="card" style="background: #fff5f5; border: 1px solid #fecaca; margin-bottom: 1rem;">
            <p style="margin: 0 0 0.5rem 0;"><strong>Merci de corriger les points suivants :</strong></p>
            <ul style="margin: 0; padding-left: 1.2rem;">
              <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>

        <form class="form-grid form-contact" action="/contact" method="post" novalidate>
          <label for="nom" class="full-width">
            <span><i class="fas fa-user"></i> Nom *</span>
            <input type="text" id="nom" name="nom" required value="<?= htmlspecialchars($form_data['nom'], ENT_QUOTES, 'UTF-8'); ?>">
          </label>

          <label for="email" class="full-width">
            <span><i class="fas fa-envelope"></i> Email *</span>
            <input type="email" id="email" name="email" required value="<?= htmlspecialchars($form_data['email'], ENT_QUOTES, 'UTF-8'); ?>">
          </label>

          <label for="telephone" class="full-width">
            <span><i class="fas fa-phone"></i> Téléphone</span>
            <input type="tel" id="telephone" name="telephone" placeholder="02 96 XX XX XX" value="<?= htmlspecialchars($form_data['telephone'], ENT_QUOTES, 'UTF-8'); ?>">
          </label>

          <label for="message" class="full-width">
            <span><i class="fas fa-pen"></i> Message *</span>
            <textarea id="message" name="message" rows="6" required><?= htmlspecialchars($form_data['message'], ENT_QUOTES, 'UTF-8'); ?></textarea>
          </label>

          <label for="captcha" class="full-width">
            <span><i class="fas fa-shield-alt"></i> Vérification anti-robot (optionnel) : combien font 3 + 4 ?</span>
            <input type="text" id="captcha" name="captcha" inputmode="numeric" value="<?= htmlspecialchars($form_data['captcha'], ENT_QUOTES, 'UTF-8'); ?>">
          </label>

          <!-- Honeypot anti-spam -->
          <label for="website" style="position:absolute; left:-10000px; width:1px; height:1px; overflow:hidden;">
            Site web (laisser vide)
          </label>
          <input type="text" id="website" name="website" tabindex="-1" autocomplete="off" value="<?= htmlspecialchars($form_data['website'], ENT_QUOTES, 'UTF-8'); ?>" style="position:absolute; left:-10000px; width:1px; height:1px; overflow:hidden;">

          <button type="submit" class="btn btn-primary full-width" style="display: flex; justify-content: center; align-items: center; gap: 0.5rem;">
            <i class="fas fa-paper-plane"></i> Envoyer
          </button>
        </form>
      </article>
    </div>
  </div>
</section>

<section class="section section-alt">
  <div class="container">
    <div class="section-heading">
      <p class="eyebrow"><i class="fas fa-map-marked-alt"></i> Nous trouver</p>
      <h2>Carte Google Maps</h2>
    </div>

    <article class="card" style="padding: 0; overflow: hidden;">
      <iframe
        title="Localisation Estimation Immobilier Lannion"
        src="https://www.google.com/maps?q=Lannion%2022300&output=embed"
        width="100%"
        height="420"
        style="border: 0; display: block;"
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
        allowfullscreen>
      </iframe>
    </article>
  </div>
</section>
