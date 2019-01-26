<?php
	// tietokannan nimi
	define("DB_NAME", "harjoitustyojanih");
	// k�ytt�j�tunnus, jolla otetaan yhteys tietokantaan. HUOM! root:n tunnusta EI saa koskaan k�ytt�� tuotantosovelluksessa (eik� oikeastaan miss��n muussakaan)
	define("DB_USER", "root");
	// Salasana
	define("DB_PASSWD", "");
	// Tietokantapalvelimen osoite
	define("DB_HOST", "localhost");
	// Otetaan yhteys tietokantapalvelimelle
	$conn = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWD);

	if ( mysqli_connect_errno() )
	{
		// Lopettaa t�m�n skriptin suorituksen ja tulostaa parametrina tulleen tekstin
		die ("Tietokantapalvelinta ei l�ydy, syy: " . mysqli_connect_error());
	}

	// valitaan tietokanta -> Ei v�ltt�m�t�nt�, jos kanta annettu mysqli_connect:ssa
	mysqli_select_db($conn, DB_NAME) or die ("Tietokantaan " . DB_NAME . " ei saada yhteytt�");
?>
