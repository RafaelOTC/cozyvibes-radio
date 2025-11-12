<?php
if (!defined('SITE_NAME')) define('SITE_NAME','Cozy Vibes Radio');

function page_head($opts = []) {
  if (is_string($opts)) $opts = ['active'=>$opts];
  if (!is_array($opts)) $opts = [];
  $title   = $opts['title']       ?? SITE_NAME;
  $desc    = $opts['description'] ?? (SITE_NAME.' — 24/7 livestreams: jazz, lofi, ambient, rain.');
  $noindex = !empty($opts['noindex']);
  $active  = $opts['active']      ?? '';
  $GLOBALS['__cv_active'] = $active;

  echo "<!DOCTYPE html>\n<html lang=\"en\">\n<head>\n<meta charset=\"utf-8\">\n<meta name=\"viewport\" content=\"width=device-width,initial-scale=1\">\n";
  echo '<title>'.htmlspecialchars($title)."</title>\n";
  echo '<meta name="description" content="'.htmlspecialchars($desc).'">'."\n";
  if ($noindex) echo "<meta name=\"robots\" content=\"noindex,nofollow\">\n";
  echo "<link rel=\"icon\" href=\"/assets/img/favicon.ico\">\n";
  echo "<link rel=\"stylesheet\" href=\"/assets/css/app.css?v=".time()."\">\n";

  // === Cozy Vibes Radio dark/light theme (anti-flash + assets) ===
  echo <<<HTML
<script>
(function () {
  var key = 'cvr-theme';
  var stored = null;
  try { stored = localStorage.getItem(key); } catch(e) {}

  function sysDark(){ return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches; }
  var theme = (stored === 'light' || stored === 'dark') ? stored : (sysDark() ? 'dark' : 'light');
  document.documentElement.setAttribute('data-theme', theme);

  // theme-color pt. mobil – crem pe light, închis pe dark
  var meta = document.querySelector('meta[name="theme-color"]');
  if (!meta) { meta = document.createElement('meta'); meta.setAttribute('name', 'theme-color'); document.head.appendChild(meta); }
  meta.setAttribute('content', theme === 'dark' ? '#0b1220' : '#f8f5ef');
})();
</script>
<link rel="stylesheet" href="/assets/css/theme.css">
<script src="/assets/js/theme-toggle.js" defer></script>
HTML;
  // === end theme ===

  echo "</head>\n<body class=\"site\">\n";
  header_nav($active);
}

function header_nav($active = '') {
  if (!$active && isset($GLOBALS['__cv_active'])) $active = $GLOBALS['__cv_active'];
  $links = [
    ['href'=>'/','key'=>'home','label'=>'Home'],
    ['href'=>'/partners.php','key'=>'partners','label'=>'Partners'],
    ['href'=>'/about.php','key'=>'about','label'=>'About'],
    ['href'=>'/admin/','key'=>'admin','label'=>'Admin'],
  ];
  echo "<header class=\"topbar\"><div class=\"container\">";
  echo "<a class=\"brand\" href=\"/\">".SITE_NAME."</a><nav>";
  foreach ($links as $L) {
    $cls = ($active === $L['key']) ? 'active' : '';
    echo "<a class=\"$cls\" href=\"{$L['href']}\">{$L['label']}</a>";
  }

  // === Toggle dark/light în nav (vizibil mereu) ===
  echo '<button id="theme-toggle" class="btn secondary" aria-pressed="false" title="Toggle theme" style="margin-left:1rem;gap:.4rem">';
  echo '  <span id="theme-toggle-icon" aria-hidden="true">🌙</span>';
  echo '  <span class="sr-only">Schimbă tema</span>';
  echo '</button>';

  echo "</nav></div></header>";
}

function page_foot() {
  echo "<footer class=\"site-foot\"><div class=\"container\">© ".date('Y')." ".SITE_NAME." — stay cozy ☕</div></footer>";
  echo "<script src=\"/assets/js/app.js?v=".time()."\"></script>";
  echo "</body></html>";
}
