<?php
include_once ROOT_DIR.'views/header.inc';

$msg = $this->vars['msg'];
$user = $_SESSION['user'];

?>

<br><br><br><br><br><br>

	


<div align="center" style="margin:0 auto; width:500px;">

	<h1><?php echo $msg;?></h1>
</div>


<div style="margin:0 auto; width:800px;">	
	<?php $this->echoPartsPending(); ?>
	

</div>



<br/><br/><br/><br/>

<?php 
unset($_SESSION['msg']);
include_once ROOT_DIR.'views/footer.inc';
?>