<?php
include_once ROOT_DIR.'views/header.inc';

$msg = $this->vars['msg'];
$user = $_SESSION['user'];

?>

<br><br><br><br><br><br>


<div>
	<?php include URL_DIR.'party/showTables';

echo $msg;



	?>
	
	
		
		
		
		
	
	</form>
	
	
	
	
	
	
	
	
	
	
	

</div>



<br/><br/><br/><br/>

<?php 
unset($_SESSION['msg']);
include_once ROOT_DIR.'views/footer.inc';
?>