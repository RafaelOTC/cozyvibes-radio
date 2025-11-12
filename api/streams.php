<?php
require_once __DIR__.'/../includes/utils.php';
header('Content-Type: application/json; charset=utf-8');
$method = $_SERVER['REQUEST_METHOD'];
if($method==='GET'){
  echo json_encode(load_json('streams.json', []));
  exit;
}
if($method==='POST'){
  $body = json_decode(file_get_contents('php://input'), true);
  if(!$body){ http_response_code(400); echo json_encode(['error'=>'Invalid JSON']); exit; }
  $streams = load_json('streams.json', []);
  $title = trim($body['title'] ?? '');
  $yt = trim($body['youtube_id'] ?? '');
  $genres = array_values(array_filter(array_map('trim', explode(',', $body['genres'] ?? ''))));
  $slug = slugify($title);
  $streams[] = ['id'=>uniqid('s_'),'slug'=>$slug,'title'=>$title,'youtube_id'=>$yt,'genres'=>$genres,'country'=>strtolower($body['country']??'xx'),'status'=>'live','created_at'=>now_iso()];
  save_json('streams.json',$streams);
  echo json_encode(['ok'=>true]); exit;
}
http_response_code(405); echo json_encode(['error'=>'Method not allowed']);
