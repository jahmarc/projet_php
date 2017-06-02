<?php
include_once ROOT_DIR.'views/header.inc';
//ini_set("display_errors",0);error_reporting(0);

$msg = $this->vars['msg'];
$user = $_SESSION['user'];

?>

<br><br><br><br><br><br>
<title>Settings | JASS VS</title>


<div align="center" style="margin:0 auto; width:500px;">
	<h1><?php echo $msg;?><br></h1>
</div>


<style>
input[type=text], input[type=password], select {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

input[type=submit] {
    width: 100%;
    background-color: WHITE;
    color: BLACK;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type=submit]:hover {
    background-color: BLACK;
    COLOR:WHITE;
}

#div {
	color:white;
    border-radius: 5px;
    background-color: rgba(0, 161, 255, 0.85);
    padding: 20px;
    width:40%;
    margin:0 auto;
    }

label{
	color:white;
}
</style>


<div id="div">
  <form action="<?php echo URL_DIR.'user/edit';?>" method="post">
  
  
    <label>First Name</label>
    <input required type="text" id="fname" name="firstname" placeholder="Your name.." value="<?php echo $user->getFirstname(); ?>" >

    <label>Last Name</label>
    <input required type="text" id="lname" name="lastname" placeholder="Your last name.." value="<?php echo $user->getLastname(); ?>" >
    
    <label>Username</label>
    <input required type="text" id="uname" name="username" placeholder="Your username" value="<?php echo $user->getUsername(); ?>" >
  
    <label>Password</label>
    <input required type="password" id="pword" name="password" placeholder="Your password"  >
    
    <label>Confirm</label>
    <input required type="password" id="cword" name="confirmpassword" placeholder="Confirm password">
    
<!-- 
    <label for="country">Country</label>
    <select id="country" name="country">
      <option value="australia">Australia</option>
      <option value="canada">Canada</option>
      <option value="usa">USA</option>
    </select>
  -->
  <br><br><br>
  
    <input type="submit" name="Submit" class="OK" value="Edit">
  </form>
</div>



<br><br><br><br>
<br><br><br><br>
<?php 
	unset($_SESSION['msg']);
	include_once ROOT_DIR.'views/footer.inc';
?>