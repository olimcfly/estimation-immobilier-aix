<section class="section">
  <div class="container">
    <p class="eyebrow">Blog immobilier Lannion &amp; Côte de Granit Rose</p>
    <h1>Analyses et conseils pour investir à Lannion</h1>
    <p class="lead">Retrouvez nos dossiers dédiés au marché lannionnais : quartiers, rentabilité, rénovation et investissement touristique en Bretagne nord.</p>

    <div class="blog-grid">
      <?php if (empty($articles)): ?>
        <article class="card">
          <h2>Aucun article publié pour le moment</h2>
          <p class="muted">Revenez prochainement pour lire nos derniers conseils immobiliers à Lannion.</p>
        </article>
      <?php else: ?>
        <?php foreach ($articles as $article): ?>
          <?php
          $publishedAt = null;
          if (!empty($article['created_at'])) {
              try {
                  $publishedAt = (new DateTimeImmutable((string) $article['created_at']))->format('d/m/Y');
              } catch (Exception) {
                  $publishedAt = null;
              }
          }
          ?>
          <article class="card blog-card">
            <?php if (!empty($publishedAt)): ?>
              <p class="badge">Publié le <?= e($publishedAt) ?></p>
            <?php endif; ?>
            <h2><?= e((string) $article['title']) ?></h2>
            <p class="muted"><?= e((string) $article['meta_description']) ?></p>
            <p class="badge"><?= e((string) $article['persona']) ?> • <?= e((string) $article['awareness_level']) ?></p>
            <a class="btn btn-small" href="/blog/<?= e((string) $article['slug']) ?>">Lire l'article</a>
          </article>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <section class="card cta-card">
      <h2>Vous souhaitez estimer un bien à Lannion ?</h2>
      <p class="muted">Obtenez une estimation immobilière argumentée selon votre adresse, votre bien et les données locales.</p>
      <a class="btn" href="/estimation">Lancer mon estimation</a>
    </section>
  </div>
</section>
