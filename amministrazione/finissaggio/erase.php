<?php
session_start();

include("cat.php");
//--------------------Seleziona Articolo dal Database-------------------
$con = mysql_connect($localhost.":".$localporta,$locallogin,$localpass);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
   }
 mysql_select_db($localnome, $con);


 $id = $_POST['id'];

 if($_POST['conferma']=="Conferma Eliminazione"){
  mysql_query("DELETE FROM finissaggio WHERE id = '$id'");
	  $_SESSION['messaggio'] = "Eliminazione Effettuata.";
	  $color = "#00FF00";
 }

 if($_POST['reset']=="Annulla Eliminazione"){
	  $_SESSION['messaggio'] = "Eliminazione Annullata.";
	  $color = "#00FF00";
 }
 
 
 mysql_close($con);


 
header("location: elimina.php");
?>