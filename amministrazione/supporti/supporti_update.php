<?php
include("cat.php");
//--------------------Seleziona Articolo dal Database-------------------
$con = mysql_connect($localhost.":".$localporta,$locallogin,$localpass);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
   }
 mysql_select_db($localnome, $con);


 if($id!=NULL){

	if($nome!=NULL and $fornitore!=NULL){


	$fornitore = strtoupper($fornitore);
	//------------Cerca Doppioni------------
	$queryf  = "SELECT id FROM fornitori WHERE ragione_sociale='$fornitore'";
	$resultf = mysql_query($queryf);
		$rowf = mysql_fetch_row($resultf);
		{
			$fornitore_db = $rowf[0];
		}

echo $fornitore_db;

		 $query = "UPDATE supporti SET descrizione='$nome', cod_art_fornitore='$cod_art_fornitore', id_fornitore='$id_fornitore', m1='$m1', m2='$m2', m3='$m3', m4='$m4', m5='$m5', m6='$m6', m7='$m7', m8='$m8', c1='$c1', c2='$c2', c3='$c3', c4='$c4', c5='$c5', c6='$c6', c7='$c7', c8='$c8' WHERE id='$id'";
		 $result = mysql_query($query);
		  mysql_fetch_array($result);

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

			  $_SESSION['messaggio'] = "Modifica effettuata correttamente.";
			  $color = "#00FF00";
  

	}else{
	  $_SESSION['messaggio'] = "Compilare correttamente i campi Nome/Fornitore";
	  $color = "#FF0000";
	}


 }else{

  $_SESSION['messaggio'] = "Selezionare il nome di un elemento Supporti esistente.";
  $color = "#FF0000";

 }


 mysql_close($con);
?>