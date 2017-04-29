<?php
include_once ROOT_DIR.'views/header.inc';

//Collect data from controller and session
$msg = $this->vars['msg'];
$user = $_SESSION['user'];
//$persistence = $this->vars['persistence'];
?>
<br><br><br><br><br><br>
	
	<form method="post" action="<?php echo URL_DIR.'party/register';?>">
	<table align="center" id="tableLogin">		
		<tr>
			<td>
			<h3>NEW PARTY</h3>						
			TABLE NAME<br><input type="text" name="designation" required value="<?php /*echo $persistence[0];*/?>"><br>
			<input class="OK" type="submit" name="action" value="CREATE"><br><br>
			
			</td>
		</tr>
	</table>
</form>
	
<br/><br/><br/><br/>
<?php 
unset($_SESSION['msg']);
include_once ROOT_DIR.'views/footer.inc';
?>

