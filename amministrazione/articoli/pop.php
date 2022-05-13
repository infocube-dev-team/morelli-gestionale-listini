
<head>
 <link rel="stylesheet" type="text/css" href="../../style.css">
</head>

<?php
session_start();

  $nome_fornitore = $_SESSION['fornitore'];
    
   if($nome_fornitore==NULL){
    unset($nome_fornitore);
   }

  $tipo_lavorazione = $_SESSION['tipo_lavorazione'];


 include("cat.php");
$con = mysql_connect($localhost.":".$localporta,$locallogin,$localpass);
if (!$con)
  {
   die('Could not connect: ' . mysql_error());
  }
 mysql_select_db($localnome, $con);



    //---------------------Seleziona Articolo----------------
	$query  = "SELECT id FROM fornitori WHERE ragione_sociale like '%" . $nome_fornitore . "%'";
	$result = mysql_query($query);
	 $row = mysql_fetch_row($result);
		{
		  $id_fornitore = $row[0];
		}




if($nome_fornitore!=NULL){
 $scritta = "Fornitore selezionato: <b>".$nome_fornitore."</b>";
}else{
 $scritta = "Nessun Fornitore Selezionato.";
}

?>





 <fieldset> <legend class="titoli">Elenco Articoli: ( <b><?php echo strtoupper($tipo_lavorazione);?></b> )</legend>




 <div align="center">
	<table border="1" cellspacing="3"  id="table1">
		<tr>
			<td align="center" class="info">  <?php echo $scritta;?> </td>
		</tr>
		<tr>
			<td align="center"> ----------- </td>
		</tr>
		
		
<?php
	
  if(isset($nome_fornitore)){    
	$query  = "SELECT descrizione FROM $tipo_lavorazione WHERE id_fornitore='$id_fornitore' ORDER BY descrizione";
	$result = mysql_query($query);
	 while($row = mysql_fetch_row($result))
		{
		  $descrizione = strtoupper($row[0]);
?>
	
		<tr>
			<td>&nbsp;&nbsp;&nbsp; <?php echo $descrizione;?></td>
		</tr>
	
<?php
  		}
  }else{
  
  
	$query  = "SELECT descrizione, id_fornitore FROM $tipo_lavorazione ORDER BY descrizione";
	$result = mysql_query($query);
	 while($row = mysql_fetch_row($result))
		{
		  $descrizione = strtoupper($row[0]);
		  $id_fornitore = strtoupper($row[0]);
?>
	
		<tr>
			<td>&nbsp;&nbsp;&nbsp; <?php echo $descrizione;?></td>
		</tr>
	
<?php
  		}
  
  
  }
?>
		
		
	</table>
</div>




 </fieldset>







<?php
 mysql_close($con);
  unset($_SESSION['fornitore']);
?>