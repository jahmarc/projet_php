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
// chibre(int)
$chibre= $this->vars['chibre'] ;
// mes cartes (int[])
$myCards = $this->vars['myCards'] ;
$cards = Card::get36Cards();
$colors = Color::get4Colors();

// les cartes sur la table (int)
$cardMyPlayer = $this->vars['cardMyPlayer'] ;
$cardRight = $this->vars['cardRight'] ;
$cardFront= $this->vars['cardFront'] ;
$cardLeft= $this->vars['cardLeft'] ;

//Annonces et stock
$annonce = $this->vars['annonce'];
$stock = $this->vars['stock'];

// image du dos des cartes des joueurs
$imgCardBack="/".SITE_NAME."/css/sources/cartes/CardBackSide.jpg";
// image du dos des cartes des joueurs
$imgCardsBackinHand="/".SITE_NAME."/css/sources/cartes/CardsBackinHand.png";
// image du dos des cartes des joueurs
$imgCardCurrentPlay="/".SITE_NAME."/css/sources/play.png";

// les points
$pointsGame = $this->vars['pointsGame'];
if(empty($pointsGame)) $pointsGame = array(1 => 0,0);

$pointsDonne= $this->vars['pointsDonne'];
if(empty($pointsDonne)) $pointsDonne= array(1 => 0,0);

$pointsLastPli= $this->vars['pointsLastPli'];
if(empty($pointsLastPli)) $pointsLastPli= array(1 => 0,0);

?>

<!-- Timer qui refresh chaque 10 sec -->
<meta http-equiv="refresh" content="10;url=game">

