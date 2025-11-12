<?php
require_once __DIR__.'/../includes/utils.php';
require_once __DIR__.'/../includes/meta.php';
require_once __DIR__.'/../includes/auth.php';
require_login();
$users = load_json('users.json', []);
if($_SERVER['REQUEST_METHOD']==='POST'){
  $action = $_POST['action'] ?? '';
  if($action==='add'){
    $email = trim($_POST['email'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $role = trim($_POST['role'] ?? 'user');
    $pass = trim($_POST['password'] ?? '');
    $users[] = ['id'=>uniqid('u_'),'email'=>$email,'name'=>$name,'role'=>$role,'password_sha256'=>hash('sha256',$pass)];
    save_json('users.json',$users);
    header('Location: users.php'); exit;
  }
  if($action==='delete'){
    $id = $_POST['id'] ?? '';
    $users = array_values(array_filter($users, fn($u)=>$u['id']!==$id));
    save_json('users.json',$users);
    header('Location: users.php'); exit;
  }
}
page_head('Admin • Users');
?>
<div style="max-width:1000px;margin:0 auto;padding:24px 16px">
  <h2>Users</h2>
  <table class="table">
    <tr><th>Name</th><th>Email</th><th>Role</th><th></th></tr>
    <?php foreach($users as $u): ?>
      <tr>
        <td><?= e($u['name']) ?></td>
        <td><?= e($u['email']) ?></td>
        <td><?= e($u['role']) ?></td>
        <td>
          <form method="post" style="display:inline">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="id" value="<?= e($u['id']) ?>">
            <button class="btn" onclick="return confirm('Delete user?')">Delete</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
  <h3 style="margin-top:16px">Add new</h3>
  <form class="form" method="post">
    <input type="hidden" name="action" value="add">
    <input class="input" name="name" placeholder="Name" required>
    <input class="input" name="email" placeholder="Email" type="email" required>
    <select class="input" name="role">
      <option value="admin">admin</option>
      <option value="partner">partner</option>
      <option value="user">user</option>
    </select>
    <input class="input" name="password" placeholder="Password" required>
    <button class="btn primary">Add</button>
  </form>
</div>
<?php page_foot(); ?>
