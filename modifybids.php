<?php
session_start();
require_once("db.inc");


if ( isset($_GET["mbids"])) {
    
    if (isset($_GET["details"])) {
        
        $details=$_GET["details"];
        $bids_id=$_SESSION["bidsid"];
        
        $query= "UPDATE `bids` SET `details` = '$details',left_date= CURRENT_TIMESTAMP WHERE bids_id = '$bids_id' ";
        
        $result=mysqli_query($conn,$query);
        
        if (!$result) {
            
            
            echo "Kysely epäonnistui " . mysqli_error($conn);
        }
        
        else {
            unset($_SESSION["bidsid"]);
            
            echo '<script type="text/javascript">alert("Tarjouspyyntö on muokattu!");</script>';
            $url ="harjoitustyo_etusivu.php?";
				echo "<html><head><META HTTP-EQUIV=Refresh CONTENT=\"0; URL=" .$url. "\"></head></html>";
        }
        
        
    }
    
}

if ( isset($_GET["bsave"])) {
    
 
    if (isset($_GET["approx"])) {
        
        $approx=$_GET["approx"];
        $bids_id=$_SESSION["bidsid"];
        
        if (!empty($approx)) {
        
        $query= "UPDATE `bids` SET `cost` = '$approx', status='VASTATTU', answer_date= CURRENT_TIMESTAMP WHERE bids_id = '$bids_id' ";
        
        $result=mysqli_query($conn,$query);
        
        if (!$result) {
            
            
            echo "Kysely epäonnistui " . mysqli_error($conn);
        }
        
        else {
            unset($_SESSION["bidsid"]);
            
            echo '<script type="text/javascript">alert("Tarjouspyyntö on muokattu!");</script>';
            $url ="hallintatyokalu.php?";
				echo "<html><head><META HTTP-EQUIV=Refresh CONTENT=\"2; URL=" .$url. "\"></head></html>";
        }
    }
        
        else {
            unset($_SESSION["bidsid"]);
            echo '<script type="text/javascript">alert("Syötä kustannusarvio!");</script>';
            $url ="hallintatyokalu.php?";
				echo "<html><head><META HTTP-EQUIV=Refresh CONTENT=\"2; URL=" .$url. "\"></head></html>";
        }
        
        
    }
    
}







?>