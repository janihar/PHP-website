<?php
session_start();


if(isset($_SESSION['login_user']) && !empty($_SESSION['login_user'])) { //jos sessiossa on aktiivinen käyttäjätunnus niin sivu näytetään. Jos sessiossa ei ole tunnusta printataan linkki kirjatumissivulle.


?>

<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {font-family: Arial;}


.tab {
    overflow: hidden;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
}


.tab button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    font-size: 17px;
}


.tab button:hover {
    background-color: #ddd;
}


.tab button.active {
    background-color: #ccc;
}


.tabcontent {
    display: none;
    padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;
}

.tab-right {

	float: right;
}

    .column {
    float: left;
    width: 200%;
    padding: 10px;
}
    .row{
    content: "";
    display: table;
    clear: both;
}
</style>
</head>
<body>


<p> <h1>Hallintatyökalu</h1> <p>

<div class="tab">
  <button class="tablinks" onclick="openTab(event, 'orders')"id="defaultopen">Selaa työtilauksia</button>
  <button class="tablinks" onclick="openTab(event, 'bids')"id="bidsopen">Selaa tarjouspyyntöjä</button> <!-- tämä aukaistaan oletuksena eli omat tilaus osio aukeaa heti onnistuneen sisäänkirjautumisen jälkeen. -->
    <button class="tablinks" onclick="openTab(event, 'clients')">Asiakkaiden hallinta</button>



  <div class="tab-right">
  <button class="tablinks" onclick="openTab(event,'user')"><?php echo $_SESSION['login_user']; ?></button>
  <button class="tablinks" onclick="openTab(event,'logoff')">Kirjaudu ulos</button>

  </div>
