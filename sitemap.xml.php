<?php
require_once __DIR__.'/includes/utils.php';
header('Content-Type: application/xml; charset=utf-8');
$streams = load_json('streams.json', []);
$base = rtrim(base_url(),'/').'/';
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<url><loc><?= e($base) ?></loc></url>
<url><loc><?= e($base.'about.php') ?></loc></url>
<url><loc><?= e($base.'partners.php') ?></loc></url>
<url><loc><?= e($base.'legal.php') ?></loc></url>
<?php foreach($streams as $s): ?>
<url><loc><?= e($base.'stream.php?slug='.$s['slug']) ?></loc></url>
<?php endforeach; ?>
</urlset>
