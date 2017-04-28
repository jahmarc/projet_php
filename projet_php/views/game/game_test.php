<?php
include_once ROOT_DIR.'views/nav-header.inc';
include_once ROOT_DIR.'views/header.inc';

//Collect data from controller and session
$msg = $this->vars['msg'];
$user = $_SESSION['user'];
?>

	
	<div style="padding-top:30px;">
    <div id="gameHeader">
        <div id="atout">
            Atout :
        </div>

        <div id="main">
            A la main :
        </div>

    </div>

    <div id="gauche">
		<p>Discussions</p>
		
		<input type="text" placeholder="messsage.... +  enter"  style="bottom:0; width:80%; position:absolute;padding:5px; margin-bottom:20px;" class="OK" />

		
    </div>

    <div id="droite">

    </div>

    <div id="table">
        <div id="player1">
            Player 1

            <img src="sources/cartes.png" id="carte1">

        </div>

        <div id="player2">
            Player 2

            <img src="sources/cartes.png" id="carte2">

        </div>

        <div id="player3">
            Player 3

            <table border="1" align="center">
                <td>Carte 1 </td>
                <td>Carte 2 </td>
                <td>Carte 3 </td>
                <td>Carte 4 </td>
                <td>Carte 5 </td>
                <td>Carte 6 </td>
                <td>Carte 7 </td>
                <td>Carte 8 </td>
                <td>Carte 9 </td>

            </table>

        </div>

        <div id="player4">
            Player 4

            <img src="cartes.png" id="carte4">


        </div>
    </div>


</div>
	
	
	
	
<br/><br/><br/><br/>
<?php 
unset($_SESSION['msg']);
include_once ROOT_DIR.'views/footer.inc';
?>