</div>

    <div id="orders" class="tabcontent">
        <form action="hallintatyokalu.php" method=get>
  <h3><b> Jätetyt tilaukset </b></h3>
        <tr>
    <td>Syötä Asiakas:</td>
    <td><input type="text" name="customer" /></td>
 </tr>
        <tr>
    <td>Syötä Status:</td>
    <td><input type="text" name="status" /></td>
 </tr>
             <tr>
    <td>Syötä Tilauspvm:</td>
    <td><input type="text" name="orderdate" /></td>
 </tr>
            <tr>
                <td><td>
                <td><input type="checkbox" name="deniedorders" value="denied"> Vain hylätyt tilaukset<td>
            </tr>
        <tr>
    <td></td>
	<td><input type="submit" name="search" value="Hae" /> </td>
  </tr>
        </form>
        <?php
    require_once("db.inc");

    if (isset ($_GET["search"])) {


    if (empty($_GET['customer']) && empty($_GET['status'])&& empty($_GET['orderdate']) && empty($_GET['deniedorders']) )
{
    $sql="select * from `order` where status != 'HYLATTY'";
}
else
{
 $wheres = array();

$sql = "select * from `order` where ";

if (isset($_GET['customer']) and !empty($_GET['customer']))
{
    $wheres[] = "username like '%{$_GET['customer']}%'";
}

if (isset($_GET['status']) and !empty($_GET['status']))
{
    $wheres[] = "status = '{$_GET['status']}'";
}
    if (isset($_GET['orderdate']) and !empty($_GET['orderdate']))
{
        $orderdate=$_GET['orderdate'];
       $orderdate=date("Y-m-d H:i:s",strtotime("$orderdate"));
        $min_value=$orderdate;
        $max_value="2099-12-24";

        echo $orderdate;
    $wheres[] = "order_date between '$min_value' and '$max_value'";
}

    if (isset($_GET['deniedorders']) and !empty($_GET['deniedorders']))
{
        $denied=$_GET['deniedorders'];
        if (strcasecmp($denied,"denied")==0) {
    $wheres[] = "status = 'HYLATTY' ";
        }
}



foreach ( $wheres as $where )
{
$sql .= $where . ' AND ';
  }
 $sql=rtrim($sql, "AND ");

     }





    $result=mysqli_query($conn,$sql);


        if (!$result) {
            echo "Kysely epäonnistui " . mysqli_error($conn);
        }

    else {

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			//haetaan nimi, hinta ja määrä muuttujiin
            $username=$row["username"];
            $order_id=$row["order_id"];
			$desc = $row["desc"];
            $status = $row["status"];
            $order_date=$row["order_date"];
		?>

 <div class="row">
  <div class="column"style="background-color:white;">
      <a href="adminorderidsession.php?varname= <?php echo $order_id ?>"><?php echo $desc ?></a>
      <p>Tilaaja=<?php echo $username ?></p>
      <p>Tila=<?php echo $status ?></p>
      <p>Tilauspvm=<?php echo date("d.m.Y H:i:s",strtotime("$order_date")); ?></p>


  </div>
     </div>

     <?php

		}
    }
    }



    ?>



    </div>

    <div id="user" class="tabcontent">
  <?php

  require_once("db.inc");

  $username=$_SESSION['login_user']; //otetaan sessiosta tallennettu käyttäjätunnus

  $query="SELECT * FROM client where username='$username'"; //haetaan tiedot siltä käyttäjältä jolla kirjauduttiin sisään.

  $result=mysqli_query($conn,$query);

  if ( !$result ) {
	  echo "Kysely epäonnistui " . mysqli_error($conn);

  }


  else {

	  $row=mysqli_fetch_array($result);

	  $postcode= $row["postcode"];




			?>






  <table>
<form action="harjoitustyo_hallintatyokalu.php" method="get">
  <tr>
    <td> <b> Vaihda Salasana: </b></td>
    <td></td>
  </tr>
  <tr>
    <td>Salasana:</td>
    <td><input type="text" name="password"/></td>
  </tr>
    <tr>
    <td>Syötä salasana uudelleen:</td>
    <td><input type="text" name="password1" /></td>
 </tr>
 <tr>
    <td></td>
	<td><input type="submit" name="change" value="Vaihda" /> </td>
  </tr>

 <tr>
    <td></td>
    <td></td>
  </tr>
   <tr>
    <td></td>
    <td></td>
  </tr>
   <tr>
    <td></td>
    <td></td>
  </tr>
   <tr>
    <td></td>
    <td></td>
  </tr>
   <tr>
    <td></td>
    <td></td>
  </tr>
   <tr>
    <td> <b> Henkilötiedot: </b></td>
    <td></td>
  </tr>
    <tr>
    <td>Nimi:</td>
    <td><input type="text" name="name" value="<?php echo $name=$row["name"]; ?>"/></td>
  </tr>
  <tr>
    <td>Syntymäaika:</td>
    <td>
  <input type="date" name="dob"></td>
  </tr>
    <tr>
    <td>Puhelinnumero:</td>
    <td><input type="number" name="phone" value="<?php echo $phone=$row["phone"]; ?>"/></td>
 <tr>
   <tr>
    <td>Osoite:</td>
    <td><input type="text" name="address" value="<?php echo $address=$row["address"]; ?>"/></td>
  </tr>
  <tr>
    <td>Postinumero:</td>
    <td><input type="number" name="postcode" value="<?php echo $postcode; ?>"/></td>
  </tr>
    <tr>
    <td>Kunta:</td>
	<td><input type="text" name="council" value="<?php echo $council=$row["council"]; ?>"/></td>
 </tr>
    <tr>
    <td></td>
    <td></td>
  </tr>
     <tr>
    <td></td>
    <td></td>
  </tr>
     <tr>
    <td></td>
    <td></td>
  </tr>
    <tr>
    <td></td>
	<td><input type="submit" name="save" value="Tallenna" /> </td>
  </tr>
   <tr>
    <td></td>
    <td></td>
  </tr>
    <tr>
    <td></td>
    <td></td>
  </tr>
   </form>


  <?php
  }
  ?>

  <?php

  require_once("db.inc");

  if ( isset($_GET["save"])) {

  if ( isset($_GET["name"]) && isset($_GET["dob"]) && isset($_GET["phone"]) && isset($_GET["address"]) && isset($_GET["postcode"]) && isset($_GET["council"])) {

		$username=$_SESSION['login_user'];
		$name=$_GET["name"];
		$dob=$_GET["dob"];
		$phone=$_GET["phone"];
		$address=$_GET["address"];
		$postcode=$_GET["postcode"];
		$council=$_GET["council"];

		$query="UPDATE client SET name='$name',dob='$dob',phone='$phone',address='$address',postcode='$postcode',council='$council' WHERE username='$username'"; //etsitään sähköposteja, sillä ei voi olla samoja sähköposteja

			if ( mysqli_query($conn,$query)) {


				echo '<script type="text/javascript">alert("Tietojen päivitys onnistui!!");</script>';


			}

			else {



				echo '<script type="text/javascript">alert("Virhe tietojen syötössä!");</script>';

			}



  }


  }


  if ( isset($_GET["change"])) {

	  if ( isset($_GET["password"]) &&  isset($_GET["password1"] )) {

		$password=$_GET["password"];
		$password1=$_GET["password1"];



	}

	if (strcasecmp( $password, $password1 )==0) { // Salasanat täsmäävät!

	$query="UPDATE client SET password='$password' WHERE username='$username'";

	mysqli_query($conn,$query);

	echo '<script type="text/javascript">alert("Salasana vaihdettu!");</script>';

	}

	else {

		echo '<script type="text/javascript">alert("Salasanat eivät täsmää!");</script>';

	}




  }
  ?>
        </table>
      </div>

