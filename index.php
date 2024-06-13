<?php

if (!isset($_GET['user'])) {
	http_response_code(400);
	exit('Bad request');
}

$user = $_GET['user'];
$file = file_get_contents($user.'.json');
$items = json_decode($file, true);

if (isset($_GET['id'])) {
	$item = $items[$_GET['id']];
	$private_key = $item['key'];
	$key = trim(`oathtool -b --totp "$private_key"`);
}

?>
<!doctype html>
<html lang="ru">
<title>вКод!</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="main.css">

<?php if (isset($key)) echo '<div>Код для входа в '.$item['name'].':</div>' ?>
<div class="code"><?= $key ?? '------' ?></div>
<form class="item-list">
	<input type="hidden" name="user" value="<?= $user ?>">
<?php foreach ($items as $_id => $_item) { ?>
	<button class="item" name="id" value="<?= $_id ?>"><?= $_item['name'] ?></button>
<?php } ?>
</form>
