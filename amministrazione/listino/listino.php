<head>
<link rel="stylesheet" type="text/css" href="../../stampe.css">
</head>


<?php
 include("cat.php");
//--------------------Seleziona Articolo dal Database-------------------
$con = mysql_connect($localhost.":".$localporta,$locallogin,$localpass);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
   }
 mysql_select_db($localnome, $con);


 
 
 
 
 

//--------------opzioni del listino------------------------
		$query  = "SELECT larghezza, righe, ordine, mostra_altezza, misura, contorni, moneta, separatore, font, font_dim FROM opzioni_listino";
		$result = mysql_query($query);
			while($row = mysql_fetch_row($result))
			{
				$larghezza = $row[0];
				$righe = $row[1];
				$ordine = $row[2];
				$mostra_altezza = $row[3];
				$misura = $row[4];
				$contorni = $row[5];
				$moneta = $row[6];
				$separatore = $row[7];
				$font = $row[8];
				$font_dim = $row[9];
			}







?>

<br>
<br>


<div align="center">
	<table border="<?php echo $contorni;?>" id="table1" width="<?php echo $larghezza;?>" bordercolor="#CDCDCD" cellspacing="0" cellpadding="0">
		<tr>
			<td align="center"><b><font style="font-size: 7pt">Articolo</font></b></td>
			<td align="center"><b><font style="font-size: 7pt">ACC.</font></b></td>
			<td align="center"><b><font style="font-size: 7pt">500 mt.</font></b><p><b>
			<font style="font-size: 7pt">x colore</font></b></td>
			<td align="center"><b><font style="font-size: 7pt">400/499 mt.</font></b><p><b>
			<font style="font-size: 7pt">x colore</font></b></td>
			<td align="center"><b><font style="font-size: 7pt">300/399 mt.</font></b><p><b>
			<font style="font-size: 7pt">x colore</font></b></td>
			<td align="center"><span style="font-size: 7pt"><b>200</b></span><b><font style="font-size: 7pt">/299 mt.</font></b><p>
			<span style="font-size: 7pt"><b>x colore</b></span></td>
			<td align="center"><b><font style="font-size: 7pt">100/199 mt.</font></b><p><b>
			<font style="font-size: 7pt">x colore</font></b></td>
			<td align="center"><b><font style="font-size: 7pt">31/99 mt.</font></b><p><b>
			<font style="font-size: 7pt">x colore</font></b></td>
			<td align="center"><b><font style="font-size: 7pt">1/30 mt.</font></b><p><b>
			<font style="font-size: 7pt">x colore</font></b></td>
			<td align="center"><b><font style="font-size: 7pt">Composizione</font></b></td>
			<td align="center"><b><font style="font-size: 7pt">GR.MQ.</font></b></td>
		</tr>
		