<div id="logoff" class="tabcontent">
 <a href="logout.php"> Kirjaudu ulos</a>
</div>

    <div id="orderspecs" class="tabcontent">

        <?php

    require_once("db.inc");

    $order_id=$_SESSION['orderid'];

    $query="SELECT * FROM `order` WHERE order_id = '$order_id'";

    $result=mysqli_query($conn,$query);

    if (!$result) {

        echo "Kysely epäonnistui " . mysqli_error($conn);
    }

    else {

        while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)) {

            ?>



    <table>
        <tr>
    <td>Tilaaja:</td>
      <td><input type="text" name="accept"  disabled value="<?php echo $username=$row["username"]; ?>"</td>
  </tr>

  <tr>
    <td>Asiakkaan antama työkuvaus:</td>
      <td><textarea rows="4" cols="50" name="comment" disabled><?php echo $desc=$row["desc"]; ?></textarea></td>
  </tr>
       <tr>
    <td>Tilauspäivämäärä:</td>
    <td>
  <input type="text" name="accept" value="<?php  $order_date=$row["order_date"]; echo date("d.m.Y H:i:s",strtotime("$order_date")); ?>" disabled ></td>
               </tr>
    <form action="modifyorder.php" method="get">
    <tr>
    <td></td>
    <td></td>
 </tr>
    <tr>
    <td></td>
    <td></td>
 </tr>
    <tr>
    <td></td>
    <td></td>
 </tr>
    <tr>
    <td></td>
    <td></td>
 </tr>
    <tr>
        <td><p><b><h3>Tilauksen tiedot</h3></b></p></td>
    <td></td>
 </tr>
    <tr>
    <td>Tilauksen tila:</td>
    <td>
  <select name="statues" <?php if (strcasecmp($status=$row["status"],'HYLATTY')==0) {echo "disabled"; } ?> >
  <option value="<?php echo $status=$row["status"];?>" selected="selected" ><?php echo $status=$row["status"]; ?></option>
  <option value="ALOITETTU">ALOITETTU</option>
  <option value="VALMIS">VALMIS</option>

</select>
        </td>

    </tr>
 <tr>
    <td>Hyväksymispäivämäärä:</td>
    <td>
  <input type="text" name="accept" value="<?php if (empty($acc_date=$row["acc_date"])) {echo "Kesken";} else { $acc_date=$row["acc_date"]; echo date("d.m.Y H:i:s",strtotime("$acc_date"));  } ?>" <?php if (strcasecmp($status=$row["status"],'HYLATTY')==0) {echo "disabled"; } ?>></td>
               </tr>
  <tr>
    <td>Aloituspäivämäärä:</td>
    <td>
  <input type="text" name="start" value="<?php if (empty($start_date=$row["start_date"])) {echo "Kesken";} else {  $start_date=$row["start_date"]; echo date("d.m.Y H:i:s",strtotime("$start_date"));    } ?>" <?php if (strcasecmp($status=$row["status"],'HYLATTY')==0) {echo "disabled"; } ?> ></td>
               </tr>
 <tr>
    <td>Loppumispäivämäärä:</td>
    <td>
  <input type="text" name="end"  value="<?php if (empty($end_date=$row["end_date"])) {echo "Kesken";} else {  $end_date=$row["end_date"]; echo date("d.m.Y H:i:s",strtotime("$end_date")); } ?>" <?php if (strcasecmp($status=$row["status"],'HYLATTY')==0) {echo "disabled"; } ?>></td>
  </tr>
 <tr>
    <td>Kommentit tehdystä työstä:</td>
      <td><textarea rows="4" cols="50" name="jobcomments" <?php if (strcasecmp($status=$row["status"],'HYLATTY')==0) {echo "disabled"; } ?> ><?php echo $comments=$row["comments"]; ?></textarea></td>
  </tr>
    <tr>
    <td>Käytetty tuntimäärä:</td>
    <td><input type="number" name="hours" value="<?php echo $hours=$row["hours"]; ?>" <?php if (strcasecmp($status=$row["status"],'HYLATTY')==0) {echo "disabled"; } ?> /></td>
  </tr>
    <tr>
    <td>Tarvittavat/kuluneet tarvikkeet:</td>
      <td><textarea rows="4" cols="50" name="utility" <?php if (strcasecmp($status=$row["status"],'HYLATTY')==0) {echo "disabled"; } ?>><?php echo $articles=$row["articles"]; ?></textarea></td>
  </tr>
    <tr>
    <td>Arvio kustannuksista:</td>
    <td><input type="number" name="approx" value="<?php echo $cost=$row["cost"]; ?>" <?php if (strcasecmp($status=$row["status"],'HYLATTY')==0) {echo "disabled"; } ?> /></td>
  </tr>
           <tr>
    <td></td>
	<td><input type="submit" name="save" value="Tallenna muutokset" <?php if (strcasecmp($status=$row["status"],'HYLATTY')==0) {echo "disabled"; } ?>/> </td>
        </tr>
        <tr>
    <td></td>
	<td><input type="submit" name="deny" value="Hylkää tilaus" <?php if (strcasecmp($status=$row["status"],'HYLATTY')==0) {echo "disabled"; } ?> /> </td>

  </tr>


        </form>


 <tr>
    <td></td>
	<td><input type="submit" name="order" value="Takaisin" onclick="javascript:openTab(event, 'orders');" /> </td>

  </tr>

    </table>

        <?php

                }
    }
            ?>


