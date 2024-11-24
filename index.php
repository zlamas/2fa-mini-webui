<?php

$user = $_GET['user'];

if (!isset($user)) {
  http_response_code(400);
  exit('Bad request');
}

$file = file_get_contents($user.'.json');
$items = json_decode($file, true);
$refresh_elapsed = time() % 30;

header('Refresh: ' . 30 - $refresh_elapsed);

?>
<!doctype html>
<html lang="ru">
<title>вКод!</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="main.css">

<?php
foreach ($items as $item) {
  $private_key = $item['key'];
  $key = trim(`oathtool -b --totp "$private_key"`);
?>
<div class="item">
  <div class="item-name"><?= $item['name'] ?></div>
  <div class="key"><?= $key ?></div>
</div>
<?php } ?>
<div class="countdown" style="--delay: -<?= $refresh_elapsed ?>s"></div>
