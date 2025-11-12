<?php
require_once __DIR__.'/../includes/utils.php';
header('Content-Type: application/json; charset=utf-8');
$re = load_json('reactions.json', []);
$method = $_SERVER['REQUEST_METHOD'];
if($method==='POST'){
  $in = json_decode(file_get_contents('php://input'), true);
  $slug = $in['slug'] ?? ''; $emo = $in['emoji'] ?? '💜';
  if(!$slug) { http_response_code(400); echo json_encode(['error'=>'slug']); exit; }
  if(!isset($re[$slug])) $re[$slug] = ['💜'=>0,'😌'=>0,'🌧'=>0,'🔥'=>0];
  if(!isset($re[$slug][$emo])) $re[$slug][$emo]=0;
  $re[$slug][$emo]++;
  save_json('reactions.json', $re);
  echo json_encode(['ok'=>true,'counts'=>$re[$slug]]); exit;
}
if($method==='GET'){
  $slug = $_GET['slug'] ?? '';
  echo json_encode($re[$slug] ?? ['💜'=>0,'😌'=>0,'🌧'=>0,'🔥'=>0]); exit;
}
http_response_code(405); echo json_encode(['error'=>'method']);
