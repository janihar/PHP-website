<?php 
session_start();
?>
<html>
<head>
	<title> Kiitos </title>
</head>
<body>


<form action="harjoitustyo_kirjautuminen.php" method="get">
	
	Syötä käyttäjätunnus 
	<input type="text" name="user">
<br>
<br>	
	Syötä salasana &nbsp &nbsp &nbsp &nbsp &nbsp
	<input type="text" name="password">
<br>
<br>	
	<input type="submit" name="sign" value="Kirjaudu"> </td> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 
	 Eikö sinulla ole tunnusta? <a href="harjoitustyo_luokayttis.php"> Luo sellainen </a> <br>
</form>
<?php
require_once("db.inc");

if (isset($_GET["sign"])) {
	
	if (isset($_GET["user"]) && isset($_GET["password"])) {
		
		
		$username=$_GET["user"];
		$username=mysqli_real_escape_string($conn,$username); //vältetään sql-injektio
		$password=$_GET["password"];
		$password=mysqli_real_escape_string($conn,$password); //vältetään sql-injektio
		$_SESSION['login_user']= $username;
		
	
		
		
		
		if (!empty($username) && !empty($password)) {
			$query="SELECT username,password from client WHERE username='$username' and password='$password'";
			
			$result=mysqli_query($conn,$query);
			
			if(mysqli_num_rows($result)===1) { // halutaan että yksi rivi palautetaan. Eli jos käyttäjätunnus ja salasana ovat oikein query lauseessa niin num_rows palauttaa vain yhden rivin.
				if (strcasecmp( $username, "admin" )==0) {
                    
                     $url ='hallintatyokalu.php';
				echo "<html><head><META HTTP-EQUIV=Refresh CONTENT=\"0; URL=" .$url. "\"></head></html>"; // kun käyttäjä saa tunnukset oikein syötettyä siirretään hän etusivulle!
                }
                else {
				  $url ='harjoitustyo_etusivu.php';
				echo "<html><head><META HTTP-EQUIV=Refresh CONTENT=\"0; URL=" .$url. "\"></head></html>"; // kun käyttäjä saa tunnukset oikein syötettyä siirretään hän etusivulle!
                }
				
			}
			
			else {
				
				echo '<script type="text/javascript">alert("Väärä käyttäjätunnus tai salasana!");</script>'; //toteutaan messabox js, jossa käyttäjälle annetaan ilmoitus että salasana tai käyttäjätunnus meni väärin.
				
				
				
			}
		
			
			
			
		}
		
		
		
		
	}
	
	
}



?>

</body>

</html>