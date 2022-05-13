<?php
session_start();

$codice = $_POST['codice'];
$ragione_sociale = $_POST['ragione_sociale'];
$indirizzo = $_POST['indirizzo'];
$stato = $_POST['stato'];
$citta = $_POST['citta'];
$provincia = $_POST['provincia'];
$cap = $_POST['cap'];
$cf = $_POST['cf'];
$piva = $_POST['piva'];
$telefono = $_POST['telefono'];
$fax = $_POST['fax'];
$email = $_POST['email'];
$note = $_POST['note'];


include("cat.php");
//--------------------Aggiorna il Database-------------------
$con = mysql_connect($localhost.":".$localporta,$locallogin,$localpass);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
   }
 mysql_select_db($localnome, $con);
 
 
  mysql_query("INSERT INTO fornitori (codice, ragione_sociale, indirizzo, stato, citta, provincia, cap, cf, piva, telefono, fax, email, note)
   VALUES ('$codice', '$ragione_sociale', '$indirizzo', '$stato', '$citta', '$provincia', '$cap', '$cf', '$piva', '$telefono', '$fax', '$email', '$note')");

 
//--------------------------Scrive nel LOG------------------------------
 $utente=$_SESSION['utente'];
 $iprem=getenv(REMOTE_ADDR);
 mysql_query("INSERT INTO log (descrizione, utente, ip)
 VALUES ('Inserito fornitore $ragione_sociale', '$utente', '$iprem')");

 
 mysql_close($con);
 
 header("location: crea_fornitore.php");
?>