</div>

<div id="bids" class="tabcontent">



    <form action="hallintatyokalu.php" method=get>
  <h3><b> Jätetyt tarjouspyynnöt </b></h3>
        <tr>
    <td>Syötä Asiakas:</td>
    <td><input type="text" name="customer" /></td>
 </tr>
        <tr>
    <td>Syötä Status:</td>
    <td><input type="text" name="status" /></td>
 </tr>
             <tr>
    <td>Syötä Jättöpvm:</td>
    <td><input type="text" name="leftdate" /></td>
 </tr>

        <tr>
    <td></td>
	<td><input type="submit" name="bidssearch" value="Hae" onclick="myClick();"/> </td>
  </tr>
    </form>
        <?php
    require_once("db.inc");
   if (isset ($_GET["bidssearch"])) {
    if (empty($_GET['customer']) && empty($_GET['status'])&& empty($_GET['leftdate']))
{
    $sql="select * from `bids`";
}
else
{
 $wheres = array();

$sql = "select * from `bids` where ";

if (isset($_GET['customer']) and !empty($_GET['customer']))
{
    $wheres[] = "username like '%{$_GET['customer']}%' ";
}

if (isset($_GET['status']) and !empty($_GET['status']))
{
    $wheres[] = "status = '{$_GET['status']}'";
}
    if (isset($_GET['leftdate']) and !empty($_GET['leftdate']))
{
        $orderdate=$_GET['leftdate'];
       $orderdate=date("Y-m-d H:i:s",strtotime("$orderdate"));
        $min_value=$orderdate;
        $max_value="2099-12-24";


    $wheres[] = "left_date between '$min_value' and '$max_value'";
}




foreach ( $wheres as $where )
{
$sql .= $where . ' AND ';
  }
 $sql=rtrim($sql, "AND ");

     }





    $result=mysqli_query($conn,$sql);


        if (!$result) {
            echo "Kysely epäonnistui " . mysqli_error($conn);
        }

    else {

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			//haetaan nimi, hinta ja määrä muuttujiin
            $username=$row["username"];
            $bids_id=$row["bids_id"];
			$details = $row["details"];
            $status = $row["status"];
            $left_date=$row["left_date"];
		?>

 <div class="row">
  <div class="column"style="background-color:white;">
      <a href="adminbidsidsession.php?varname= <?php echo $bids_id ?>"><?php echo $details ?></a>
      <p>Tilaaja=<?php echo $username ?></p>
      <p>Tila=<?php echo $status ?></p>
      <p>Tilauspvm=<?php echo date("d.m.Y H:i:s",strtotime("$left_date")); ?></p>


  </div>
     </div>

     <?php

		}
    }
   }




    ?>

