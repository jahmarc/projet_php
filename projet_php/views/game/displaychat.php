<?php
// $idPart = $_SESSION['idPart'];
$user = $_SESSION['user'];
$idPart = 1;
$chats = $this->vars['chat'];
?>
<body>
<?php if ( empty($chats)) : ?>
	<div>No messages</div>
<?php else :?>
	<?php foreach($chats as $value): ?>
		<div><?php echo  $value->getUsername()?> : <?php echo $value->getTxtChat()?></div>
		</br>
		<?php endforeach;?>
		<?php endif;?>	

	
<form method="post" action="<?php echo URL_DIR.'game/NewMessage';?>">
	<input type="text" name="message" cols="20" required value="<?php /*echo $persistence[0];*/?>">
	<input type="submit" value="Enter">
</form>
</body>
</html>
</body>


