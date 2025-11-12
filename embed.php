<?php
require_once __DIR__.'/includes/utils.php';
$slug = $_GET['slug'] ?? '';
$streams = load_json('streams.json', []);
$stream = null; foreach($streams as $s){ if($s['slug']===$slug){ $stream=$s; break; } }
if(!$stream){ http_response_code(404); echo "Not found"; exit; }
?><!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<style>html,body{margin:0;background:#0b0e12} .wrap{padding:0} .title{color:#e6e6e6;font:600 14px/1.2 Inter,system-ui} .cnt{padding:8px}</style>
</head><body><div class="wrap">
<iframe width="100%" height="200" src="https://www.youtube.com/embed/<?= e($stream['youtube_id']) ?>?autoplay=1" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
<div class="cnt"><div class="title"><?= e($stream['title']) ?></div></div>
</div></body></html>
