<?php
include_once ROOT_DIR.'views/header.inc';

//Collect data from controller and session
$msg = $this->vars['msg'];
$strUsers = $this->vars ['strUsers'];
$user = $_SESSION['user'];
?>
<title>WELCOME | JASS VS</title>


<br><br>
	<div style="margin-top: 12px;
    display: list-item;">
		<!-- <a href="<?php echo URL_DIR.'game/game_test';?>">New Game</a>7-->
		<a href="<?php echo URL_DIR.'party/listoftables';?>" type="button" class="OK">JOIN A PARTY</a>	
		<a href="<?php echo URL_DIR.'party/newparty';?>" type="button" class="OK">NEW PARTY</a>	
	</div>
	
	<div align="center" style="margin-top:20px;">
	
		<h1>Welcome <?php echo '<a style="color:#00a1ff;"> '.$user->getFirstname().' '.$user->getLastname();?></a>	</h1>	
			
		<h2>The list of registered users</h2>
		
		<table id="tableLogin" style="margin-top:50px; width:40%;">
			<?php foreach ($strUsers as $value): ?>
			
				<tr>
				<td><strong>USER : <?= $value[2] ?></strong></td>
				</tr>
				<tr>
					<td style='padding-left: 10%;'>NAME : <?= $value[0] ?></td>
					<td> SURNAME : <?= $value[1] ?></td>
				</tr>
				<tr>
					<td><hr></td>
					<td><hr></td>
				</tr>
			
		    <?php endforeach; ?>
		</table>
	
	</div>			
	
<br/><br/><br/><br/>
<?php 
unset($_SESSION['msg']);
include_once ROOT_DIR.'views/footer.inc';
?>