</div>

        <div id="bidsspecs" class="tabcontent">

        <?php

    require_once("db.inc");

    $bids_id=$_SESSION['bidsid'];

    $query="SELECT * FROM `bids` WHERE bids_id = '$bids_id'";

    $result=mysqli_query($conn,$query);

    if (!$result) {

        echo "Kysely epäonnistui " . mysqli_error($conn);
    }

    else {

        while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)) {

            ?>



    <table>
        <tr>
    <td>Tilaaja:</td>
      <td><input type="text" name="accept"  disabled value="<?php echo $username=$row["username"]; ?>"</td>
  </tr>

  <tr>
    <td>Asiakkaan antama tarjouspyyntö:</td>
      <td><textarea rows="4" cols="50" name="comment" disabled><?php echo $details=$row["details"]; ?></textarea></td>
  </tr>
       <tr>
    <td>Tilauspäivämäärä:</td>
    <td>
  <input type="text" name="accept" value="<?php  $left_date=$row["left_date"]; echo date("d.m.Y H:i:s",strtotime("$left_date")); ?>" disabled ></td>
               </tr>

    <tr>
    <td></td>
    <td></td>
 </tr>
    <tr>
    <td></td>
    <td></td>
 </tr>
    <tr>
    <td></td>
    <td></td>
 </tr>
    <tr>
    <td></td>
    <td></td>
 </tr>
    <tr>
        <td><p><b><h3>Tilauksen tiedot</h3></b></p></td>
    <td></td>
         <form action="modifybids.php" method="get">
 </tr>
    <tr>
    <td>Tilauksen tila:</td>
    <td><input type="text" name="status" value="<?php echo $status=$row["status"]; ?>" disabled </td>

    </tr>
 <tr>
    <td>Vastauspäivämäärä:</td>
    <td>
  <input type="text" name="accept" value="<?php if (empty($acc_date=$row["answer_date"])) {echo "Kesken";} else { $acc_date=$row["answer_date"]; echo date("d.m.Y H:i:s",strtotime("$acc_date"));  } ?>" disabled ></td>
               </tr>

    <tr>
    <td>Arvio kustannuksista:</td>
    <td><input type="number" name="approx" value="<?php echo $cost=$row["cost"]; ?>" <?php if (strcasecmp($status=$row["status"],'HYLATTY')==0) {echo "disabled"; } ?> /></td>
  </tr>
           <tr>
    <td></td>
	<td><input type="submit" name="bsave" value="Tallenna muutokset"> </td>
        </tr>
        <tr>
    <td></td>
	<td><input type="submit" name="bdeny" value="Hylkää tilaus" <?php if (strcasecmp($status=$row["status"],'HYLATTY')==0) {echo "disabled"; } ?> /> </td>

  </tr>


        </form>


 <tr>
    <td></td>
	<td><input type="submit" name="order" value="Takaisin" onclick="javascript:openTab(event, 'bids');" /> </td>

  </tr>

    </table>

        <?php

                }
    }
            ?>


