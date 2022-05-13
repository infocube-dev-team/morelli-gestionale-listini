<?php
include("cat.php");
//--------------------Controlla login dal Database-------------------
$con = mysql_connect($localhost.":".$localporta,$locallogin,$localpass);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
   }
 mysql_select_db($localnome, $con);


  $file_handle = fopen("greggio.txt", "rb");

	while (!feof($file_handle) ) {
  	 $line = fgets($file_handle);
  	 $parts = explode("	", $line);
  	  $fornitore = strtoupper(trim($parts[0]));
  	  $descrizione = strtoupper(trim($parts[1]));
  	  $cod_art_fornitore = strtolower(trim($parts[2]));
  	  $c1 = str_replace(",", ".", $parts[3]);
  	  $m1 = $parts[4];
  	  $c2 = str_replace(",", ".", $parts[5]);
  	  $m2 = $parts[6];
  	  $c3 = str_replace(",", ".", $parts[7]);
  	  $m3 = $parts[8];
  	  $c4 = str_replace(",", ".", $parts[9]);
  	  $m4 = $parts[10];

str_replace(",", ".", $parts[3]);

if(!isset($cod_art_fornitore)){
 $cod_art_fornitore = "-";
}
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
			echo $id_fornitore."	".$descrizione."	".$cod_art_fornitore."	".$c1."	".$m1."	".$c2."	".$m2."	".$c3."	".$m3."	".$c4."	".$m4."\n";

			 	 mysql_query("INSERT INTO greggio (id_fornitore, descrizione, cod_art_fornitore, c1, m1, c2, m2, c3, m3, c4, m4, c5, m5, c6, m6, c7, m7, c8, m8)
			 	 VALUES ('$id_fornitore', '$cod_art_fornitore', '$descrizione', '$c1', '$m1', '$c2', '$m2', '$c3', '$m3', '$c4', '$m4', '$c5', '$m5', '$c6', '$m6', '$c7', '$m7', '$c8', '$m8')");


	}



mysql_close($con);
?>