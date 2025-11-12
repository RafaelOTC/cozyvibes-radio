/* ===== Cozy Vibes Radio – Theme Tokens (Light: beige/cream) ===== */
:root {
  /* Light (beige/cream) */
  --bg: #f8f5ef;            /* crem cald, paper-like */
  --text: #2b2b2b;          /* aproape negru cald */
  --muted: #6b645a;         /* gri-brun pt. texte secundare */
  --card: #fffaf3;          /* panouri ușor mai deschise ca bg */
  --border: #e8dfd1;        /* bej pal pentru linii subtile */
  --accent: #a97155;        /* tan/cafea cu lapte */
  --accent-contrast: #ffffff;
  --link: #7c5e2a;          /* maro-auriu pentru linkuri */
  --shadow: 0 10px 25px rgba(43, 43, 43, .06);
}

:root[data-theme="dark"] {
  /* Dark (rămâne modern, cu nuanțe rece-închise) */
  --bg: #0b1220;
  --text: #e5e7eb;
  --muted: #9ca3af;
  --card: #0f172a;
  --border: #1f2937;
  --accent: #8b5cf6;
  --accent-contrast: #0b1220;
  --link: #93c5fd;
  --shadow: 0 10px 25px rgba(0, 0, 0, .35);
}

/* Respectă preferința sistemului când nu e ales manual */
@media (prefers-color-scheme: dark) {
  :root:not([data-theme="light"]):not([data-theme="dark"]) { color-scheme: dark; }
}
@media (prefers-color-scheme: light) {
  :root:not([data-theme="light"]):not([data-theme="dark"]) { color-scheme: light; }
}

/* ===== Aplicare globală ===== */
html, body { background: var(--bg); color: var(--text); }
* { box-sizing: border-box; }

a { color: var(--link); }
a:hover { opacity:.9; text-decoration: underline; }

hr, .divider { border-color: var(--border); }

.card {
  background: var(--card);
  border: 1px solid var(--border);
  border-radius: 12px;
  box-shadow: var(--shadow);
}

.btn {
  display: inline-flex; align-items: center; gap: .5rem;
  background: var(--accent); color: var(--accent-contrast);
  border: 0; border-radius: 10px; padding: .6rem .9rem;
  font-weight: 600; cursor: pointer;
}
.btn.secondary {
  background: transparent; color: var(--text);
  border: 1px solid var(--border);
}

.tag {
  display:inline-block; padding:.25rem .5rem; border-radius:999px;
  background: color-mix(in srgb, var(--accent) 12%, transparent);
  color: var(--text); border: 1px solid var(--border);
}

/* Mică tranziție între teme */
html { transition: background-color .2s ease, color .2s ease; }

/* Toggle flotant (fallback dacă nu ai buton în nav) */
#cvr-theme-fab {
  position: fixed; right: 16px; bottom: 16px; z-index: 9999;
  background: var(--card); color: var(--text);
  border: 1px solid var(--border);
  border-radius: 999px; padding: .55rem .7rem;
  box-shadow: var(--shadow); cursor: pointer; line-height: 1; font-size: 16px;
}
#cvr-theme-fab:focus { outline: 2px solid var(--accent); outline-offset: 2px; }

/* Utilitate accesibilitate */
.sr-only{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0;}
