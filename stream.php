<?php
require __DIR__.'/includes/config.php';
require __DIR__.'/includes/meta.php';

function youtube_id_from_url($url){
  $id = '';
  $p = parse_url($url);
  if (!$p || empty($p['host'])) return '';
  $host = $p['host'];
  if (strpos($host,'youtu.be') !== false) {
    $id = trim($p['path'] ?? '', '/');
  } elseif (strpos($host,'youtube.com') !== false) {
    parse_str($p['query'] ?? '', $q);
    if (!empty($q['v'])) $id = $q['v'];
  }
  // curăță eventuale parametre
  return preg_replace('~[^A-Za-z0-9_-]~','', $id);
}

$slug = trim($_GET['slug'] ?? '');
$streams = [];
foreach (['data/streams.json','streams.json'] as $f) {
  $p = __DIR__.'/'.$f;
  if (is_file($p)) { $streams = json_decode(file_get_contents($p), true); break; }
}
if (!is_array($streams)) $streams = [];

$stream = null;
foreach ($streams as $s) {
  if (($s['slug'] ?? '') === $slug) { $stream = $s; break; }
}
if (!$stream) {
  http_response_code(404);
  page_head(['title'=>'Stream not found','noindex'=>true]);
  echo '<main class="container"><h1>Stream not found</h1><p class="muted">Nu am găsit stream-ul solicitat.</p></main>';
  page_foot(); exit;
}

$title = $stream['title'] ?? $slug;
$ytUrl = $stream['youtube'] ?? ($stream['url'] ?? '');
$ytId  = $ytUrl ? youtube_id_from_url($ytUrl) : '';
$desc  = $stream['description'] ?? 'Enjoy cozy sounds for focus, study and relaxation.';
$tags  = $stream['tags'] ?? [];

page_head(['title'=>$title.' — Cozy Vibes','active'=>'home']);
?>
<main class="container">
  <div class="stream-head">
    <a class="back" href="/">← Back to Home</a>
    <h1 class="stream-title"><?=htmlspecialchars($title)?></h1>
  </div>

  <?php if ($ytId): ?>
  <div class="player-wrap">
    <div class="player">
      <iframe width="100%" height="540"
        src="https://www.youtube.com/embed/<?=htmlspecialchars($ytId)?>?autoplay=0&rel=0"
        title="<?=htmlspecialchars($title)?>" frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
        allowfullscreen></iframe>
    </div>
    <a class="btn yt" href="<?=htmlspecialchars($ytUrl)?>" target="_blank" rel="noopener">
      <span class="dot"></span> Watch on YouTube
    </a>
  </div>
  <?php endif; ?>

  <div class="meta">
    <?php if ($tags && is_array($tags)): ?>
      <div class="tags">
        <?php foreach ($tags as $t): ?><span class="tag">#<?=htmlspecialchars($t)?></span><?php endforeach; ?>
      </div>
    <?php endif; ?>
    <p class="muted"><?=htmlspecialchars($desc)?></p>

    <div class="sharebar">
      <button class="btn" id="btnShare">Share</button>
      <button class="btn" id="btnCopy">Copy link</button>
      <span id="copyOk" class="muted" style="display:none;margin-left:8px;">Link copied ✅</span>
    </div>
  </div>
</main>

<script>
(function(){
  const shareBtn = document.getElementById('btnShare');
  const copyBtn  = document.getElementById('btnCopy');
  const ok       = document.getElementById('copyOk');
  const url      = window.location.href;

  if (shareBtn && navigator.share) {
    shareBtn.addEventListener('click', async () => {
      try { await navigator.share({title: document.title, url}); } catch(e){}
    });
  } else if (shareBtn) {
    shareBtn.disabled = true;
    shareBtn.title = 'Not supported';
  }

  if (copyBtn) {
    copyBtn.addEventListener('click', async () => {
      try { await navigator.clipboard.writeText(url); ok.style.display='inline'; setTimeout(()=>ok.style.display='none',1500);} catch(e){}
    });
  }
})();
</script>
<?php page_foot(); ?>
