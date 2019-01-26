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


<p> Reiskan vuokrausfirma <p>

<div class="tab">
  <button class="tablinks" onclick="openTab(event, 'order')">Tee tilaus</button>
  <button class="tablinks" onclick="openTab(event, 'ownorder')" id="defaultopen">Omat tilaukset</button> <!-- tämä aukaistaan oletuksena eli omat tilaus osio aukeaa heti onnistuneen sisäänkirjautumisen jälkeen. -->
    <button class="tablinks" onclick="openTab(event, 'bids')">Tee tarjouspyyntö</button>
    <button class="tablinks" onclick="openTab(event, 'ownbids')">Omat tarjouspyynnöt</button>



  <div class="tab-right">
  <button class="tablinks" onclick="openTab(event,'user')"><?php echo $_SESSION['login_user']; ?></button>
  <button class="tablinks" onclick="openTab(event,'logoff')">Kirjaudu ulos</button>

  </div>
</div>

<div id="order" class="tabcontent">
  <h3>Tilauksen tekeminen</h3>

    <table>
<form action="tilauksen_tallennus.php" method="get">

  <tr>
    <td>Syötä vaatimasi työnkuvaus:</td>
      <td><textarea rows="4" cols="50" name="comment"></textarea></td>
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
        <td><p><b><h3>Toimittaja täyttää</h3></b></p></td>
    <td></td>
 </tr>
 <tr>
    <td>Hyväksymispäivämäärä:</td>
    <td>
  <input type="date" name="accept" disabled></td>
     <tr>
  <tr>
    <td>Aloituspäivämäärä:</td>
    <td>
  <input type="date" name="start" disabled></td>
      <tr>
 <tr>
    <td>Loppumispäivämäärä:</td>
    <td>
  <input type="date" name="end" disabled></td>
  </tr>
 <tr>
    <td>Kommentit tehdystä työstä:</td>
      <td><textarea rows="4" cols="50" name="jobcomments" form="usrform" disabled></textarea></td>
  </tr>
    <tr>
    <td>Käytetty tuntimäärä:</td>
    <td><input type="number" name="hours" disabled /></td>
  </tr>
    <tr>
    <td>Tarvittavat/kuluneet tarvikkeet:</td>
      <td><textarea rows="4" cols="50" name="utility" form="usrform" disabled></textarea></td>
  </tr>
    <tr>
    <td>Arvio kustannuksista:</td>
    <td><input type="number" name="approx" disabled /></td>
  </tr>
 <tr>
    <td></td>
	<td><input type="submit" name="order" value="Tee tilaus" /> </td>
  </tr>
    </table>
    </form>
</div>


 <!--
id="ownorder" hoitaa sen osion, missä tilaaja painaa omat tilaukset. Haetaan tilauksen desc, eli sen mitä käyttäjä on tilannut omin sanoin. Kun tekstiä klikkaa aukeaa koko sivu tarkempineen tietoineen. Myös tila on luettelossa, eli näkee mitä tilausta firma on käsitellyt.


-->


<div id="ownorder" class="tabcontent">
  <h3><b> Omat tilaukset </b></h3>
    <?php
    require_once("db.inc");
    $username=$_SESSION['login_user'];
    $query="SELECT * FROM `order` WHERE username ='$username'";

    $result=mysqli_query($conn,$query);
    //mysqli_num_rows($result)

        if (!$result) {
            echo "Kysely epäonnistui " . mysqli_error($conn);
        }

    if(mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
			//haetaan nimi, hinta ja määrä muuttujiin
            $order_id=$row["order_id"];
			$desc = $row["desc"];
            $status = $row["status"];
		?>

 <div class="row">
  <div class="column"style="background-color:white;">
      <a href="orderidsession.php?varname= <?php echo $order_id ?>"><?php echo $desc ?></a>
      <p>Tila=<?php echo $status ?></p>

  </div>
     </div>

     <?php

		}
    }

    ?>
    </div>
<!--
tilaaja painaa nappia kirjaudu ulos! Käyttäjältä vielä varmistetaan, että haluaako käyttäjä kirjautua ulos. Sen jälkeen aukeaa uusi php-sivu, jossa sessio tapetaan. Tämän jälkeen heitetään kirjautumissivustolle.
-->
<div id="logoff" class="tabcontent">
 <a href="logout.php"> Kirjaudu ulos</a>
