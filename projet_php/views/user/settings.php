<?php
include_once ROOT_DIR.'views/header.inc';
ini_set("display_errors",0);error_reporting(0);

$msg = $this->vars['msg'];
$user = $this->vars['user'];
?>

<br><br><br><br><br><br>
<title>Settings | JASS VS</title>


<div align="center" style="margin:0 auto; width:500px;">
	<h1><?php echo $msg;?></h1>
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
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type=submit]:hover {
    background-color: #45a049;
}

#div {
    border-radius: 5px;
    background-color: #f2f2f2;
    padding: 20px;
    width:40%;
    margin:0 auto;
    }

label{
	color:black;
}
</style>


<div id="div">
  <form action="/action_page.php">
  
  
    <label for="uname">First Name</label>
    <input type="text" id="fname" name="firstname" placeholder="Your name..">

    <label for="lname">Last Name</label>
    <input type="text" id="lname" name="lastname" placeholder="Your last name..">
    
    <label for="fname">Username</label>
    <input type="text" id="uname" name="username" placeholder="Your username">
  
    <label for="pword">Password</label>
    <input type="password" id="pword" name="password" placeholder="Your password">
    
    <label for="cword">Confirm</label>
    <input type="password" id="cword" name="confirmpassword" placeholder="Confirm password">
    

    <label for="country">Country</label>
    <select id="country" name="country">
      <option value="australia">Australia</option>
      <option value="canada">Canada</option>
      <option value="usa">USA</option>
    </select>
  
    <input type="submit" value="Submit">
  </form>
</div>



<br><br><br><br>
<br><br><br><br>
<?php 
	unset($_SESSION['msg']);
	include_once ROOT_DIR.'views/footer.inc';
?>