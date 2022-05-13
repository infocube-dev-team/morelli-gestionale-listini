<?php
include("cat.php");
//--------------------Controlla login dal Database-------------------
$con = mysql_connect($localhost.":".$localporta,$locallogin,$localpass);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
   }
 mysql_select_db($localnome, $con);


  $file_handle = fopen("tintura.txt", "rb");

	while (!feof($file_handle) ) {
  	 $line = fgets($file_handle);
  	 $parts = explode("	", $line);
  	  $fornitore = strtoupper(trim($parts[13]));
  	  $descrizione = strtoupper(trim($parts[0]));
  	  $c1 = str_replace(",", ".", $parts[2]);
  	  $m1 = $parts[1];
  	  $c2 = str_replace(",", ".", $parts[4]);
  	  $m2 = $parts[3];
  	  $c3 = str_replace(",", ".", $parts[6]);
  	  $m3 = $parts[5];
  	  $c4 = str_replace(",", ".", $parts[8]);
  	  $m4 = $parts[7];
  	  $c5 = str_replace(",", ".", $parts[10]);
  	  $m5 = $parts[9];
  	  $c6 = str_replace(",", ".", $parts[12]);
  	  $m6 = $parts[11];

str_replace(",", ".", $parts[2]);
str_replace(",", ".", $parts[4]);
str_replace(",", ".", $parts[6]);
str_replace(",", ".", $parts[8]);
str_replace(",", ".", $parts[10]);
str_replace(",", ".", $parts[12]);
str_replace(",", ".", $parts[14]);

if($c1==0){
 $c1 = 0.00;
}
if($c2==0){
 $c2 = 0.00;
}
if($c3==0){
 $c3 = 0.00;
}
if($c4==0){
 $c4 = 0.00;
}
if($c5==0){
 $c5 = 0.00;
}
if($c6==0){
 $c6 = 0.00;
}
if($c7==0){
 $c7 = 0.00;
}
if($c8==0){
 $c8 = 0.00;
}

if($m1==0){
 $m1 = '0/0';
}
if($m2==0){
 $m2 = '0/0';
}
if($m3==0){
 $m3 = '0/0';
}
if($m4==0){
 $m4 = '0/0';
}
if($m5==0){
 $m5 = '0/0';
}
if($m6==0){
 $m6 = '0/0';
}
if($m7==0){
 $m7 = '0/0';
}
if($m8==0){
 $m8 = '0/0';
}
		//------------Seleziona auth------------
		//$esiste = 10;
		$query  = "SELECT id FROM fornitori WHERE ragione_sociale LIKE '%$fornitore%'";
		$result = mysql_query($query);
			$row = mysql_fetch_row($result);
			{
			  $id_fornitore = $row[0];
			}
			echo $id_fornitore."	".$descrizione."	".$c1."	".$m1."	".$c2."	".$m2."	".$c3."	".$m3."	".$c4."	".$m4."\n";

			 	 mysql_query("INSERT INTO tintura (id_fornitore, descrizione, c1, m1, c2, m2, c3, m3, c4, m4, c5, m5, c6, m6, c7, m7, c8, m8)
			 	 VALUES ('$id_fornitore', '$descrizione', '$c1', '$m1', '$c2', '$m2', '$c3', '$m3', '$c4', '$m4', '$c5', '$m5', '$c6', '$m6', '$c7', '$m7', '$c8', '$m8')");


	}



mysql_close($con);
?>