</div>
<div id="ownbids" class="tabcontent">
 <p><h3>Omat tarjouspyynnöt</h3></p>
    <?php
    require_once("db.inc");
    $username=$_SESSION['login_user'];
    $query="SELECT * FROM `bids` WHERE username ='$username'";

    $result=mysqli_query($conn,$query);


        if (!$result) {
            echo "Kysely epäonnistui " . mysqli_error($conn);
        }

      if(mysqli_num_rows($result) != 0) {

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

            $bids_id=$row["bids_id"];
			$details = $row["details"];
            $status = $row["status"];
		?>

 <div class="row">
  <div class="column"style="background-color:white;">
      <a href="bidsidsession.php?varname= <?php echo $bids_id ?>"><?php echo $details ?></a>
      <p>Tila=<?php echo $status ?></p>

  </div>
     </div>

     <?php

		}
    }

    ?>

</div>
    <div id="bidspecs" class="tabcontent">

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
<form action="modifybids.php" method="get">
  <tr>
    <td>Antamasi työkuvaus:</td>
      <td><textarea rows="4" cols="50" name="details" <?php $status=$row["status"];

            if(!strcasecmp( $status, "JÄTETTY" )==0) { echo"disabled";}?>><?php echo $details=$row["details"]; ?></textarea></td>
  </tr>


        <?php
            /*
            Jos status on JÄTETTU niin käyttäjä voi muokata tilauksen tietoja.

            */

            $status=$row["status"];

            if(strcasecmp( $status, "JÄTETTY" )==0) { //jos status vastaa tilattua niin tee muutokset nappi on ilmestynyt!
                ?>

           <tr>
    <td></td>
	<td><input type="submit" name="mbids" value="Tee Muutokset" /> </td>
    </tr>
                <?php
            }

            ?>

        </form>
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
        <form action="removeoracceptbids.php" method="get">
        <td><p><b><h3>Tarjouspyynnön tiedot</h3></b></p></td>
    <td></td>
 </tr>
    <tr>
    <td>Tilauksen tila:</td>
    <td>
  <input type="text" name="status" value="<?php echo $status=$row["status"]; ?>" disabled></td>
    </tr>
 <tr>
    <td>Vastaamispäivämäärä:</td>
    <td>
  <input type="text" name="answer_date" value="<?php if (empty($answer_date=$row["answer_date"])) {echo "Kesken";} else { $answer_date=$row["answer_date"]; echo date("d.m.Y H:i:s",strtotime("$answer_date")); } ?>" disabled></td>
               </tr>
    <tr>
    <td>Arvio kustannuksista:</td>
    <td><input type="number" name="approx" value="<?php echo $cost=$row["cost"];?>" disabled /></td>
  </tr>


            <?php
            if (!empty($cost=$row["cost"])) {
                ?>
        <tr>
    <td></td>
    <td><input type="submit" name="abids" value="Hyväksy tarjouspyyntö" /></td>
  </tr>

        <?php

            }

            if(strcasecmp( $status, "JÄTETTY" )==0) {
            ?>
                           <tr>
    <td></td>
	<td><input type="submit" name="rbids" value="Poista tarjouspyyntö" /> </td>
    </tr>
                          <tr>
                              <?php
            }
        }
    }

            ?>
                              </form>

                          <tr>
    <td></td>
	<td><input type="submit" name="back" value="Takaisin" onclick="javascript:openTab(event, 'ownbids');" /> </td>
    </tr>


        </table>
</div>
<div id="bids" class="tabcontent">
 <table>
<form action="tarjouksen_tallennus.php" method="get">

    <tr>
        <td><p><b><h3>Tee tarjouspyyntö</h3></b></p></td>
    <td></td>
 </tr>
  <tr>
    <td>Kuvaile vaatimasi työ:</td>
      <td><textarea rows="4" cols="50" name="comment"></textarea></td>
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
        <td><p><b><h3>Toimittaja täyttää</h3></b></p></td>
    <td></td>
 </tr>
 <tr>
    <td>Vastaamispäivämäärä:</td>
    <td>
  <input type="date" name="accept" disabled></td>
     <tr>
  <tr>
    <td></td>
    <td>
  </td>
      <tr>

    <tr>
    <td>Arvio kustannuksista:</td>
    <td><input type="number" name="approx" disabled /></td>
  </tr>
 <tr>
    <td></td>
	<td><input type="submit" name="makebid" value="Jätä tarjouspyyntö" /> </td>
  </tr>
    </table>
    </form>
