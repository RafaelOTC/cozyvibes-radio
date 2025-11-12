<?php
require_once __DIR__.'/../includes/utils.php';
require_once __DIR__.'/../includes/meta.php';
require_once __DIR__.'/../includes/auth.php';
require_login();
$streams = load_json('streams.json', []);
if($_SERVER['REQUEST_METHOD']==='POST'){
  $action = $_POST['action'] ?? '';
  if($action==='add'){
    $title = trim($_POST['title'] ?? '');
    $yt = trim($_POST['youtube_id'] ?? '');
    $genres = array_values(array_filter(array_map('trim', explode(',', $_POST['genres'] ?? ''))));
    $slug = slugify($title);
    $streams[] = ['id'=>uniqid('s_'),'slug'=>$slug,'title'=>$title,'youtube_id'=>$yt,'genres'=>$genres,'country'=>strtolower($_POST['country']??'xx'),'status'=>'live','created_at'=>now_iso()];
    save_json('streams.json',$streams);
    header('Location: streams.php'); exit;
  }
  if($action==='delete'){
    $id = $_POST['id'] ?? '';
    $streams = array_values(array_filter($streams, fn($s)=>$s['id']!==$id));
    save_json('streams.json',$streams);
    header('Location: streams.php'); exit;
  }
}
page_head('Admin • Streams');
?>
<div style="max-width:1100px;margin:0 auto;padding:24px 16px">
  <h2>Streams</h2>
  <table class="table">
    <tr><th>Title</th><th>Genres</th><th>Country</th><th></th></tr>
    <?php foreach($streams as $s): ?>
      <tr>
        <td><?= e($s['title']) ?></td>
        <td><?= e(implode(', ',$s['genres'] ?? [])) ?></td>
        <td><?= e(strtoupper($s['country'] ?? '')) ?></td>
        <td>
          <form method="post" style="display:inline">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="id" value="<?= e($s['id']) ?>">
            <button class="btn" onclick="return confirm('Delete stream?')">Delete</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
  <h3 style="margin-top:16px">Add new</h3>
  <form class="form" method="post">
    <input type="hidden" name="action" value="add">
    <input class="input" name="title" placeholder="Title" required>
    <input class="input" name="youtube_id" placeholder="YouTube ID" required>
    <input class="input" name="genres" placeholder="Genres (comma separated)">
    <input class="input" name="country" placeholder="Country code (e.g. ro, us)">
    <button class="btn primary">Add</button>
  </form>
</div>
<?php page_foot(); ?>
