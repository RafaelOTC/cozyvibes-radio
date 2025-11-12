<?php
require_once __DIR__.'/../includes/utils.php';
require_once __DIR__.'/../includes/meta.php';
require_once __DIR__.'/../includes/auth.php';
require_login();
page_head('Partner Dashboard');
$streams = load_json('streams.json', []);
$user = current_user();
$mine = array_values(array_filter($streams, fn($s)=>($s['owner']??'')===$user['id']));
?>
<div class="hero">
  <h1>Partner Dashboard</h1>
  <p class="small">Bun venit, <?= e($user['name']) ?>. Poți gestiona streamurile tale.</p>
</div>
<div style="max-width:1000px;margin:0 auto;padding:0 16px 24px">
  <h3>Streamurile mele (<?= count($mine) ?>)</h3>
  <ul>
  <?php foreach($mine as $s): ?>
    <li><?= e($s['title']) ?> — <a href="<?= base_url('stream.php?slug='.urlencode($s['slug'])) ?>">vezi</a></li>
  <?php endforeach; if(empty($mine)) echo "<li>Nimic încă.</li>"; ?>
  </ul>
  <a class="btn" href="add_stream.php">Adaugă stream</a>
</div>
<?php page_foot(); ?>