<?php
    //---------------------Seleziona Articolo----------------
	$query  = "SELECT nome, altezza, composizione, grmq, id, dettagli FROM articoli WHERE stampa='ON' ORDER BY $ordine";
	$result = mysql_query($query);
	 while($row = mysql_fetch_row($result))
		{
		  $nome = strtoupper($row[0]);
		  $altezza = $row[1];
		  $composizione = $row[2];
		  $grmq = $row[3];
		  $id = $row[4];
		  $dettagli = $row[5];
		  
			 $scrivi = NULL;
			 $acc = NULL;
			 $grmq_print = NULL;
		

			//------------------Seleziona Prezzi---------------
			$queryf  = "SELECT 500mt, 400mt, 300mt, 200mt, 100mt, 31mt, 1mt FROM listino WHERE id_articolo='$id'";
			$resultf = mysql_query($queryf);
			 $rowf = mysql_fetch_row($resultf);
				{
				  $mt500 = str_replace(".", $separatore, $rowf[0]);
				  $mt400 = str_replace(".", $separatore, $rowf[1]);
				  $mt300 = str_replace(".", $separatore, $rowf[2]);
				  $mt200 = str_replace(".", $separatore, $rowf[3]);
				  $mt100 = str_replace(".", $separatore, $rowf[4]);
				  $mt31 = str_replace(".", $separatore, $rowf[5]);
				  $mt1 = str_replace(".", $separatore, $rowf[6]);
				}


		
			//-------------------Parsing del tipo di articolo----------
			if (strpos($nome,'SEMPLICE')) {
			 $scrivi="SI";
			 $acc = "Semplice";
			 $grmq_print = $grmq;
			 $nome = str_replace("SEMPLICE", "", $nome);
			}

			//-------------------Parsing del tipo di articolo----------
			if (strpos($nome,'TELA')) {
			 $acc = "Tela";
			 $nome = str_replace("TELA", "", $nome);
			 $scrivi="NO";
			}

			//-------------------Parsing del tipo di articolo----------
			if (strpos($nome,'REPS')) {
			 $acc = "Reps";
			 $nome = str_replace("REPS", "", $nome);
			 $scrivi="NO";
			}

			//-------------------Parsing del tipo di articolo----------
			if (strpos($nome,'LIGHT')) {
			 $acc = "Light";
			 $nome = str_replace("LIGHT", "", $nome);
			 $scrivi="NO";
			}
			
			//-------------------Parsing del tipo di articolo----------
			if (strpos($nome,'STRETCH')) {
			 $acc = "Stretch";
			 $nome = str_replace("STRETCH", "", $nome);
			 $scrivi="NO";
			}

			//-------------------Parsing del tipo di articolo----------
			if (strpos($nome,'LYCRA')) {
			 $acc = "Lycra";
			 $nome = str_replace("LYCRA", "", $nome);
			 $scrivi="NO";
			}	

			//-------------------Parsing del tipo di articolo----------
			if (strpos($nome,'RESINATO')) {
			 $acc = "Resinato";
			 $nome = str_replace("RESINATO", "", $nome);
			 $scrivi="NO";
			}
			//-------------------Parsing del tipo di articolo----------
			if (strpos($nome,'AIR')) {
			 $acc = "Air";
			 $nome = str_replace("AIR", "", $nome);
			 $scrivi="NO";
			}
		
		$nome = str_replace("ACC.", "", $nome);
		$nome = str_replace("ACC", "", $nome);
		
		
		
		
		
		
		

		
			  //--------------Conversione dell' altezza--------------
				if($mostra_altezza=="ON" && $scrivi=="SI"){
				 if($misura == "cm"){
				  $alt = $altezza." ".$misura;
				 }
				 if($misura == "mm"){
				  $alt = ($altezza*10)." ".$misura;
				 }
				 if($misura == "mt"){
				  $alt = ($altezza/100)." ".$misura;
				 }
				}else{
				  $alt = NULL;
				}



  			$new_tipo = explode(" ", $nome);
  			$new_tipo = $new_tipo[0]." ".$new_tipo[1];

			  //--------------------Distinzione per tipo/nome--------------------
			  if(trim($new_tipo)!=trim($old_tipo)){
			   //echo "<tr> <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td> </tr>";
			   echo "<tr> <td colspan=11>&nbsp;</td> </tr>";

			  }

if($mt500>0.00){
 $mon500 = $moneta;
}else{
 $mon500 = NULL;
}
if($mt400>0.00){
 $mon400 = $moneta;
}else{
 $mon400 = NULL;
}
if($mt300>0.00){
 $mon300 = $moneta;
}else{
 $mon300 = NULL;
}
if($mt200>0.00){
 $mon200 = $moneta;
}else{
 $mon200 = NULL;
}
if($mt100>0.00){
 $mon100 = $moneta;
}else{
 $mon100 = NULL;
}
if($mt31>0.00){
 $mon31 = $moneta;
}else{
 $mon31 = NULL;
}
if($mt1>0.00){
 $mon1 = $moneta;
}else{
 $mon1 = NULL;
}
?>
		
		<tr>
			<td> <span style="font-size: <?php echo $font_dim;?>pt"> <font face="<?php echo $font;?>"> <?php echo $nome."&nbsp;&nbsp;&nbsp;".$alt;?> </font> </span> </td>
			<td> <span style="font-size: <?php echo $font_dim;?>pt"> <font face="<?php echo $font;?>"> <?php echo $acc;?> </font> </span> </td>
			<td> <span style="font-size: <?php echo $font_dim;?>pt"> <font face="<?php echo $font;?>"> <?php echo $mon500." ".$mt500;?> </font> </span> </td>
			<td> <span style="font-size: <?php echo $font_dim;?>pt"> <font face="<?php echo $font;?>"> <?php echo $mon400." ".$mt400;?> </font> </span> </td>
			<td> <span style="font-size: <?php echo $font_dim;?>pt"> <font face="<?php echo $font;?>"> <?php echo $mon300." ".$mt300;?> </font> </span> </td>
			<td> <span style="font-size: <?php echo $font_dim;?>pt"> <font face="<?php echo $font;?>"> <?php echo $mon200." ".$mt200;?> </font> </span> </td>
			<td> <span style="font-size: <?php echo $font_dim;?>pt"> <font face="<?php echo $font;?>"> <?php echo $mon100." ".$mt100;?> </font> </span> </td>
			<td> <span style="font-size: <?php echo $font_dim;?>pt"> <font face="<?php echo $font;?>"> <?php echo $mon31." ".$mt31;?> </font> </span> </td>
			<td> <span style="font-size: <?php echo $font_dim;?>pt"> <font face="<?php echo $font;?>"> <?php echo $mon1." ".$mt1;?> </font> </span> </td>
			<td> <span style="font-size: <?php echo $font_dim;?>pt"> <font face="<?php echo $font;?>"> <?php echo $composizione;?> </font> </span> </td>
			<td> <span style="font-size: <?php echo $font_dim;?>pt"> <font face="<?php echo $font;?>"> <?php echo $grmq_print;?> </font> </span> </td>
		</tr>

<?php
  			//----------Distinzione tipologie-----------------
  			$old_tipo = explode(" ", $nome);
  			$old_tipo = $old_tipo[0]." ".$old_tipo[1];
 }
?>
		
		
	</table>
</div>



<?php
 mysql_close($con);
?>