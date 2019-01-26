<?php
session_start();

session_unset();

session_destroy();


echo"Uloskirjautuminen onnistui!";

sleep(2);

$url ='harjoitustyo_kirjautuminen.php';
				echo "<html><head><META HTTP-EQUIV=Refresh CONTENT=\"1; URL=" .$url. "\"></head></html>";




?>