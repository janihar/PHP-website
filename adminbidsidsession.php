<?php 
session_start();

if (isset($_GET["varname"])) {
    
    $bids_id=$_GET["varname"];
    
    $_SESSION['bidsid']=$bids_id;
    unset($_SESSION["orderid"]);
    
    $url ="hallintatyokalu.php?";
				echo "<html><head><META HTTP-EQUIV=Refresh CONTENT=\"0; URL=" .$url. "\"></head></html>";
}



?>