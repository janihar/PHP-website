<?php
session_start(); //aloitetaan sessio
require_once("db.inc");
$remove_id=$_SESSION['orderid']; //hankitaan poistettava tilauksen_id sessiosta.

$query="DELETE FROM `order` WHERE order_id='$remove_id'"; //poistolause. Poistetaan kaikki tiedot tilauksesta.

mysqli_query($conn,$query); //ei tarvetta virheenestolle, sillä poistossa sitä ei tarvitse!

unset($_SESSION['orderid']); //poistetaan vain tämä tietty sessio. Kun harjoitustyo_etusivulle palataan suoritetaan alla oleva if etusivulla! Eli sessio poistetaan niin sivu pomppaa takaisin suoraan omiin tilauksiin.
/*
if (!empty($_SESSION['orderid'])) {
        ?>
    openCity(event, 'specs');
      <?php  
    }

*/
 echo '<script type="text/javascript">alert("Tilaus poistettiin!");</script>';
$url ="harjoitustyo_etusivu.php?";
				echo "<html><head><META HTTP-EQUIV=Refresh CONTENT=\"0; URL=" .$url. "\"></head></html>";







?>