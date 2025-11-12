<?php
require_once __DIR__.'/../includes/utils.php';
header('Content-Type: application/json; charset=utf-8');
$comments = load_json('comments.json', []);
$method = $_SERVER['REQUEST_METHOD'];
if($method==='GET'){
  $slug = $_GET['slug'] ?? '';
  $out = array_values(array_filter($comments, fn($c)=>($c['slug']??'')===$slug && ($c['status']??'approved')==='approved'));
  echo json_encode($out); exit;
}
if($method==='POST'){
  $in = json_decode(file_get_contents('php://input'), true);
  if(!$in){ http_response_code(400); echo json_encode(['error'=>'invalid']); exit; }
  $in['id'] = uniqid('c_'); $in['status'] = 'pending'; $in['created_at'] = gmdate('c');
  $comments[] = $in; save_json('comments.json', $comments);
  echo json_encode(['ok'=>true,'status'=>'pending']); exit;
}
http_response_code(405); echo json_encode(['error'=>'method']);
