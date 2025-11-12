<?php
require_once __DIR__.'/../includes/utils.php';
require_once __DIR__.'/../includes/meta.php';
require_once __DIR__.'/../includes/auth.php';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $email = trim($_POST['email'] ?? '');
  $pass = trim($_POST['password'] ?? '');
  if(try_login($email,$pass)){ header('Location: '.base_url('admin/')); exit; }
  $err = "Invalid login";
}
page_head('Admin Login');
?>
<div class="hero" style="max-width:520px;margin:40px auto">
  <h1>Admin Login</h1>
  <?php if(!empty($err)) echo "<div class='notice' style='background:#201010;border-color:#3d1f1f;color:#fca5a5'>".e($err)."</div>"; ?>
  <form class="form" method="post">
    <input class="input" type="email" name="email" placeholder="Email" required>
    <input class="input" type="password" name="password" placeholder="Password" required>
    <button class="btn primary" type="submit">Login</button>
  </form>
  <p class="small" style="margin-top:6px">Roluri: Owner, Admin, Moderator, Partner, User</p>
</div>
<?php page_foot(); ?>
