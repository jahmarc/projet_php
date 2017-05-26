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
// joueur en cours (int)
$currentPlayer= $this->vars['currentPlayer'] ;
// atout (int)
$atout = $this->vars['atout'] ;
// mes cartes (int[])
$myCards = $this->vars['myCards'] ;
$cards = Card::get36Cards();
$colors = Color::get4Colors();

// les cartes sur la table (int)
$cardMyPlayer = $this->vars['cardMyPlayer'] ;
$cardRight = $this->vars['cardRight'] ;
$cardFront= $this->vars['cardFront'] ;
$cardLeft= $this->vars['cardLeft'] ;

// image du dos des cartes des joueurs
$imgCardBack="/".SITE_NAME."/css/sources/cartes/CardBackSide.jpg";
// image du dos des cartes des joueurs
$imgCardsBackinHand="/".SITE_NAME."/css/sources/cartes/CardsBackinHand.png";
// image du dos des cartes des joueurs
$imgCardCurrentPlay="/".SITE_NAME."/css/sources/play.png";

?>

<title>GAMING... | JASS VS</title>


<br><br>
	
	<div style="padding-top:5px;">
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
            	echo "Player [".$currentPlayer."]";
	            }
            ?>
            
        </div>

    </div>

    <div id="gauche" style="padding-left: 5px;
    margin-bottom: -50px;
    bottom: 0;
    margin-top: 70px;
    padding-top: 74px;">
        	
        	
    <p id="discussion">Discussions</p>
    
    	<?php include_once ROOT_DIR.'views/game/displaychat.php';?>


		
		
		
    </div>

    <div id="droite">

    </div>

    <div id="table">
    
        <div id="playerFront">
            <table align="center">
				<tr>
					<td> 
			            Player Front : 
			            <?php 
				            if (!empty($playerFront)){
				            	echo $playerFront->__toString();
				            }else{
				            	echo "Waiting for joing us";
				            }
			            ?>
					</td>
				</tr>
				<tr>
					<td> 
			            <img src=<?php echo $imgCardsBackinHand?> class="carte" style="transform: rotate(65deg);" > 
					</td>
				</tr>
				<tr>
					<td> 
			            <?php 
			            $imageFront= $imgCardBack;
			            $altFront = "";
			            if (!empty($cardFront)){
			            		$imageFront=$cards[$cardFront]->getPicture();
			            		$altFront = $cards[$cardFront]->getShortDescription();
			            }elseif(!empty($playerFront)){
			            	if ($playerFront->getNrPlayer() == $currentPlayer){
			            		$imageFront= $imgCardCurrentPlay;
			            		$altFront= "Current player";
			            	}
			            }
			            ?>
			            <img class="carte" style="width:50px;" src=<?php echo $imageFront?> id="carte2" alt=<?php echo $altFront ?> >
					</td>
				</tr>
            </table>
        </div>

        <div id="playerleft">
             <table align="center">
				<tr>
					<td> 
			            Player Left : 
			            <?php 
				            if (!empty($playerLeft)){
				            	echo $playerLeft->__toString();
				            }else{
				            	echo "Waiting for joing us";
				            }
			            ?>
					</td>
				</tr>
				<tr>
					<td> 
			            <img src=<?php echo $imgCardsBackinHand?> class="carte" > 
					</td>
				</tr>
				<tr>
					<td> 
			            <?php 
			            	$imageLeft = $imgCardBack;
			            	$altLeft = "";
			            	if (!empty($cardLeft)){
			            		$imageLeft=$cards[$cardLeft]->getPicture();
			            		$altLeft = $cards[$cardLeft]->getShortDescription();
			            	}elseif(!empty($playerLeft)){
			            		if ($playerLeft->getNrPlayer() == $currentPlayer){
			            			$imageLeft = $imgCardCurrentPlay;
			            			$altLeft = "Current player";
			            		}
			            	}
			            ?>
			            <img src=<?php echo $imageLeft?> id="behind" alt=<?php echo $altLeft ?> > 
					</td>
				</tr>
            </table>
        </div>

        <div id="myPlayer">
             <table align="center">
				<tr>
					<td> 
			            <?php 
			            	$imageMyCard = $imgCardBack;
			            	$altMyCard = "";
			            	if (!empty($cardMyPlayer)){
			            		$imageMyCard=$cards[$cardMyPlayer]->getPicture();
			            		$altMyCard= $cards[$cardMyPlayer]->getShortDescription();
			            	}elseif(!empty($myPlayer)){
			            		if ($myPlayer->getNrPlayer() == $currentPlayer){
			            			$imageMyCard= $imgCardCurrentPlay;
			            			$altMyCard= "Current player";
			            		}
			            	}
			            ?>
			            <img src=<?php echo $imageMyCard?> id="behind" alt=<?php echo $altMyCard?> > 
					</td>
				</tr>
				<tr>
					<td> 
						<form action = <?= URL_DIR . 'game/setCard_InPli';?> method = "get">
				            <table align="center" style="margin-left:-170px;">
								<tr>
								<?php if ( empty($myCards)) : ?>
									<td> Waiting for play </td>
								<?php else : ?>
									<?php foreach ($myCards as $ndx): ?>
									<td>
										<input class="OK" type="submit" 
											value=<?= $cards[$ndx]->getShortDescription() ?> 
											name=<?= $ndx ?> >
									</td> 
									<?php endforeach; ?>
								<?php endif ?>
								</tr>
				            </table>
						</form>
					</td>
				</tr>
				<tr>
					<td> 
			            Player : 
			            <?php 
				            if (!empty($myPlayer)){
				            	echo $myPlayer->__toString();
				            }else{
				            	echo "Waiting for joing us";
				            }
			            ?>
					</td>
				</tr>
            </table>
        </div>

        <div id="playerRight">
             <table align="center">
				<tr>
					<td> 
			            Player Right : 
			            <?php 
				            if (!empty($playerRight)){
				            	echo $playerRight->__toString();
				            }else{
				            	echo "Waiting for joing us";
				            }
			            ?>
					</td>
				</tr>
				<tr>
					<td> 
			            <img src=<?php echo $imgCardsBackinHand?> class="carte" style="transform: rotate(180deg);" > 
					</td>
				</tr>
				<tr>
					<td> 
			            <?php 
			            	$imageRight= $imgCardBack;
			            	$altRight = "";
			            	if (!empty($cardRight)){
			            		$imageRight=$cards[$cardRight]->getPicture();
			            		$altRight = $cards[$cardRight]->getShortDescription();
			            	}elseif(!empty($playerRight)){
			            		if ($playerRight->getNrPlayer() == $currentPlayer){
			            			$imageRight= $imgCardCurrentPlay;
			            			$altRight = "Current player";
			            		}
			            	}
			            ?>
			            <img src=<?php echo $imageRight?> id="jetonPlay" alt=<?php echo $altRight ?> > 
					</td>
				</tr>
            </table>
        </div>
    </div>


</div>
	
	
	
	
<br/><br/><br/><br/>
<?php 
unset($_SESSION['msg']);
include_once ROOT_DIR.'views/footer.inc';
?>

