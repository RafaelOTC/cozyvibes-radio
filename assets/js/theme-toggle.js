(function () {
  var STORAGE_KEY = 'cvr-theme';
  var DOC = document.documentElement;

  function sysPrefersDark() {
    return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
  }
  function getTheme() {
    var t = DOC.getAttribute('data-theme');
    return t || (sysPrefersDark() ? 'dark' : 'light');
  }
  function setTheme(t) {
    DOC.setAttribute('data-theme', t);
    try { localStorage.setItem(STORAGE_KEY, t); } catch(e) {}
    var meta = document.querySelector('meta[name="theme-color"]');
    if (meta) meta.setAttribute('content', t === 'dark' ? '#0b1220' : '#ffffff');
    updateUI(t);
  }
  function updateUI(t) {
    var btn = document.getElementById('theme-toggle');
    var icon = document.getElementById('theme-toggle-icon');
    if (btn) btn.setAttribute('aria-pressed', t === 'dark');
    if (icon) icon.textContent = t === 'dark' ? '🌞' : '🌙';
    var fab = document.getElementById('cvr-theme-fab');
    if (fab) fab.setAttribute('aria-label', t === 'dark' ? 'Switch to light theme' : 'Switch to dark theme');
  }

  // Buton în nav (dacă există)
  function wireNavButton() {
    var btn = document.getElementById('theme-toggle');
    if (!btn) return false;
    btn.addEventListener('click', function () {
      setTheme(getTheme() === 'dark' ? 'light' : 'dark');
    });
    updateUI(getTheme());
    return true;
  }

  // Fallback: FAB flotant dacă nu există buton în nav
  function ensureFab() {
    if (document.getElementById('theme-toggle')) return;
    if (document.getElementById('cvr-theme-fab')) return;
    var fab = document.createElement('button');
    fab.id = 'cvr-theme-fab';
    fab.type = 'button';
    fab.innerText = getTheme() === 'dark' ? '🌞' : '🌙';
    fab.addEventListener('click', function(){
      var next = getTheme() === 'dark' ? 'light' : 'dark';
      setTheme(next);
      fab.innerText = next === 'dark' ? '🌞' : '🌙';
    });
    document.body.appendChild(fab);
  }

  // Urmărește schimbarea sistemului DOAR dacă nu există preferință salvată
  try {
    var saved = localStorage.getItem(STORAGE_KEY);
    var mq = window.matchMedia('(prefers-color-scheme: dark)');
    if (mq && (saved !== 'light' && saved !== 'dark')) {
      (mq.addEventListener || mq.addListener).call(mq, 'change', function (e) {
        setTheme(e.matches ? 'dark' : 'light');
      });
    }
  } catch(e){}

  // Init
  document.addEventListener('DOMContentLoaded', function () {
    wireNavButton();
    ensureFab();
    updateUI(getTheme());
  });
})();
