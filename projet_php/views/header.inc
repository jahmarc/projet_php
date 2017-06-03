<!DOCTYPE html 
     PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
     
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>	
		<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
		<link rel="stylesheet" href="/<?php echo SITE_NAME; ?>/css/styles.css" type="text/css">
		<link rel="stylesheet" href="/<?php echo SITE_NAME; ?>/css/login.css" type="text/css"></link>
		<link rel="stylesheet" href="/<?php echo SITE_NAME; ?>/css/chat.css" type="text/css"></link>
		<link rel="icon" image/x-icon href="/<?php echo SITE_NAME; ?>/css/sources/favicon.ico" />
		
		<?php 
		$user = $_SESSION['user'];
		?>
		
	</head>  
	<body>

	<body>
	
	<!-- Nav Bar  -->
		<nav>
		<ul id="ul-left">
			<li><a href="<?php echo URL_DIR.'login/welcome';?>">
					<p id="title-nav">JASS VS</p></a></li>
		</ul>
			<ul>
			<li class="li-right"><a href="<?php echo URL_DIR.'login/welcome';?>">Home</a></li>
				
				 <li class="li-right"><ul>
				 		<li>
				 			<div id="dropMenu" class="dropdown" style="padding-left: 56px;padding-right: 56px;padding-bottom: 14%;	">
				 			
				 				 <span><?php echo $user->getFirstname();?></span></a>
								  <div class="dropdown-content" style="padding-left: 0;
    padding-right: 0;
    margin-right: 0;
    margin-top: 0;">
								     <a class="dropdown" style="text-decoration: none;width: 100%;" href="<?php echo URL_DIR.'party/mygames';?>">My Games</a>
								     <a class="dropdown" style="text-decoration: none;width: 100%;" href="<?php echo URL_DIR.'user/settings';?>">Settings</a>
								  </div>

				 			</div>
				 		</li>
				 	</ul>
				 
				 </li>
				 
				
				 
				 <li class="li-right"><a href="<?php echo URL_DIR.'login/logout';?>">LOGOUT</a></li>
			</ul>
		</nav>
	
	

