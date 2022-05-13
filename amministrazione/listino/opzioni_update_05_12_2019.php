<?php
include("cat.php");
//--------------------Seleziona Articolo dal Database-------------------
$con = mysql_connect($localhost.":".$localporta,$locallogin,$localpass);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
   }
 mysql_select_db($localnome, $con);
 
 
 if($_GET['operazione']=="elimina"){
  $id = $_GET['id'];
	mysql_query("DELETE FROM seq_accoppiature WHERE id='$id'");
  $opera = "ON";
 }

 if($_GET['operazione']=="aggiungi"){
   mysql_query("INSERT INTO seq_accoppiature (nome, ordine)
   VALUES ('-', '0')");
  $opera = "ON";
 }
 
 
 
if($opera!="ON"){

 $larghezza = $_POST['larghezza'];
 $righe = $_POST['righe'];
 $ordine = $_POST['ordine'];
 $mostra_altezza = $_POST['mostra_altezza'];
 $misura = $_POST['misura'];
 $contorni = $_POST['contorni'];
 $moneta = $_POST['moneta'];
 $separatore = $_POST['separatore'];
 $font = $_POST['font'];
 $font_dim = $_POST['font_dim'];
 
 $r500 = $_POST['r500'];
 $r400 = $_POST['r400'];
 $r300 = $_POST['r300'];
 $r200 = $_POST['r200'];
 $r100 = $_POST['r100'];
 $r31 = $_POST['r31'];
 $r1 = $_POST['r1'];
 
 
    $query = "UPDATE opzioni_listino SET larghezza='$larghezza', righe='$righe', ordine='$ordine', mostra_altezza='$mostra_altezza', misura='$misura', contorni='$contorni', moneta='$moneta', separatore='$separatore', font='$font', font_dim='$font_dim', r500='$r500', r400='$r400', r300='$r300', r200='$r200', r100='$r100', r31='$r31', r1='$r1'";                      
	$result = mysql_query($query);
 
 
 
 		$query  = "SELECT id FROM seq_accoppiature";
		$result = mysql_query($query);
			while($row = mysql_fetch_row($result))
			{
			  $seq = "seq".$row[0];
			  $seq = $_POST[$seq];
			  
			  $ordine_seq = "ordine_seq".$row[0];
			  $ordine_seq = $_POST[$ordine_seq];
			  
			  $id = $row[0];
			  
			  
	    		$queryf = "UPDATE seq_accoppiature SET nome='$seq', ordine='$ordine_seq' WHERE id='$id'";                      
				$resultf = mysql_query($queryf);
			}
 }

 mysql_close($con);
 
 header("location: opzioni.php");
?>
