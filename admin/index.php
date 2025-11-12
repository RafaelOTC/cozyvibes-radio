<?php
require_once __DIR__.'/../includes/utils.php';
require_once __DIR__.'/../includes/meta.php';
require_once __DIR__.'/../includes/auth.php';
require_login();
page_head('Admin Dashboard');
$streams = load_json('streams.json', []);
$users = load_json('users.json', []);
?>
<div class="hero">
  <h1>Admin Dashboard</h1>
  <p class="small">Gestionare conținut, utilizatori, design, SEO</p>
</div>
<div style="max-width:1100px;margin:0 auto;padding:0 16px 24px">
  <div class="grid" style="grid-template-columns:repeat(auto-fill,minmax(260px,1fr))">
    <div class="card"><div class="body"><h3>Streams</h3><p><?= count($streams) ?> totale</p><a class="button" href="streams.php">Manage</a></div></div>
    <div class="card"><div class="body"><h3>Users</h3><p><?= count($users) ?> conturi</p><a class="button" href="users.php">Manage</a></div></div>
    <div class="card"><div class="body"><h3>Design & SEO</h3><p>Teme, OG, sitemap</p><a class="button" href="design.php">Open</a></div></div>
    <div class='card'><div class='body'><h3>Moderation</h3><p>Comentarii în așteptare</p><a class='button' href='moderation.php'>Open</a></div></div>
    <div class='card'><div class='body'><h3>Backups</h3><p>Backup JSON rapid</p><a class='button' href='backup.php' target='_blank'>Run</a></div></div>
  </div>
</div>
<?php page_foot(); ?>
