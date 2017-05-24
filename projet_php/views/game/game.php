<?php
include_once ROOT_DIR.'views/header.inc';
//Collect data from controller and session
$user = $_SESSION['user'];
$idPart = $_SESSION['idPart'];

$msg = $this->vars['msg'];
$designation = $this->vars['designation'];

// Player $myPlayer = new Player())
$myPlayer= $this->vars['myPlayer'];
$playerRight = $this->vars['playerRight'];
$playerFront = $this->vars['playerFront'];
$playerLeft = $this->vars['playerLeft'];
// atout
$atout = $this->vars['atout'] ;
// mes cartes 
$myCards = $this->vars['myCards'] ;
$cards = Card::get36Cards();
$colors = Color::get4Colors();

?>

<title>GAMING... | JASS VS</title>


	<div style="padding-top:30px;">
    <div id="gameHeader">
        <div id="atout">
            Atout : <?php echo $atout;?>
            <?php 
            if (!empty($atout)){
            		echo Color::get4Colors()[$atout]->toString();
	            }
            ?>
            
        </div>

        <div id="main">
            A la main : <?php echo $designation;?>
        </div>

    </div>

    <div id="gauche">

        	
    <p>Discussions</p>
    
    	<iframe style="width:240px; bottom: 49px;position: fixed;">
    	<input type="text" placeholder="messsage.... +  enter"  style="bottom:0; width:80%; position:absolute;padding:5px; margin-bottom:20px;" class="OK" />
    
    </iframe>
    

		
		
		
    </div>

    <div id="droite">

    </div>

    <div id="table">
        <div id="playerFront">
            Player Front: 
            <?php 
	            if (!empty($playerFront)){
	            	echo $playerFront->__toString();
	            }
            ?>

            <img src="sources/cartes.png" id="carte1">

        </div>

        <div id="playerleft">
            Player Left:
            <?php 
	            if (!empty($playerLeft)){
	            	echo $playerLeft->__toString();
	            }
            ?>

            <img src="sources/cartes.png" id="carte2">

        </div>

        <div id="myPlayer">
            Player :
            <?php 
	            if (!empty($myPlayer)){
	            	echo $myPlayer->__toString();
	            }
            ?>
            
            <table align="center" style="    margin-left: -195px;">
	<form action = <?= URL_DIR . 'game/setCard_InPli';?> method = "get">
				<tr>
				<?php if ( empty($myCards)) : ?>
					<td> Waiting for play </td>
				<?php else : ?>
					<?php foreach ($myCards as $ndx): ?>
						<td> <?= $cards[$ndx]->getDescription() ?> </td>
<!-- 						<td> <input class="OK" type="submit"  value="inscription" name=?> </td> -->
					<td>
						<input class="OK" type="image"  
							value=<?= $cards[$ndx]->getShortDescription() ?> name=<?= $ndx ?>
							src="sources/cartes/C1.png" >
							
						<input class="OK" type="submit"  
							value=<?= $cards[$ndx]->getShortDescription() ?> name=<?= $ndx ?>
							src="sources/cartes/<?php echo $cards[$ndx]->getShortDescription()?>.png" >
						
					</td> 
					<?php endforeach; ?>
				<?php endif ?>
				</tr>
            </table>
	</form>

        </div>

        <div id="playerRight">
            Player Right:
            <?php 
	            if (!empty($playerRight)){
	            	echo $playerRight->__toString();
	            }
            ?>

            <img src="cartes.png" id="carte4">


        </div>
    </div>


</div>
	
	
	
	
<br/><br/><br/><br/>
<?php 
unset($_SESSION['msg']);
include_once ROOT_DIR.'views/footer.inc';
?>

