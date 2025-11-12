<?php
require_once __DIR__.'/../includes/utils.php';
require_once __DIR__.'/../includes/meta.php';
require_once __DIR__.'/../includes/auth.php';
require_login();
$comments = load_json('comments.json', []);
if($_SERVER['REQUEST_METHOD']==='POST'){
  $id = $_POST['id'] ?? '';
  $act = $_POST['act'] ?? '';
  foreach($comments as &$c){
    if($c['id']===$id){
      if($act==='approve') $c['status']='approved';
      if($act==='reject') $c['status']='rejected';
    }
  }
  save_json('comments.json',$comments);
  header('Location: moderation.php'); exit;
}
page_head('Admin • Moderation');
?>
<div style="max-width:1000px;margin:0 auto;padding:24px 16px">
  <h2>Comentarii în așteptare</h2>
  <table class="table"><tr><th>Stream</th><th>Text</th><th>Creat</th><th>Actiuni</th></tr>
  <?php foreach($comments as $c): if(($c['status']??'')!=='pending') continue; ?>
    <tr>
      <td><?= e($c['slug']) ?></td>
      <td><?= e($c['text']) ?></td>
      <td><?= e($c['created_at']) ?></td>
      <td>
        <form method="post" style="display:inline"><input type="hidden" name="id" value="<?= e($c['id']) ?>"><input type="hidden" name="act" value="approve"><button class="btn">Approve</button></form>
        <form method="post" style="display:inline"><input type="hidden" name="id" value="<?= e($c['id']) ?>"><input type="hidden" name="act" value="reject"><button class="btn">Reject</button></form>
      </td>
    </tr>
  <?php endforeach; ?>
  </table>
</div>
<?php page_foot(); ?>
