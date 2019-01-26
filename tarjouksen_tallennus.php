<?php
session_start();

require_once("db.inc");

$username=$_SESSION['login_user'];

if ( isset($_GET["makebid"])) {
    
    
    if ( isset($_GET["comment"])) {
        
        $comment=$_GET["comment"];
        
        
        
        $query="INSERT INTO bids (details,left_date,cost,answer_date,status,username) VALUES ('$comment',CURRENT_TIMESTAMP,null,null,'JÄTETTY','$username')";
        
        $result=mysqli_query($conn,$query);
        
        if (!$result) {
            
            echo "Kysely epäonnistui".mysqli_error($conn);
        }
        
        else {
            
            echo '<script type="text/javascript">alert("Työtarjous jätetty");</script>';
                
                $url="harjoitustyo_etusivu.php";
				echo "<html><head><META HTTP-EQUIV=Refresh CONTENT=\"0; URL=" .$url. "\"></head></html>";
        }
        
    }
    
}


?>