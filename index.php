<?php
require __DIR__.'/includes/config.php';
require __DIR__.'/includes/meta.php';
$streams = [];
foreach (['data/streams.json','streams.json'] as $f) {
  $p = __DIR__.'/'.$f;
  if (is_file($p)) { $streams = json_decode(file_get_contents($p), true); break; }
}
if (!is_array($streams)) $streams = [];

page_head(['title'=>'Cozy Vibes Radio — Find your cozy vibe','active'=>'home']);
?>
<main class="container">
  <section class="hero">
    <h1>Găsește-ți vibe-ul cozy ☕</h1>
    <p class="muted">Fără reclame • Design minimalist • Global & multi-lingv</p>
  </section>

  <section>
    <h2 class="section-title">Cozy Streams</h2>
    <div class="grid">
      <?php foreach ($streams as $s):
        $slug = htmlspecialchars($s['slug'] ?? '');
        if (!$slug) continue;
        $title = htmlspecialchars($s['title'] ?? $slug);
        $tags  = $s['tags'] ?? [];
        $cover = $s['cover'] ?? '';
        $style = $cover ? "style=\"background-image:url('".htmlspecialchars($cover)."');\"" : '';
        $cls   = $cover ? 'thumb' : 'thumb default';
      ?>
        <article class="card">
          <a class="<?=$cls?>" href="/stream.php?slug=<?=$slug?>" <?=$style?>></a>
          <div class="body">
            <h3><a class="link" href="/stream.php?slug=<?=$slug?>"><?=$title?></a></h3>
            <?php if ($tags && is_array($tags)): ?>
              <div class="tags">
                <?php foreach (array_slice($tags,0,3) as $t): ?>
                  <span class="tag">#<?=htmlspecialchars($t)?></span>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </section>
</main>
<?php page_foot(); ?>
