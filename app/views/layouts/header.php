<?php
  $requestUri = $_SERVER['REQUEST_URI'] ?? '/';
  $canonicalPath = (string) parse_url($requestUri, PHP_URL_PATH);
  $canonicalPath = $canonicalPath !== '' ? $canonicalPath : '/';
  if ($canonicalPath !== '/') {
      $canonicalPath = rtrim($canonicalPath, '/');
  }

  $isHttps = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
  $scheme = $isHttps ? 'https' : 'http';
  $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
  $canonicalUrl = $scheme . '://' . $host . $canonicalPath;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= htmlspecialchars((string) ($meta_description ?? 'Estimation immobilière Lannion - Évaluez votre bien gratuitement et découvrez nos guides immobiliers.'), ENT_QUOTES, 'UTF-8') ?>">
  <meta name="theme-color" content="#003f87">
  <link rel="canonical" href="<?= htmlspecialchars($canonicalUrl); ?>">
  <title><?= isset($page_title) ? htmlspecialchars($page_title) : 'Estimation Immobilière Lannion' ?></title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- FontAwesome 6.4.0 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- CSS Principal Premium -->
  <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>

<!-- ================================================ -->
<!-- HEADER PREMIUM -->
<!-- ================================================ -->
<header class="site-header">
  <div class="header-container">
    <div class="header-wrapper">
      
      <!-- LOGO / BRAND -->
      <a href="/" class="brand">
        <div class="brand-icon">
          <i class="fas fa-home"></i>
        </div>
        <span>Estimation Immobilier <span>Lannion</span></span>
      </a>

      <!-- NAVIGATION PRINCIPALE -->
      <nav class="nav-main" aria-label="Navigation principale" id="nav-main">

        <!-- Estimation Dropdown -->
        <div class="nav-item nav-dropdown">
          <a href="/#form-estimation" class="nav-link dropdown-toggle">
            <i class="fas fa-calculator"></i> Estimation <i class="fas fa-chevron-down fa-xs"></i>
          </a>
          <ul class="dropdown-menu" aria-label="Sous-menu estimation">
            <li><a href="/#form-estimation"><i class="fas fa-bolt"></i> Estimer mon bien</a></li>
            <li><a href="/exemples-estimation"><i class="fas fa-eye"></i> Exemples d'estimation</a></li>
            <li><a href="/processus-estimation"><i class="fas fa-list-check"></i> Notre processus</a></li>
            <li><a href="/calculatrice"><i class="fas fa-calculator"></i> Calculatrice</a></li>
          </ul>
        </div>

        <!-- Immobilier Dropdown -->
        <div class="nav-item nav-dropdown">
          <a href="/quartiers" class="nav-link dropdown-toggle">
            <i class="fas fa-building"></i> Immobilier <i class="fas fa-chevron-down fa-xs"></i>
          </a>
          <ul class="dropdown-menu" aria-label="Sous-menu immobilier">
            <li><a href="/quartiers"><i class="fas fa-map-marked-alt"></i> Quartiers de Lannion</a></li>
            <li><a href="/services"><i class="fas fa-briefcase"></i> Nos services</a></li>
            <li><a href="/#how-it-works"><i class="fas fa-cog"></i> Comment ça marche</a></li>
          </ul>
        </div>

        <!-- Ressources Dropdown -->
        <div class="nav-item nav-dropdown">
          <a href="/blog" class="nav-link dropdown-toggle">
            <i class="fas fa-book-open"></i> Ressources <i class="fas fa-chevron-down fa-xs"></i>
          </a>
          <ul class="dropdown-menu" aria-label="Sous-menu ressources">
            <li><a href="/blog"><i class="fas fa-newspaper"></i> Blog & articles</a></li>
            <li><a href="/guides"><i class="fas fa-file-pdf"></i> Guides complets</a></li>
            <li><a href="/podcast"><i class="fas fa-podcast"></i> Podcast immobilier</a></li>
            <li><a href="/newsletter"><i class="fas fa-envelope-open-text"></i> Newsletter</a></li>
          </ul>
        </div>

        <!-- À propos Dropdown -->
        <div class="nav-item nav-dropdown">
          <a href="/a-propos" class="nav-link dropdown-toggle">
            <i class="fas fa-users"></i> À propos <i class="fas fa-chevron-down fa-xs"></i>
          </a>
          <ul class="dropdown-menu" aria-label="Sous-menu à propos">
            <li><a href="/a-propos"><i class="fas fa-info-circle"></i> Qui sommes-nous</a></li>
            <li><a href="/contact"><i class="fas fa-envelope"></i> Contact</a></li>
            <li><a href="/mentions-legales"><i class="fas fa-gavel"></i> Mentions légales</a></li>
            <li><a href="/rgpd"><i class="fas fa-shield-alt"></i> RGPD</a></li>
          </ul>
        </div>

      </nav>

      <!-- HEADER ACTIONS -->
      <div class="header-actions">
        <a href="/#form-estimation" class="btn-cta">
          <i class="fas fa-bolt"></i>
          <span>Estimer</span>
        </a>

        <!-- Menu Toggle Mobile -->
        <button class="menu-toggle" id="menu-toggle" aria-label="Basculer le menu" aria-expanded="false">
          <span></span>
          <span></span>
          <span></span>
        </button>
      </div>

    </div>
  </div>
</header>

<!-- Main Content Wrapper -->
<main id="main-content">
