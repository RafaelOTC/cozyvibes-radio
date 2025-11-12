<?php
// === Cozy Vibes Radio — meta.php (augmented pentru dark/light) ===
// Poți seta $pageTitle și $pageDescription înainte de include.
// Vor avea fallback-uri sigure dacă nu sunt definite.
if (!isset($pageTitle))      $pageTitle = 'Cozy Vibes Radio — Relaxing streams for focus, study and calm.';
if (!isset($pageDescription))$pageDescription = 'Lofi, jazz, chill & coffeehouse streams. Minimal, fast, global.';
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title><?= htmlspecialchars($pageTitle, ENT_QUOTES) ?></title>
<meta name="description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES) ?>">

<!-- Canonical / SEO / Social – păstrează-ți meta-urile existente aici -->
<!-- <link rel="canonical" href="..."> -->
<!-- <meta property="og:title" content="..."> -->
<!-- <meta property="og:description" content="..."> -->
<!-- <meta property="og:image" content="/assets/img/og.jpg"> -->
<!-- <meta name="twitter:card" content="summary_large_image"> -->

<!-- Bootstrap temă foarte devreme (anti-flash) -->
<script>
(function () {
  var key = 'cvr-theme';
  var stored = null;
  try { stored = localStorage.getItem(key); } catch(e) {}

  function sysDark(){ return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches; }
  var theme = (stored === 'light' || stored === 'dark') ? stored : (sysDark() ? 'dark' : 'light');
  document.documentElement.setAttribute('data-theme', theme);

  // meta theme-color pentru mobile
  var meta = document.querySelector('meta[name="theme-color"]');
  if (!meta) { meta = document.createElement('meta'); meta.setAttribute('name', 'theme-color'); document.head.appendChild(meta); }
  meta.setAttribute('content', theme === 'dark' ? '#0b1220' : '#ffffff');
})();
</script>

<!-- CSS tema -->
<link rel="stylesheet" href="/assets/css/theme.css">

<!-- Dacă ai un stylesheet global, păstrează-l după tema (exemplu): -->
<?php /* <link rel="stylesheet" href="/assets/css/main.css"> */ ?>

</head>
<body>
