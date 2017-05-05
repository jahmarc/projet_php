<?php include_once ROOT_DIR.'views/first-nav.inc';

//Collect data from controller
$msg = $this->vars['msg'];
$persistence = $this->vars['persistence'];

?>
<br><br><br><br><br>
<div>
<title>REGISTER | JASS VS</title>
	<p id="title">JASS VS</p>
</div>
<form method="post" action="<?php echo URL_DIR.'login/register';?>">
	<table align="center" id="tableLogin">		
		<tr>
			<td><?php echo $msg."<br/>";?>
			<h3>REGISTER | <a id="register" href="<?php echo URL_DIR.'login/login';?>"> LOGIN</a></h3>
						
			First name<br><input type="text" name="firstname" value="<?php echo $persistence[0];?>"><br>
			Last name<br><input type="text" name="lastname" value="<?php echo $persistence[1];?>"><br>
			User name<br><input type="text" name="username" value="<?php echo $persistence[2];?>"><br>
			Password<br><input type="password" name="password" value="<?php echo $persistence[3];?>"><br><br>
			<a class="CANCEL" href="<?php echo URL_DIR.'login/login'?>">CANCEL</a>
			<input class="OK" type="submit" name="action" value="Register"><br><br>
			
			</td>
		</tr>
	</table>
</form>

<?php 
unset($_SESSION['msg']);
include_once ROOT_DIR.'views/footer.inc';?>