<?php
require_once __DIR__.'/../includes/utils.php';
require_once __DIR__.'/../includes/meta.php';
require_once __DIR__.'/../includes/auth.php';
require_login();
$settings = load_json('settings.json', ['theme'=>'dark','featured'=>[]]);
if($_SERVER['REQUEST_METHOD']==='POST'){
  $settings['theme'] = $_POST['theme'] ?? 'dark';
  save_json('settings.json',$settings);
  header('Location: design.php'); exit;
}
page_head('Admin • Design & SEO');
?>
<div style="max-width:800px;margin:0 auto;padding:24px 16px">
  <h2>Design & SEO</h2>
  <form class="form" method="post">
    <label>Tema globală</label>
    <select class="input" name="theme">
      <option value="dark" <?= ($settings['theme']??'dark')==='dark'?'selected':'' ?>>Dark</option>
      <option value="light" <?= ($settings['theme']??'dark')==='light'?'selected':'' ?>>Light</option>
    </select>
    <button class="btn primary">Save</button>
  </form>
  <p class="small">OG, sitemap, robots, hreflang pot fi adăugate ușor aici.</p>
</div>
<?php page_foot(); ?>
