<?php
require_once __DIR__.'/../includes/utils.php';
header('Content-Type: application/json; charset=utf-8');
$slug = $_GET['slug'] ?? '';
if(!$slug){ echo json_encode(['ok'=>false]); exit; }
$an = load_json('analytics.json', []);
if(!isset($an[$slug])) $an[$slug] = ['views'=>0];
$an[$slug]['views']++;
save_json('analytics.json',$an);
echo json_encode(['ok'=>true]);
