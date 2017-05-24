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
// joueur en cours
$currentPlayer= $this->vars['currentPlayer'] ;
// atout
$atout = $this->vars['atout'] ;
// mes cartes
$myCards = $this->vars['myCards'] ;
$cards = Card::get36Cards();
$colors = Color::get4Colors();

?>

<title>GAMING... | JASS VS</title>

<p><?php echo $designation;?></p>


	
	<div style="padding-top:30px;">
    <div id="gameHeader">
        <div id="atout">
            Atout : 
            <?php 
            if (!empty($atout)){
            		echo Color::get4Colors()[$atout]->toString();
	            }
            ?>
            
        </div>

        <div id="main">
            A la main : <?php 
            if (!empty($currentPlayer)){
            	echo $currentPlayer;
	            }
            ?>
            
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
            
	<form action = <?= URL_DIR . 'game/setCard_InPli';?> method = "get">
            <table border="1" align="center">
				<tr>
				<?php if ( empty($myCards)) : ?>
					<td> Waiting for play </td>
				<?php else : ?>
					<?php foreach ($myCards as $ndx): ?>
					<td>
						<input class="OK" type="submit" 
							src=<?= $cards[$ndx]->getPicture() ?>
							value=<?= $cards[$ndx]->getShortDescription() ?> 
							name=<?= $ndx ?> >
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

