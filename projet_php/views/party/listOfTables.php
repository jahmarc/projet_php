<?php
include_once ROOT_DIR.'views/header.inc';

$msg = $this->vars['msg'];
$user = $_SESSION['user'];
$strPparts = $this->vars['strPparts']

?>

<br><br><br><br><br><br>
<title>List Of Tables | JASS VS</title>


<div align="center" style="margin:0 auto; width:500px;">

	<h1><?php echo $msg;?></h1>
</div>


<div style="margin:0 auto; width:600px;">	
	<?php 
	//$this->echoPartsPending(); 
	$link = URL_DIR . 'party/partyRegister';
	
	echo '<form action="' . $link . '" method="get">';
	
	echo '<table align="center" style="border-bottom-style="double">';
	
	foreach ($strPparts as $value)
	{
		//echo '<tr><td>' . $value [1] . '</td><td>' . $value [2] . '</td><td><input class="OK" type="submit" value="inscription" name="' . $value [0] . '"></td></tr>';
	}
	
	echo '</table></form>'
	
	?>
</div>



<br/><br/><br/><br/>

<?php 
unset($_SESSION['msg']);
include_once ROOT_DIR.'views/footer.inc';
?>