</div>

    <div id="clients" class="tabcontent">
        <?php

        $query= "SELECT * FROM `client`";
        $result=mysqli_query($conn,$query);


        if (!$result) {
            echo "Kysely epäonnistui " . mysqli_error($conn);
        }

    else {

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			//haetaan nimi, hinta ja määrä muuttujiin
            $username=$row["username"];
            $password=$row["password"];

		?>

 <div class="row">
  <div class="column"style="background-color:white;">
      <a href="adminmodifyuser.php?varname=<?php echo $username ?>"><?php echo $username ?></a>
      <p>Tilaaja=<?php echo $username ?></p>
      <p>Salasana=<?php echo $password ?></p>


  </div>
     </div>


        <?php
        }
    }
            ?>
    </div>

    <div id="userspecs" class="tabcontent">
        <?php
    $username=$_SESSION["user"];
        $query= "SELECT * FROM `client` where username='$username'";
        $result=mysqli_query($conn,$query);


        if (!$result) {
            echo "Kysely epäonnistui " . mysqli_error($conn);
        }

    else {

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) { 
			//haetaan nimi, hinta ja määrä muuttujiin


		?>
    <table>
        <h3>Käyttäjätunnus:</h3>
        <form action="hallintatyokalu.php" method="get">
<tr>

        <td>Käyttäjätunnus: </td>
        <td><input type="text" name="clientusername" disabled value="<?php echo $clientuser=$row["username"]; ?>"</td>
        </tr>
        <tr>
        <td>Salasana: </td>
        <td><input type="text" name="clientpassword"value="<?php echo $clientpassword=$row["password"]; ?>"</td>
        </tr>
            <tr>
        <td></td>
        <td><input type="submit" name="saveuser"value="Tallenna muutokset"</td>
        </tr>



        <?php
        }
    }
            ?>
        </form>
        </table>

        <?php
    require_once("db.inc");

    if ( isset($_GET["saveuser"])) {

        if ( isset($_GET["clientpassword"])) {

            $password=$_GET["clientpassword"];

            $username=$_SESSION['user'];

            $query="UPDATE `client` SET password='$password' WHERE username='$username'";

            $result=mysqli_query($conn,$query);

            if ( !$result) {



                echo "<script type='text/javascript'>alert('virhe');</script>";




            }

            else {
                  echo "<script type='text/javascript'>alert('Salasanan vaihto onnistui');</script>";
                    unset ($_SESSION['user']);


            }

        }
    }

    ?>

    </div>



<script>

    document.getElementById("defaultopen").click();


    <?php

    //Kun sessio on luotu kutsutaan specs osiota, jossa nähdään työtilauksen tarkemmat tiedot
    if (!isset($_SESSION["search"])) {

    if (!empty($_SESSION['orderid'])) {
        //unset($_SESSION['orderid']);

        ?>
    openTab(event, 'orderspecs');

      <?php

    }
    }

    if (!isset($_GET["bidssearch"])) {

    if (!empty($_SESSION['bidsid'])) {
        //unset($_SESSION['bidsid']);

        ?>
    openTab(event, 'bidsspecs');


      <?php

    }
    }
    if(!isset($_GET["saveuser"])){
    if (!empty($_SESSION['user'])) {

        //unset ($_SESSION['user']);
        ?>
    openTab(event, 'userspecs');


      <?php

    }
    }









    ?>

function openTab(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}
</script>

</body>
</html>

<?php

               }


    //tämä sulku liittyy ensimmäisen rivin iffiin.

else {

    echo"<a href=harjoitustyo_kirjautuminen.php>OLE HYVÄ JA KIRJAUDU SISÄÄN </a>";
}

?>
</body>

</html>
