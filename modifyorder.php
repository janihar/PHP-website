<?php
session_start();
require_once("db.inc");

if ( isset($_GET["morder"])) {
    
    if (isset($_GET["comment"])) {
        
        $comment=$_GET["comment"];
        $order_id=$_SESSION["orderid"];
        
        $query= "UPDATE `order` SET `desc` = '$comment',order_date= CURRENT_TIMESTAMP WHERE order_id = '$order_id' ";
        
        $result=mysqli_query($conn,$query);
        
        if (!$result) {
            
            
            echo "Kysely epäonnistui " . mysqli_error($conn);
        }
        
        else {
            unset($_SESSION["orderid"]);
            
            echo '<script type="text/javascript">alert("Tilaus on muokattu!");</script>';
            $url ="harjoitustyo_etusivu.php?";
				echo "<html><head><META HTTP-EQUIV=Refresh CONTENT=\"0; URL=" .$url. "\"></head></html>";
        }
        
        
    }
    
}

if ( isset($_GET["save"])) {
    
    if (isset($_GET["statues"]) || isset($_GET["accept"]) || isset($_GET["start"]) || isset($_GET["end"]) || isset($_GET["jobcomments"]) || isset($_GET["hours"]) || isset($_GET["utility"]) || isset($_GET["approx"])) {
        
        $statues=$_GET["statues"];
        $accept=$_GET["accept"];
        $start=$_GET["start"];
        $end=$_GET["end"];
        $jobcomments=$_GET["jobcomments"];
        $hours=$_GET["hours"];
        $utility=$_GET["utility"];
        $approx=$_GET["approx"];
        
        $order_id=$_SESSION["orderid"];
        
        $hours=(double) $hours; //jos tunnit jättää tyhjäksi niin ne on string muuttujia joten double muutos tulee tehdä
        $approx=(double) $approx;
        
        
        if(strcasecmp( $statues, "ALOITETTU" )==0) {
        
        
        $query= "UPDATE `order` SET start_date=CURRENT_TIMESTAMP, end_date=null, comments='$jobcomments', hours='$hours', articles='$utility', cost='$approx', status='$statues' WHERE order_id = '$order_id' ";
        
        $result=mysqli_query($conn,$query);
        
        if (!$result) {
            
            
            echo "Kysely epäonnistui " . mysqli_error($conn);
        }
        
        else {
            unset($_SESSION["orderid"]);
            
            echo '<script type="text/javascript">alert("Tilaus on muokattu!");</script>';
            $url ="hallintatyokalu.php?";
				echo "<html><head><META HTTP-EQUIV=Refresh CONTENT=\"0; URL=" .$url. "\"></head></html>";
        }
        
        
    }
        
        if(strcasecmp( $statues, "VALMIS" )==0) {
        
        
        $query= "UPDATE `order` SET end_date=CURRENT_TIMESTAMP, comments='$jobcomments', hours='$hours', articles='$utility', cost='$approx', status='$statues' WHERE order_id = '$order_id' ";
        
        $result=mysqli_query($conn,$query);
        
        if (!$result) {
            
            
            echo "Kysely epäonnistui " . mysqli_error($conn);
        }
        
        else {
            unset($_SESSION["orderid"]);
            
            echo '<script type="text/javascript">alert("Tilaus on muokattu!");</script>';
            $url ="hallintatyokalu.php?";
				echo "<html><head><META HTTP-EQUIV=Refresh CONTENT=\"0; URL=" .$url. "\"></head></html>";
        }
        
        
    }
        
     else {
         
echo "lasdasd";
     }   
    
}
}

if ( isset($_GET["deny"])) {
    $order_id=$_SESSION["orderid"];
    
    $query="UPDATE `order` SET status='HYLATTY' WHERE order_id='$order_id'";
    
    $result=mysqli_query($conn,$query);
    
    if (!$result) {
        
        echo "Virhe SQL-lauseessa".mysqli_error($conn);
        
    }
    else {
        unset($_SESSION['orderid']);
    echo '<script type="text/javascript">alert("Tilaus on HYLÄTTY!");</script>';
            $url ="hallintatyokalu.php?";
				echo "<html><head><META HTTP-EQUIV=Refresh CONTENT=\"0; URL=" .$url. "\"></head></html>";
    }
    
    
    
    
    
}




?>