<?php
include_once ROOT_DIR.'views/header.inc';

//Collect data from controller and session
$msg = $this->vars['msg'];
$user = $_SESSION['user'];
?>
<title>WELCOME | JASS VS</title>


<br><br>
	<div style="display: inline-block; margin-top:20px;">
		<!-- <a href="<?php echo URL_DIR.'game/game_test';?>">New Game</a>7-->
		<a href="<?php echo URL_DIR.'party/listOfTables';?>" type="button" class="OK">JOIN A PARTY</a>	
		<a href="<?php echo URL_DIR.'party/newParty';?>" type="button" class="OK">NEW PARTY</a>	
	</div>
	
	<div align="center" style="margin-top:20px;"><?php echo $msg;?>

		
		<h1>Welcome <?php echo '<a style="color:#00a1ff;"> '.$user->getFirstname().' '.$user->getLastname();?></a>	</h1>	
		<h2>The list of registered users</h2>
		
		<table id="tableLogin" style="margin-top:50px; width:40%;">
		
		<?php $this->echoListOfOthersUsers();?>
		
		</table>
	
	</div>			
	
<br/><br/><br/><br/>
<?php 
unset($_SESSION['msg']);
include_once ROOT_DIR.'views/footer.inc';
?>

