<?php
    session_start();
    require_once("db.inc");
  
    if ( isset($_GET["order"])) {
         
       
          
            $comment=$_GET["comment"];
            $username=$_SESSION['login_user'];
        
            
            
            if (empty($comment)) {
                
                echo '<script type="text/javascript">alert("Syötä työnkuvaus! Ei työtä ilman tietoja. Tilaus ei onnistunut!");</script>';
                echo "Tilauksen teko ei onnistunut!";
                $url="harjoitustyo_etusivu.php";
				echo "<html><head><META HTTP-EQUIV=Refresh CONTENT=\"2; URL=" .$url. "\"></head></html>";
                
            }
            
            else {
                $query="INSERT INTO `order` (`order_id`,`desc`,order_date,acc_date,start_date,end_date,comments,hours,articles,cost,status,username) VALUES (null ,'$comment',CURRENT_TIMESTAMP,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'TILATTU','$username')";
                
                if(mysqli_query($conn,$query)) {}
                else {
                    
                    
                    echo "Kysely epäonnistui " . mysqli_error($conn);
                }
                
                $url ='harjoitustyo_etusivu.php';
                echo "Tilaus tehty onnistuneesti!";
				echo "<html><head><META HTTP-EQUIV=Refresh CONTENT=\"2; URL=" .$url. "\"></head></html>";

            }
            
        
        
    }
    
    
    ?>



