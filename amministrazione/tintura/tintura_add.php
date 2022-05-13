<?php
include("cat.php");
//--------------------Seleziona Articolo dal Database-------------------
$con = mysql_connect($localhost.":".$localporta,$locallogin,$localpass);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
   }
 mysql_select_db($localnome, $con);


 if($nome!=NULL and $fornitore!=NULL){

	//------------Cerca Doppioni------------
	$query  = "SELECT descrizione FROM tintura";
	$result = mysql_query($query);
		while($row = mysql_fetch_row($result))
		{
			$descrizione = strtoupper($row[0]);
			
			 if($descrizione==strtoupper($nome)){
			  $doppione = "SI";
			 }
		}

	if($doppione!="SI"){


    	mysql_query("INSERT INTO tintura (descrizione, cod_art_fornitore, id_fornitore, m1, m2, m3, m4, m5, m6, m7, m8, c1, c2, c3, c4, c5, c6, c7, c8)
     	 VALUES ('$nome', '$cod_art_fornitore', '$id_fornitore', '$m1', '$m2', '$m3', '$m4', '$m5', '$m6', '$m7', '$m8', '$c1', '$c2', '$c3', '$c4', '$c5', '$c6', '$c7', '$c8')");

			$nome = NULL;
			$cod_art_fornitore = null;
			$fornitore = null;
			$m1 = NULL;
			$m2 = NULL;
			$m3 = NULL;
			$m4 = NULL;
			$m5 = NULL;
			$m6 = NULL;
			$m7 = NULL;
			$m8 = NULL;
			$c1 = NULL;
			$c2 = NULL;
			$c3 = NULL;
			$c4 = NULL;
			$c5 = NULL;
			$c6 = NULL;
			$c7 = NULL;
			$c8 = NULL;

			  $_SESSION['messaggio'] = "Operazione effettuata correttamente.";
			  $color = "#00FF00";
  

	}else{
	  $_SESSION['messaggio'] = "Esiste gia' un nome - ".strtoupper($nome)." - ";
	  $color = "#FF0000";
	}


 }else{

  $_SESSION['messaggio'] = "Il campo Nome/Fornitore devono essere compilati correttamente.";
  $color = "#FF0000";

 }



 mysql_close($con);
?>