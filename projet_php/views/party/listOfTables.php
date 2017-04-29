<?php
include_once ROOT_DIR.'views/header.inc';

$msg = $this->vars['msg'];
$user = $_SESSION['user'];

?>

<br><br><br><br><br><br>

<h2><?php echo $msg;?></h2>


<div style="margin:0 auto; width:400px;">

<?php $this->echoPartsPending(); ?>
	

</div>



<br/><br/><br/><br/>

<?php 
unset($_SESSION['msg']);
include_once ROOT_DIR.'views/footer.inc';
?>