</div>

    <div id="specs" class="tabcontent">

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
<form action="modifyorder.php" method="get">
  <tr>
    <td>Antamasi työkuvaus:</td>
      <td><textarea rows="4" cols="50" name="comment" <?php if (strcasecmp($status=$row["status"],'HYLATTY')==0) {echo "disabled"; } ?> <?php $status=$row["status"];

            if(!strcasecmp( $status, "TILATTU" )==0) { echo"disabled";}?>><?php echo $desc=$row["desc"]; ?></textarea></td>
  </tr>

    <td>Tilauspäivämäärä:</td>
    <td>
  <input type="text" name="accept" value="<?php $order_date=$row["order_date"];
            echo date("d.m.Y H:i:s",strtotime("$order_date")) ?>" disabled></td>
               </tr>
        <?php
            /*
            Jos status on tilattu niin käyttäjä voi muokata tilauksen tietoja.

            */

            $status=$row["status"];

            if(strcasecmp( $status, "TILATTU" )==0) { //jos status vastaa tilattua niin tee muutokset nappi on ilmestynyt!
                ?>

           <tr>
    <td></td>
	<td><input type="submit" name="morder" value="Tee Muutokset" /> </td>
    </tr>
                <?php
            }

            ?>

        </form>
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
  <input type="text" name="order_status" value="<?php echo $status=$row["status"]; ?>" disabled></td>
    </tr>
 <tr>
    <td>Hyväksymispäivämäärä:</td>
    <td>
  <input type="text" name="accept" value="<?php if (empty($acc_date=$row["acc_date"])) {echo "Kesken";} else { $acc_date=$row["acc_date"]; echo date("d.m.Y H:i:s",strtotime("$acc_date"));  } ?>" disabled></td>
               </tr>
  <tr>
    <td>Aloituspäivämäärä:</td>
    <td>
  <input type="text" name="start" value="<?php if (empty($start_date=$row["start_date"])) {echo "Kesken";} else {  $start_date=$row["start_date"]; echo date("d.m.Y H:i:s",strtotime("$start_date")); } ?>" disabled></td>
               </tr>
 <tr>
    <td>Loppumispäivämäärä:</td>
    <td>
  <input type="text" name="end"  value="<?php if (empty($end_date=$row["end_date"])) {echo "Kesken";} else { $end_date=$row["end_date"]; echo date("d.m.Y H:i:s",strtotime("$end_date"));  } ?>" disabled></td>
  </tr>
 <tr>
    <td>Kommentit tehdystä työstä:</td>
      <td><textarea rows="4" cols="50" name="jobcomments" disabled><?php echo $comments=$row["comments"]; ?></textarea></td>
  </tr>
    <tr>
    <td>Käytetty tuntimäärä:</td>
    <td><input type="number" name="hours" value="<?php echo $hours=$row["hours"]; ?>" disabled /></td>
  </tr>
    <tr>
    <td>Tarvittavat/kuluneet tarvikkeet:</td>
      <td><textarea rows="4" cols="50" name="utility"disabled><?php echo $articles=$row["articles"]; ?></textarea></td>
  </tr>
    <tr>
    <td>Arvio kustannuksista:</td>
    <td><input type="number" name="approx" value="<?php echo $cost=$row["cost"]; ?>" disabled /></td>
  </tr>
     <?php

            /*

            Jos status on tilattu niin poista nappi ilmestyy muuten poistamisnappia ei ole. On vain takaisin nappula jos tilaus on muu kuin tilattu!

            */

        $status=$row["status"];

            if(strcasecmp( $status, "TILATTU" )==0) {
                ?>
        <tr>
    <td></td>
	<td><input type="submit" name="order" value="Poista tilaus" onclick="window.location.href='removeorder.php'" /> </td>

  </tr>
        <?php
            }
        ?>

 <tr>
    <td></td>
	<td><input type="submit" name="order" value="Takaisin" onclick="javascript:openTab(event, 'ownorder');" /> </td>

  </tr>

    </table>

        <?php

                }
    }
            ?>

</div>
    <!--
käyttäjä painaa omaa nimeänsä(id=user). Tässä osiossa käyttäjä pystyy muokkaamaan omia tietojaan.
-->
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
<form action="harjoitustyo_etusivu.php" method="get">
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

<script>

    document.getElementById("defaultopen").click();

    <?php
    //Kun sessio on luotu kutsutaan specs osiota, jossa nähdään työtilauksen tarkemmat tiedot
    if (!empty($_SESSION['orderid'])) {
        ?>
    openTab(event, 'specs');

      <?php

    }

    if (!empty($_SESSION['bidsid'])) {
        ?>
    openTab(event, 'bidspecs');
      <?php

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
