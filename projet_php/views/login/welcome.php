<?php
include_once ROOT_DIR.'views/nav-header.inc';

//Collect data from controller and session
$msg = $this->vars['msg'];
$user = $_SESSION['user'];
?>


test


<br><br>
	<div align="center" style="margin-top:20px;"><?php echo $msg;?>
	<h1>Welcome <?php echo '<a style="color:#00a1ff;"> '.$user->getFirstname().' '.$user->getLastname();?></a>	</h1>	
	<h2>The list of registered users</h2>
	<?php
	
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "php_mvc";
	
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql = "SELECT id, firstname, lastname, username FROM user";
	$result = $conn->query($sql);
	
	?>
	
	<table id="tableLogin" style="margin-top:50px; width:40%;">
	
	<?php
	while($row = $result->fetch_assoc()) 
	{
		echo "	<tr>
					<td>USER : " . $row["username"]. "</td>
			  	</tr>
				<tr>
					<td style='padding-left:10%;'> NAME : " . $row["firstname"]. "</td>
					<td	> SURNAME : " . $row["lastname"]. "</td>
				</tr>
			
			<tr style='margin-top:50px;'><td></td></tr>";
	}
	
	
	?>
	</table>
	
	
	</div>	
	
	
	
	
	
				
	
<br/><br/><br/><br/>
<?php 
unset($_SESSION['msg']);
include_once ROOT_DIR.'views/footer.inc';
?>