<title>GAMING... | JASS VS</title>
<body style="background-color:black;">
	
	<div style="padding-top:5px;">
    <div id="gameHeader">
    	<h2><?php echo $designation;?></h2>
    </div>

    <div id="gauche" style="padding-left: 5px; margin-bottom: -50px;bottom: 0; margin-top: 70px;padding-top: 74px;">

		    <p id="discussion">Discussions</p>
		    
		    <?php include_once ROOT_DIR.'views/game/displaychat.php';?>

    </div>

    <div id="droite" >
    	<div style="float: left;padding: 13px;">
            <?php 
            if (!empty($atout)){
            		$a = Color::get4Colors()[$atout]->getPicture();
            		$b ="13%";
            		echo "<img width=".$b." src=".$a.">";
	            }
            ?>                 
            
         
        </div >

        <div style="float: left;padding: 13px;">
        <!-- 
            A la main : <?php 
            if (!empty($currentPlayer)){
            	//echo "Player [".$currentPlayer."]";
	            }
            ?>
            -->
        </div>
        
        <div style="float: left;padding: 13px;">
        	<table style="color:black; text-align:right; ">
	        	<tr style="background-color: black;
    color: white;">
			        		<td></td>
			        		<th>Team 1</th>
			        		<th>Team 2</th>
	        	</tr>
        		<tr style="border-bottom:1pt solid black;">
        		<th>Partie</th>
        		    <td><?php echo $pointsGame[1]?></td>
        			<td><?php echo $pointsGame[2]?></td>
        		</tr>
        		<tr>
        		    <th>Donne</th>
        				<td><?php echo $pointsDonne[1]?></td>
        				<td><?php echo $pointsDonne[2]?></td>
        		</tr>
        		<!-- <tr>
        			<th>Pli</th>
        			    <td><?php echo $pointsLastPli[1]?></td>
        			    <td><?php echo $pointsLastPli[2]?></td>
        		</tr>-->
        	
        	</table>
        
        
        </div>
       <!--choise your asset : -->
        <div>
			<!--si pas d'atout et c'est � moi de jouer : -->
			<?php if ($atout==0 && $myPlayer->getNrPlayer() == $currentPlayer) : ?>
		        <div>Choice your Asset : </div>
					<form action = <?= URL_DIR . 'game/setColorAsset_InDonne';?> method = "get">
			            <table align="center"  style="margin:0; padding:0px;margin-left:0px;">
							<tr id="choiceAsset">
	       					 <!--choise your colorsasset : -->
								<?php  for ($ndx= 1; $ndx<= 2; $ndx++): ?>
								<td id="mycolors12">
									<?php $url = $colors[$ndx]->getPicture();  ?>
									<input id="myCards" class="OK" type="submit"  value=""
										alt=<?= $colors[$ndx]->getDescription() ?> 
										name=<?= $ndx ?> 
										style=" border-style: solid;
									    border-width: 2px;
									    border-color: black;
									    border-radius: 4px;
									    margin: 0px;
									    background-repeat:no-repeat;
									    background-size:cover;
									    background-image:url('<?php echo $url;?>') ">
								</td> 
								<?php endfor; ?>
								</tr>
							<tr id="choiceAsset">
	       					 <!--choise your colorsasset : -->
								<?php  for ($ndx= 3; $ndx<= 4; $ndx++): ?>
								<td id="mycolors34">
									<?php $url = $colors[$ndx]->getPicture();  ?>
									<input id="myCards" class="OK" type="submit"  value=""
										alt=<?= $colors[$ndx]->getDescription() ?> 
										name=<?= $ndx ?> 
										style=" border-style: solid;
									    border-width: 2px;
									    border-color: black;
									    border-radius: 4px;
									    margin: 0px;
									    background-repeat:no-repeat;
									    background-size:cover;
									    background-image:url('<?php echo $url;?>') ">
								</td> 
								<?php endfor; ?>
								</tr>
				            </table>
						</form>
				<!--  if ($atout==0 && $myPlayer->getNrPlayer() == $currentPlayer) -->
				<?php if ($chibre==0) : ?>		
			        <div>
			        <!-- setChibreAsset_InDonne -->
			        	<form action = <?= URL_DIR . 'game/setChibreAsset_InDonne';?> method = "get">
			       			 <input id="chibre" class="OK" type="submit"  value="Chibrer Asset"
													name="Chibrer">
			        	</form>
			        </div>
				<?php endif ?>
			<?php endif ?>
		</div>
		<div style="padding:20px; font-size:10px;">
			<strong>Annonces</strong>
			<br/>
			<?php echo $annonce?>
			</br><br>
			<strong>Stock </strong>
			</br>
			<?php echo $stock?>
		</div>        
    </div>

    </div>

    <div id="table">
    
        <div id="playerFront">
            <table align="center">
				<tr>
					<td> 
			            <!--Player Front : -->
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
			            <!-- Player Left : --> 
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


		<div id="playerRight">
             <table align="center">
				<tr>
					<td> 
			           <!-- Player Right : -->
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
			            <img src=<?php echo $imageRight?> id="jetonPlay" alt="<?php echo $altRight; ?>" > 
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
			            <img style="width:90px;" src=<?php echo $imageMyCard?> id="behind" alt=<?php echo $altMyCard?> > 
					</td>
				</tr>
				<tr>
					<td> 
						<form action = <?= URL_DIR . 'game/setCard_InPli';?> method = "get">
				            <table align="center"  style="margin:0; padding:0px;margin-left:-170px;">
								<tr id="">
								<?php if ( empty($myCards)) : ?>
									<td> Waiting for play </td>
								<?php else : ?>
									<?php foreach ($myCards as $ndx): ?>
									<td id="myCards">
									
									<?php $url = $cards[$ndx]->getPicture(); 
									if($atout == 0 || $myPlayer->getNrPlayer() != $currentPlayer){
										$disabled = 'disabled';
									}
									else{
										$disabled = '';
									}
									?>
									
										<input id="myCards" class="OK" type="submit"  value="" 
										 	alt=<?= $cards[$ndx]->getShortDescription() ?> 
											name=<?= $ndx ?> 
											<?php echo $disabled;?>
											style="border-style: solid;
    border-width: 2px;
    border-color: black;
    border-radius: 4px;margin: -12px;background-repeat:no-repeat;background-size:cover;background-image:url('<?php echo $url;?>') ">
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

        
    </div>


	
	
	
	
<br/><br/><br/><br/>


<?php 
unset($_SESSION['msg']);
include_once ROOT_DIR.'views/footer.inc';
?>

