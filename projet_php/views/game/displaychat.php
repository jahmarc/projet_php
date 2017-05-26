<?php
// $idPart = $_SESSION['idPart'];
$user = $_SESSION['user'];
$idPart = 1;
Chat::newChat(1, 5, 'test');
?>
<body>
<?php $result=Chat::getChatsPart($idPart); ?>

<?php foreach ($result as $value): ?>
	<div><?= $value[1] ?> <?= $value[2] ?> <?= $value[3] ?></div>;
	<?php endforeach; ?>
	
<?

	
?>
<form method="post">
<input type="text" name="words" cols="20">
<input type="submit" value="Enter">
</form>
</body>
</html>
</body>