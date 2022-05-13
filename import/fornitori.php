<?php
include("cat.php");
//--------------------Controlla login dal Database-------------------
$con = mysql_connect($localhost.":".$localporta,$locallogin,$localpass);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
   }
 mysql_select_db($localnome, $con);


  $file_handle = fopen("fornitori.txt", "rb");

	while (!feof($file_handle) ) {
  	 $line = fgets($file_handle);
  	 $line = strtoupper($line);

		//------------Seleziona auth------------
		$esiste = 10;
		$query  = "SELECT ragione_sociale FROM fornitori WHERE ragione_sociale = '$line'";
		$result = mysql_query($query);
			$row = mysql_fetch_row($result);
			{
			  $esiste = $row[0];
			}
			echo strtoupper(trim($line))."\n";

			    if($esiste!=10){
			 	 mysql_query("INSERT INTO fornitori (ragione_sociale)
			 	 VALUES ('$line')");
			 	}


	}



mysql_close($con);
?>