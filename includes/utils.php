<?php
function cfg() {
    static $cfg = null;
    if ($cfg === null) $cfg = require __DIR__.'/config.php';
    return $cfg;
}
function base_url($path = '') {
    $b = rtrim(cfg()['base_url'], '/');
    $p = ltrim($path, '/');
    return $b . '/' . $p;
}
function load_json($file, $default = []) {
    $path = cfg()['data_dir'] . '/' . $file;
    if (!file_exists($path)) return $default;
    $data = json_decode(file_get_contents($path), true);
    return $data ?: $default;
}
function save_json($file, $data) {
    $path = cfg()['data_dir'] . '/' . $file;
    @mkdir(dirname($path), 0775, true);
    file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    return true;
}
function e($s) { return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8'); }
function now_iso() { return gmdate('c'); }
function slugify($text) {
    $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = trim($text, '-');
    $text = strtolower($text);
    $text = preg_replace('~[^-a-z0-9]+~', '', $text);
    return $text ?: 'item';
}
function sha256($s) {
    return hash('sha256', $s);
}
session_start();

function detect_locale(){
  $cfg = cfg();
  $q = strtolower($_GET['lang'] ?? '');
  if($q && in_array($q, $cfg['locales'])) return $q;
  $hdr = strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '');
  foreach($cfg['locales'] as $lc){
    if(strpos($hdr, $lc)!==false) return $lc;
  }
  return $cfg['locale_default'] ?? 'ro';
}
function t($key){
  static $T = null;
  if($T===null){
    $lc = detect_locale();
    $file = __DIR__.'/../i18n/'.$lc.'.json';
    if(!file_exists($file)) $file = __DIR__.'/../i18n/ro.json';
    $T = json_decode(file_get_contents($file), true) ?: [];
  }
  return $T[$key] ?? $key;
}
