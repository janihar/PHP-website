<?php
session_start(); //aloitetaan sessio
require_once("db.inc");

if ( isset($_GET["rbids"])) {
$remove_bids=$_SESSION['bidsid']; //hankitaan poistettava tarjouspyynnön id sessiosta.

$query="DELETE FROM `bids` WHERE bids_id='$remove_bids'"; //poistolause. Poistetaan kaikki tiedot pyynnöstä.

mysqli_query($conn,$query); //ei tarvetta virheenestolle, sillä poistossa sitä ei tarvitse!

unset($_SESSION['bidsid']); //poistetaan vain tämä tietty sessio. Kun harjoitustyo_etusivulle palataan suoritetaan alla oleva if etusivulla! Eli sessio poistetaan niin sivu pomppaa takaisin suoraan omiin tilauksiin.
/*
if (!empty($_SESSION['bidsid'])) {
        ?>
    openCity(event, 'bidsspecs');
      <?php
    }

*/

 echo '<script type="text/javascript">alert("Tarjouspyyntö poistettiin!");</script>';
$url ="harjoitustyo_etusivu.php?";
				echo "<html><head><META HTTP-EQUIV=Refresh CONTENT=\"0; URL=" .$url. "\"></head></html>";


}

if (isset ($_GET["abids"])) {

    $accept_bids=$_SESSION['bidsid'];

    $query="SELECT * FROM bids WHERE bids_id='$accept_bids'";

    $result1=mysqli_query($conn,$query);

    if (!$result1) {

        echo "SQL-lause virhe".mysqli_error($conn);
    }

    else {

        while ($row=mysqli_fetch_array($result1, MYSQLI_ASSOC)) {

            $details=$row["details"];
            $cost=$row["cost"];
            $left_date=$row["left_date"];
            $status=$row["status"];
            $username=$row["username"];

            $query="INSERT INTO `order` (`order_id`,`desc`,`order_date`,acc_date,start_date,end_date,comments,hours,articles,cost,status,username) VALUES (null,'$details','$left_date',DATE_FORMAT(CURRENT_TIMESTAMP,'%d.%m.%Y %H:%i:%s'),null,null,null,null,null,'$cost','$status','$username')";

            $result=mysqli_query($conn,$query);

            if (!$result) {

        echo "SQL-lause virhe".mysqli_error($conn);
    }

            else {


            }


        }


    }


}




?>
