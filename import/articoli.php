<?php
include("cat.php");
//--------------------Controlla login dal Database-------------------
$con = mysql_connect($localhost.":".$localporta,$locallogin,$localpass);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
   }
 mysql_select_db($localnome, $con);


  $file_handle = fopen("articoli.txt", "rb");

	while (!feof($file_handle) ) {
  	 $line = fgets($file_handle);
  	 $line = strtoupper($line);
  	 $parts = explode("	", $line);
  	 $nome = strtoupper(trim($parts[0]));
  	 $collezione = strtoupper(trim($parts[2]));

			echo "$nome $collezione \n";

			 	 mysql_query("INSERT INTO articoli (nome, collezione)
			 	 VALUES ('$nome','$collezione')");
	}



mysql_close($con);
?>