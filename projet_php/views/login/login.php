<?php include_once ROOT_DIR.'views/first-nav.inc';
//Collect data from controller
$msg = $this->vars['msg'];
?>

<br><br><br><br><br><br>
<div>

	<p>JASS</p>
</div>
<form action="<?php echo URL_DIR.'login/connection';?>" method="post">
	<table align="center" id="tableLogin" >		
		<tr>
			<td>
				<?php echo $msg;?>
				<h3>LOGIN |<a id="register" href="<?php echo URL_DIR.'login/newuser';?>">REGISTER</a>	</h3>			
				Username<br><input type="text" name="username" size="25"/><br>
				Password<br><input type="password" name="password" size="25"/><br><br>			
				<input class="OK" type="submit" name="Submit" value="  OK  "/>
				<br/><br/>							
								
			</td>
		</tr>
	</table>
</form>
<br/><br/><br/><br/>
<?php 
unset($_SESSION['msg']);
include_once ROOT_DIR.'views/footer.inc';
?>