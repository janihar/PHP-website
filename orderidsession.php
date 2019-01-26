<?php 
session_start();

if (isset($_GET["varname"])) {
    
    $order_id=$_GET["varname"];
    
    $_SESSION['orderid']=$order_id;
    unset($_SESSION["bidsid"]);
    $url ="harjoitustyo_etusivu.php?";
				echo "<html><head><META HTTP-EQUIV=Refresh CONTENT=\"0; URL=" .$url. "\"></head></html>";
}



?>