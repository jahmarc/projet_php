<?php
include_once ROOT_DIR.'views/header.inc';

$msg = $this->vars['msg'];
$user = $_SESSION['user'];
$strPparts = $this->vars['strPparts']
?>
<br><br><br><br><br><br>
<title>My Games | JASS VS</title>


<div align="center" style="margin:0 auto; width:500px;">
	<h1><?php echo $msg;?></h1>
</div>


<div style="margin:0 auto; width:600px;">	
	<?php $link = URL_DIR . 'party/partyContinous'; ?>
	<form action = <?= $link ?> method = "get">
		<table align="center" style="border-bottom-style="double">
			<?php if ( empty($strPparts)) : ?>
				<tr>
					<td> No games waiting to start for the moment </td>
				</tr>
			<?php else : ?>
				<?php foreach ($strPparts as $value): ?>
					<tr>
						<td> <?= $value[1] ?> </td>
						<td> <?= $value[2] ?> </td>
						<?php if ($value[2] != 99) : ?>
							<td> 
							<?php if($value[6] == 1) echo 'Winner'; ?> 
							</td>
						<?php else : ?>
							<td> 
							<input class="OK" type="submit" 
									value="Play" name=<?= $value[0] ?>>
							</td>
						<?php endif ?>
					</tr>
				<?php endforeach; ?>
			<?php endif ?>
		</table>
	</form>
</div>

<br/><br/><br/><br/>

<?php 
	unset($_SESSION['msg']);
	include_once ROOT_DIR.'views/footer.inc';
?>