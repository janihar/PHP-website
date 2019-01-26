<?php
session_start();
/*

tätä osiota kutsutaan kun käyttäjä menee omiin tarjouspyyntöihin ja klikkaa sen auki! Täällä sessio tallennetaan 

*/

if (isset($_GET["varname"])) {
    
    $bids_id=$_GET["varname"];
    
    $_SESSION['bidsid']=$bids_id;
    
    unset($_SESSION["orderid"]);
    
     $url ="harjoitustyo_etusivu.php?";
				echo "<html><head><META HTTP-EQUIV=Refresh CONTENT=\"0; URL=" .$url. "\"></head></html>";
}






?>