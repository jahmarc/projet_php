<?php
include_once ROOT_DIR.'views/header.inc';

$msg = $this->vars['msg'];

?>

<br><br><br><br><br><br>
<title>Settings | JASS VS</title>


<div align="center" style="margin:0 auto; width:500px;">
	<h1><?php echo $msg;?></h1>
</div>







<?php 
	unset($_SESSION['msg']);
	include_once ROOT_DIR.'views/footer.inc';
?>