<?php 
session_start();

if (isset($_GET["varname"])) {
    
    $username=$_GET["varname"];
    
    $_SESSION['user']=$username;
    unset($_SESSION["orderid"]);
    unset($_SESSION["bidsid"]);
    
    
    $url ="hallintatyokalu.php?";
				echo "<html><head><META HTTP-EQUIV=Refresh CONTENT=\"0; URL=" .$url. "\"></head></html>";
}



?>