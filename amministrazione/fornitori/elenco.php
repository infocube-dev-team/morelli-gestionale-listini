
<head>
<link rel="stylesheet" type="text/css" href="../../stampe.css">
</head>



<?php
 $nome_fornitore = $_POST['fornitore'];
 $tipo_lavorazione = $_POST['tipo_lavorazione'];
 $id_fornitore = $_POST['id_fornitore'];
 $ordine = $_POST['ordine'];
?>


<div align="center">
	<table border="0" cellspacing="3" id="table1">
		<tr>
			<td colspan="10" align="center">Nome Fornitore:&nbsp; 
			<b><font size="3">  <?php echo strtoupper($nome_fornitore);?>  </font></b></td>
		</tr>
		<tr>
			<td colspan="10" align="center">Tipo Lavorazione:&nbsp;   <b>  <?php echo strtoupper($tipo_lavorazione);?> </b></td>
		</tr>
		<tr>
			<td colspan="10"><hr></td>
		</tr>
		
		
		<tr>
			<td align="center"><b><u><i>Codice Fornitore </i></u></b></td>
			<td align="center"><b><u><i>Nome Art. </i></u></b></td>
			<td colspan="8" align="center"><b><u><i>Metratura</i></u></b></td>
		</tr>
		
		
		<?php
		include("cat.php");
		//--------------------Seleziona Articolo dal Database-------------------
		$con = mysql_connect($localhost.":".$localporta,$locallogin,$localpass);
		if (!$con)
		  {
		  die('Could not connect: ' . mysql_error());
		   }
		 mysql_select_db($localnome, $con);






		//------------Seleziona articolo------------
		$query  = "SELECT descrizione, m1, m2, m3, m4, m5, m6, m7, m8, c1, c2, c3, c4, c5, c6, c7, c8, cod_art_fornitore FROM $tipo_lavorazione WHERE id_fornitore = '$id_fornitore' ORDER BY $ordine";
		$result = mysql_query($query);
			while($row = mysql_fetch_row($result))
			{
				$articolo = $row[0];
				$m1 = $row[1];
				$m2 = $row[2];
				$m3 = $row[3];
				$m4 = $row[4];
				$m5 = $row[5];
				$m6 = $row[6];
				$m7 = $row[7];
				$m8 = $row[8];
				
				$c1 = $row[9];
				$c2 = $row[10];
				$c3 = $row[11];
				$c4 = $row[12];
				$c5 = $row[13];
				$c6 = $row[14];
				$c7 = $row[15];
				$c8 = $row[16];
				$cod_art_fornitore = $row[17];


if($c1==0){
 $c1=NULL;
 $m1=NULL;
}

if($c2==0){
 $c2=NULL;
 $m2=NULL;
}

if($c3==0){
 $c3=NULL;
 $m3=NULL;
}

if($c4==0){
 $c4=NULL;
 $m4=NULL;
}

if($c5==0){
 $c5=NULL;
 $m5=NULL;
}

if($c6==0){
 $c6=NULL;
 $m6=NULL;
}

if($c7==0){
 $c7=NULL;
 $m7=NULL;
}

if($c8==0){
 $c8=NULL;
 $m8=NULL;
}
		?>





		<tr>
			<td rowspan="3"><b> <?php echo $articolo;?> </b></td>
			<td rowspan="3"><b> <?php echo $cod_art_fornitore;?> </b></td>
			<td>&nbsp; <?php echo $m1;?> </td>
			<td>&nbsp; <?php echo $m2;?></td>
			<td>&nbsp; <?php echo $m3;?></td>
			<td>&nbsp; <?php echo $m4;?></td>
			<td>&nbsp; <?php echo $m5;?></td>
			<td>&nbsp; <?php echo $m6;?></td>
			<td>&nbsp; <?php echo $m7;?></td>
			<td>&nbsp; <?php echo $m8;?></td>
		</tr>
		<tr>
			<td>&nbsp; <?php echo $c1;?></td>
			<td>&nbsp; <?php echo $c2;?></td>
			<td>&nbsp; <?php echo $c3;?></td>
			<td>&nbsp; <?php echo $c4;?></td>
			<td>&nbsp; <?php echo $c5;?></td>
			<td>&nbsp; <?php echo $c6;?></td>
			<td>&nbsp; <?php echo $c7;?></td>
			<td>&nbsp; <?php echo $c8;?></td>
		</tr>
		
		
		<tr>
			<td colspan="8">&nbsp;</td>
		</tr>
		
		<?php
		}
		  mysql_close($con);
		?>




		
		
		</table>
</div>