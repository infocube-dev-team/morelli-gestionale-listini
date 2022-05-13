<?php
session_start();
$operatore = $_SESSION['utente'];

include("cat.php");
//--------------------Seleziona Articolo dal Database-------------------
$con = mysql_connect($localhost.":".$localporta,$locallogin,$localpass);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
   }
 mysql_select_db($localnome, $con);


 if($nome!=NULL){

	//------------Cerca Doppioni------------
	$query  = "SELECT nome FROM articoli";
	$result = mysql_query($query);
		while($row = mysql_fetch_row($result))
		{
			$nome_db = strtoupper($row[0]);
			
			 if(strtoupper($nome)==strtoupper($nome_db)){
			  $doppione = "SI";
			 }
		}

	if($doppione!="SI"){


    	mysql_query("INSERT INTO articoli (nome, codice, collezione, composizione, altezza, dettagli, operatore, grmq, seq_accoppiature)
     	 VALUES ('$nome', '$codice', '$collezione', '$composizione', '$altezza', '$dettagli', '$operatore', '$grmq', '$seq_accoppiature')");

			$nome = NULL;
			$codice = NULL;
			$collezione = NULL;
			$composizione = NULL;
			$altezza = NULL;
			$dettagli = NULL;


			  $_SESSION['messaggio'] = "Operazione effettuata correttamente.";
			  $color = "#00FF00";

			  header("location: seleziona_articolo.php");

  
  

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