<?php
// Cozy Vibes Radio — theme-head.php (dark/light bootstrap)
?>
<!-- Anti-flash + theme color -->
<script>
(function () {
  var key = 'cvr-theme';
  var stored = null;
  try { stored = localStorage.getItem(key); } catch(e) {}

  function sysDark(){ return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches; }
  var theme = (stored === 'light' || stored === 'dark') ? stored : (sysDark() ? 'dark' : 'light');
  document.documentElement.setAttribute('data-theme', theme);

  var meta = document.querySelector('meta[name="theme-color"]');
  if (!meta) { meta = document.createElement('meta'); meta.setAttribute('name', 'theme-color'); document.head.appendChild(meta); }
  meta.setAttribute('content', theme === 'dark' ? '#0b1220' : '#ffffff');
})();
</script>

<link rel="stylesheet" href="/assets/css/theme.css">
<script src="/assets/js/theme-toggle.js" defer></script>
