<?php
require_once __DIR__.'/../includes/utils.php';
require_once __DIR__.'/../includes/meta.php';
require_once __DIR__.'/../includes/auth.php';
require_login();
$user = current_user();
if($_SERVER['REQUEST_METHOD']==='POST'){
  $streams = load_json('streams.json', []);
  $title = trim($_POST['title'] ?? '');
  $yt = trim($_POST['youtube_id'] ?? '');
  $genres = array_values(array_filter(array_map('trim', explode(',', $_POST['genres'] ?? ''))));
  $slug = slugify($title);
  $streams[] = ['id'=>uniqid('s_'),'slug'=>$slug,'title'=>$title,'youtube_id'=>$yt,'genres'=>$genres,'country'=>strtolower($_POST['country']??'xx'),'status'=>'live','owner'=>$user['id'],'created_at'=>now_iso()];
  save_json('streams.json',$streams);
  header('Location: index.php'); exit;
}
page_head('Partner • Add Stream');
?>
<div style="max-width:760px;margin:0 auto;padding:24px 16px">
  <h2>Adaugă stream</h2>
  <form class="form" method="post">
    <input class="input" name="title" placeholder="Titlu" required>
    <input class="input" name="youtube_id" placeholder="YouTube ID" required>
    <input class="input" name="genres" placeholder="Genuri (separate prin virgulă)">
    <input class="input" name="country" placeholder="Cod țară (ro, us, jp)">
    <button class="btn primary">Creează</button>
  </form>
</div>
<?php page_foot(); ?>
