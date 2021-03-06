<?php

mysqli_connect("localhost", "root", "") or die("Error connecting to database: ".mysqli_error());

mysqli_select_db("ravitsemusterapeuttisovellus") or die(mysqli_error());

?>

<?php
	require "header.php";
?>

<main>

<button type="button" class="btn" style="background-color:#C1727B"><a href="haku.php">UUSI HAKU</button>

<?php

$query = "SELECT * FROM ravitsemusterapeutti AS rt
INNER JOIN henkilonerityisosaaminen AS he ON rt.HENKILO_ID = he.HENKILO_ID
INNER JOIN erityisosaaminen AS eo ON he.ERITYISOSAAMINEN_ID = eo.ERITYISOSAAMINEN_ID"; //hakulausekkeen alku
$i = 0; //laskuri

if(isset($_GET['nimi'])){
	$qnimi = $_GET['nimi'];
	if($i==0){
		$query = $query + " WHERE " + "(`rt.ETUNIMI` LIKE '%".$qnimi."%') OR (`rt.SUKUNIMI` LIKE '%".$qnimi."%')";
		$i++;
	}
	else{
		$query = $query + " AND " + "(`rt.ETUNIMI` LIKE '%".$qnimi."%') OR (`rt.SUKUNIMI` LIKE '%".$qnimi."%')";
	}
}
if(isset($_GET['paikkakunta'])){
	$qpaikkakunta = $_GET['paikkakunta'];
	if($i==0){
		$query = $query + " WHERE " + "(`rt.PAIKKAKUNTA`='".$qpaikkakunta."')";
		$i++;
	}
	else{
		$query = $query + " AND " + "(`rt.PAIKKAKUNTA`='".$qpaikkakunta."')";
	}
}
if(isset($_GET['cb_diabetes'])){
	$qcb_diabetes = $_GET['cb_diabetes'];
	if($i==0){
		$query = $query + " WHERE " + "(`eo.OSAAMISEN_NIMI`='".$qcb_diabetes."')";
		$i++;
	}
	else{
		$query = $query + " AND " + "(`eo.OSAAMISEN_NIMI`='".$qcb_diabetes."')";
	}
}
if(isset($_GET['cb_keliakia'])){
	$qcb_keliakia = $_GET['cb_keliakia'];
	if($i==0){
		$query = $query + " WHERE " + "(`eo.OSAAMISEN_NIMI`='".$qcb_keliakia."')";
		$i++;
	}
	else{
		$query = $query + " AND " + "(`eo.OSAAMISEN_NIMI`='".$qcb_keliakia."')";
	}
}

$query = htmlspecialchars($query); //muuntaa html merkit sopiviksi

$query = mysqli_real_escape_string($query); //estää sql-injektion

$rawresults = mysql_query($query);

if(mysqli_num_rows($rawresults) > 0){ //jos tuloksia on
	while($results = mysqli_fetch_array($rawresults)){ //looppaa kun tietojen siirto tauluun onnistuu
		echo $results['ETUNIMI'].$results['SUKUNIMI'].$results['PAIKKAKUNTA'].$results['OSOITE']
		.$results['EMAIL'].$results['PUHELINNRO'];
	}
}
else{ //jos tuloksia ei ole
	echo "Hakuehtoja vastaavia ravitsemusterapeutteja ei löytynyt.";
}

?>
</main>

<?php
	require "footer.php";
?>