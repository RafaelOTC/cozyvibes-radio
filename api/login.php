<?php
require_once __DIR__.'/../includes/utils.php';
require_once __DIR__.'/../includes/auth.php';
header('Content-Type: application/json; charset=utf-8');
if($_SERVER['REQUEST_METHOD']!=='POST'){ http_response_code(405); echo json_encode(['error'=>'Method not allowed']); exit; }
$body = json_decode(file_get_contents('php://input'), true);
$email = trim($body['email'] ?? '');
$pass = trim($body['password'] ?? '');
if(try_login($email,$pass)){
  echo json_encode(['ok'=>true,'user'=>current_user()]); exit;
}
http_response_code(401); echo json_encode(['error'=>'Invalid']);
