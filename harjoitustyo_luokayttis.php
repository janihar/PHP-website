<html>
<head>
	<title> Luo käyttäjätunnus </title>
</head>
<body>

<table>
<form action="harjoitustyo_luokayttis.php" method="get">
  <tr>
    <td>Käyttäjätunnus:</td>
    <td><input type="text" name="username" value="<?php if (isset($_GET["username"])) echo $_GET["username"]; ?>" /></td>
  </tr>
  <tr>
    <td>Salasana:</td>
    <td><input type="text" name="password"   /></td>
  </tr>
    <tr>
    <td>Syötä salasana uudelleen:</td>
    <td><input type="text" name="password1" /></td>
 <tr>
     <tr>
    <td>Sähköposti:</td>
    <td><input type="text" name="email" value="<?php if (isset($_GET["email"])) echo $_GET["email"]; ?>" /></td>
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
    <td><input type="text" name="name" value="<?php if (isset($_GET["name"])) echo $_GET["name"]; ?>"  /></td>
  </tr>
  <tr>
    <td>Syntymäaika:</td>
    <td>
  <input type="date" name="dob"></td>
  </tr>
    <tr>
    <td>Puhelinnumero:</td>
    <td><input type="number" name="phone" value="<?php if (isset($_GET["phone"])) echo $_GET["phone"]; ?>"  /></td>
 <tr>
   <tr>
    <td>Osoite:</td>
    <td><input type="text" name="address" value="<?php if (isset($_GET["address"])) echo $_GET["address"]; ?>"  /></td>
  </tr>
  <tr>
    <td>Postinumero:</td>
    <td><input type="number" name="postcode" value="<?php if (isset($_GET["postcode"])) echo $_GET["postcode"]; ?>"  /></td>
  </tr>
    <tr>
    <td>Kunta:</td>
    <td><input type="text" name="council" value="<?php if (isset($_GET["council"])) echo $_GET["council"]; ?>"  /></td>
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
	<td><input type="submit" name="add" value="Luo tunnus" /> </td>
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
	<td> </td>
    <td> <input type="submit" name="back" value="Takaisin" /> </td>
  </tr>
   </form>

<?php
require_once("db.inc"); //databasen tiedot ja yhteysosoite.

if (isset($_GET["add"])) { // jos käyttäjä painaa luo nappia. Sivulle on myös takaisin nappi, jos käyttäjä haluaa palata.

	if ( isset($_GET["password"]) &&  isset($_GET["password1"] )) {

		$password=$_GET["password"];
		$password1=$_GET["password1"];



	}


		if (strcasecmp( $password, $password1 )==0) { // jos salasanat eivät täsmää näytetään käyttäjälle js-alert, joka kertoo että salasanat eivät täsmää



		if ( isset($_GET["username"]) && isset($_GET["password"]) && isset($_GET["email"]) && isset($_GET["name"]) && isset($_GET["dob"]) && isset($_GET["phone"]) && isset($_GET["address"]) && isset($_GET["postcode"]) && isset($_GET["council"])) {

		$username=$_GET["username"];
		$password=$_GET["password"];
		$email=$_GET["email"];
		$name=$_GET["name"];
		$dob=$_GET["dob"];
		$phone=$_GET["phone"];
		$address=$_GET["address"];
		$postcode=$_GET["postcode"];
		$council=$_GET["council"];

		$query="SELECT email from client where email='$email'"; //etsitään sähköposteja, sillä ei voi olla samoja sähköposteja

			$result=mysqli_query($conn,$query);

			if(mysqli_num_rows($result)!=0) { //sähköposti on uniikki, joten ei sallita samaa s-postia tietokannassa.

				  echo '<script type="text/javascript">alert("Sähköposti on jo olemassa");</script>';


			}

			else {

				$query="INSERT INTO client(username,password,email,name,dob,phone,address,postcode,council) VALUES ('$username','$password','$email','$name','$dob','$phone','$address','$postcode','$council')";

				if (mysqli_query($conn,$query)) {

				echo '<script type="text/javascript">alert("Tunnuksesi on luotu!");</script>'; // onnistunut luonti ilmoitetaan käyttäjälle

				 $url ='harjoitustyo_kirjautuminen.php';
				echo "<html><head><META HTTP-EQUIV=Refresh CONTENT=\"0; URL=" .$url. "\"></head></html>";
				}

				else {


					echo '<script type="text/javascript">alert("Syötä kaikki kentät!");</script>';

				}



			}






	}
		}

		else {

			echo '<script type="text/javascript">alert("Salasanat eivät täsmää!");</script>'; //salasanat eivät täsmänneet


		}




}

else if (isset($_GET["back"])) {
	$url ='harjoitustyo_kirjautuminen.php';
				echo "<html><head><META HTTP-EQUIV=Refresh CONTENT=\"0; URL=" .$url. "\"></head></html>";

}



?>

</body>

</html>
