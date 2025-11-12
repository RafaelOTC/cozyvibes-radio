<?php
// === Cozy Vibes Radio — includes/meta.php ===
// Versiune cu suport dark/light theme, anti-flash, meta SEO de bază
// Setează $pageTitle și $pageDescription înainte de include, dacă vrei valori custom.
if (!isset($pageTitle))       $pageTitle = 'Cozy Vibes Radio — Relaxing streams for focus, study and calm.';
if (!isset($pageDescription)) $pageDescription = 'Lofi, jazz, chill & coffeehouse streams. Minimal, fast, global.';
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title><?= htmlspecialchars($pageTitle, ENT_QUOTES) ?></title>
<meta name="description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES) ?>">

<!-- SEO / Social (păstrează/completează după nevoie) -->
<!-- <link rel="canonical" href="https://cozyvibes.radio/"> -->
<!-- <meta property="og:title" content="Cozy Vibes Radio"> -->
<!-- <meta property="og:description" content="Lofi, jazz, chill & coffeehouse streams."> -->
<!-- <meta property="og:image" content="/assets/img/og.jpg"> -->
<!-- <meta name="twitter:card" content="summary_large_image"> -->

<!-- Dark/Light bootstrap foarte devreme (evită flash de temă greșită) -->
<script>
(function () {
  var key = 'cvr-theme';
  var stored = null;
  try { stored = localStorage.getItem(key); } catch(e) {}

  function sysDark(){ return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches; }
  var theme = (stored === 'light' || stored === 'dark') ? stored : (sysDark() ? 'dark' : 'light');
  document.documentElement.setAttribute('data-theme', theme);

  // <meta name="theme-color"> pentru mobile UI
  var meta = document.querySelector('meta[name="theme-color"]');
  if (!meta) { meta = document.createElement('meta'); meta.setAttribute('name', 'theme-color'); document.head.appendChild(meta); }
  meta.setAttribute('content', theme === 'dark' ? '#0b1220' : '#ffffff');
})();
</script>

<!-- CSS temă (variabile + tokens) -->
<link rel="stylesheet" href="/assets/css/theme.css">

<!-- Dacă ai un stylesheet global, îl poți încărca după tema:
<link rel="stylesheet" href="/assets/css/main.css">
-->

<!-- Toggle logic (creează automat un FAB dacă nu există buton în nav) -->
<script src="/assets/js/theme-toggle.js" defer></script>
</head>
<body>
