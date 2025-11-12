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
    if (meta) meta.setAttribute('content', t === 'dark' ? '#0b1220' : '#f8f5ef');
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

  function wireNavButton() {
    var btn = document.getElementById('theme-toggle');
    if (!btn) return false;
    btn.addEventListener('click', function () {
      setTheme(getTheme() === 'dark' ? 'light' : 'dark');
    });
    updateUI(getTheme());
    return true;
  }

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

  // ✅ Corect: atașează handler-ul de schimbare fără să crape pe browsere vechi
  function watchSystemThemeIfNoPreference() {
    var saved;
    try { saved = localStorage.getItem(STORAGE_KEY); } catch(e) { saved = null; }
    if (saved === 'light' || saved === 'dark') return; // user alege manual

    var mq = window.matchMedia ? window.matchMedia('(prefers-color-scheme: dark)') : null;
    if (!mq) return;

    var handler = function (e) { setTheme(e.matches ? 'dark' : 'light'); };

    if (typeof mq.addEventListener === 'function') {
      mq.addEventListener('change', handler);
    } else if (typeof mq.addListener === 'function') {
      mq.addListener(handler); // vechi Safari/Chrome
    }
  }

  document.addEventListener('DOMContentLoaded', function () {
    wireNavButton();
    ensureFab();
    updateUI(getTheme());
    watchSystemThemeIfNoPreference();
  });
})();
