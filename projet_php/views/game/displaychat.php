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
	<div class="scroll">
	<?php foreach($chats as $value): ?>
		<div><?php echo  $value->getUsername()?> : <?php echo $value->getTxtChat()?></div>
		</br>
		<?php endforeach;?>
		<?php endif;?>	
		</div>

	
<form method="post" action="<?php echo URL_DIR.'game/NewMessage';?>">
	<input type="text" name="message" cols="20" style="width:60%;" required value="<?php /*echo $persistence[0];*/?>">
	<input type="submit" value="Enter" class="OK">
</form>
</body>
</html>
</body>


