<?php
require_once __DIR__.'/utils.php';
function current_user(){
  return $_SESSION['user'] ?? null;
}
function require_login(){
  if(!current_user()){
    header('Location: '.base_url('admin/login.php')); exit;
  }
}
function is_role($role){
  $u = current_user();
  return $u && isset($u['role']) && $u['role'] === $role;
}
function require_role($roles){
  $u = current_user();
  if(!$u || !in_array($u['role'], (array)$roles)) {
    http_response_code(403); echo "Access denied"; exit;
  }
}
function try_login($email, $password){
  $users = load_json('users.json', []);
  foreach($users as $u){
    if(strtolower($u['email']) === strtolower($email)){
      $hash = $u['password_sha256'] ?? '';
      if(hash_equals($hash, hash('sha256', $password))){
        $_SESSION['user'] = ['id'=>$u['id'],'email'=>$u['email'],'role'=>$u['role'],'name'=>$u['name']];
        return true;
      }
    }
  }
  return false;
}
function do_logout(){ unset($_SESSION['user']); session_destroy(); }
