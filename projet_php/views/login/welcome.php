<?php 
include_once ROOT_DIR.'views/header.inc'; 

//Collect data from controller and session
$msg = $this->vars['msg'];
$user = $_SESSION['user'];
?>
<br><br>
	<div align="center"><?php echo $msg;?>
	<h1>Welcome <?php echo ' '.$user->getFirstname().' '.$user->getLastname();?></h1>	
	<h2>Please display here the list of registered users</h2>	
	<br>										
	<a href="<?php echo URL_DIR.'login/logout';?>">Logout</a>
	</div>				
	
<br/><br/><br/><br/>
<?php 
unset($_SESSION['msg']);
include_once ROOT_DIR.'views/footer.inc';
?>

