<?php
require_once __DIR__.'/../includes/utils.php';
require_once __DIR__.'/../includes/auth.php';
require_login();
$stamp = date('Ymd_His');
$dir = cfg()['data_dir'].'/backups';
@mkdir($dir,0775,true);
$files = ['streams.json','users.json','settings.json','comments.json','reactions.json','analytics.json'];
$bundle = [];
foreach($files as $f){
  $path = cfg()['data_dir'].'/'.$f;
  $bundle[$f] = file_exists($path) ? json_decode(file_get_contents($path), true) : null;
}
$dest = $dir."/backup_$stamp.json";
file_put_contents($dest, json_encode($bundle, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
header('Content-Type: application/json'); echo json_encode(['ok'=>true,'file'=>basename($dest)]);
