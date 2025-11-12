<?php
require_once __DIR__.'/includes/utils.php';
header('Content-Type: application/rss+xml; charset=utf-8');
$streams = load_json('streams.json', []);
$base = base_url();
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
?>
<rss version="2.0"><channel>
<title>Cozy Vibes Radio</title>
<link><?= e($base) ?></link>
<description>Streams cozy: lo-fi, chill, jazz, ambient.</description>
<?php foreach($streams as $s): ?>
<item>
  <title><?= e($s['title']) ?></title>
  <link><?= e($base.'stream.php?slug='.$s['slug']) ?></link>
  <guid><?= e($s['id']) ?></guid>
  <pubDate><?= e($s['created_at']) ?></pubDate>
</item>
<?php endforeach; ?>
</channel></rss>
