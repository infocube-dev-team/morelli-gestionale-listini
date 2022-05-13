<head>
<meta http-equiv="Content-Language" content="it">
<link rel="stylesheet" type="text/css" href="../../style.css">




<script type="text/javascript">
function stopRKey(evt) {
  var evt = (evt) ? evt : ((event) ? event : null);
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
  }
document.onkeypress = stopRKey;
</script>

<link rel="stylesheet" type="text/css" href="../ajax/jquery-ui.css">
<script src="../ajax/jquery.min.js"></script>
<script src="../ajax/jquery-ui.min.js"></script>

</head>

<?php
include("cat.php");

$con = mysql_connect($localhost.":".$localporta,$locallogin,$localpass);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
   }
 mysql_select_db($localnome, $con);

 
if($_GET['id']>0){
 $id = $_GET['id'];
}
if($_POST['id']>0){
 $id = $_POST['id'];
}

if($_GET['id']==NULL){
 $id=NULL;
 $ragione=$_GET['nome'];
 $add=1;
}


if($id!=NULL){
	//il Cliente è già nel DB
	$query="SELECT codice, ragione_sociale, indirizzo, stato, citta, provincia, cap, cf, piva, telefono, email, note FROM clienti where id='$id'";
	$result = mysql_query($query);
	while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	{
		$codice =$row['codice'];
		$ragione = $row['ragione_sociale'];
		$indirizzo = $row['indirizzo'];
		$stato = $row['stato'];
		$citta = $row['citta'];
		$pr = $row['provincia'];
		$cap = $row['cap'];
		$cf = $row['cf'];
		$piva = $row['piva'];
		$telefono = $row['telefono'];
		$fax = $row['fax'];
		$mail = $row['email'];
		$note = $row['note'];
		
	}
}

?>

<body>


<form method="POST" action="gestione_clienti.php" >
<table border="1" width="37%">
	<tr>
		<td width="11%">Codice</td>
		
		<td colspan="3">
		<input type="text" value="<?php echo $codice?>" name="codice" id="codice" size="30"></td>
	</tr>
	<tr>
		<td width="11%">Ragione Sociale</td>
		<input type="hidden" value="<?php echo $id?>" name="id" id="id" size="50">
		
		<td colspan="3"><input type="text" value="<?php echo $ragione?>" name="ragione_sociale" id="ragione_sociale" size="50"></td>
	</tr>
	<tr>
		<td width="11%">Indirizzo</td>
		<td colspan="3"><input type="text" value="<?php echo $indirizzo?>" name="indirizzo" id="indirizzo" size="50"></td>
	</tr>
	<tr>
		<td width="11%">Città</td>
		<td width="29%"><input type="text" value="<?php echo $citta?>" name="citta" id="citta" size="20"></td>
		<td width="15%">Provincia</td>
		<td width="7%"><input type="text" value="<?php echo $pr?>" name="pr" id="pr" size="2"></td>
	</tr>
	<tr>
		<td width="11%">CAP</td>
		<td width="29%"><input type="text" value="<?php echo $cap?>" name="cap" id="cap" size="6"></td>
		<td width="15%">Stato</td>
		<td width="28%"><input type="text" value="<?php echo $stato?>" name="stato" id="stato" size="20"></td>
	</tr>
	<tr>
		<td width="11%">P. IVA</td>
		<td width="29%"><input type="text" value="<?php echo $piva?>" name="piva" id="piva" size="20"></td>
		<td width="15%">C.F.</td>
		<td width="28%"><input value="<?php echo $cf?>" type="text" name="cf" id="cf" size="20"></td>
	</tr>
	<tr>
		<td width="11%">Telefono</td>
		<td width="29%"><input type="text" value="<?php echo $telefono?>" name="telefono" id="telefono" size="20"></td>
		<td width="15%">Fax</td>
		<td width="28%"><input type="text" value="<?php echo $fax ?>" name="fax" id="fax" size="20"></td>
	</tr>
	<tr>
		<td width="11%">Mail</td>
		<td width="29%"><input type="text" value="<?php echo $mail ?>" name="mail" id="mail" size="20"></td>
		<td width="15%">Note</td>
		<td width="28%"><input type="text" value="<?php echo $note?>" name="note" id="note" size="20"></td>
	</tr>
</table>



<?php
if($_POST['id']!=NULL){
 	$id =$_POST['id'];
	$codice =$_POST['codice'];
	$ragione = $_POST['ragione_sociale'];
	$indirizzo = $_POST['indirizzo'];
	$stato = $_POST['stato'];
	$citta = $_POST['citta'];
	$pr = $_POST['pr'];
	$cap = $_POST['cap'];
	$cf = $_POST['cf'];
	$piva = $_POST['piva'];
	$telefono = $_POST['telefono'];
	$fax = $_POST['fax'];
	$mail = $_POST['mail'];
	$note = $_POST['note'];
	
	$query="UPDATE clienti SET codice='$codice', ragione_sociale='$ragione', indirizzo='$indirizzo', stato='$stato', citta='$citta', provincia='$pr', cap='$cap', cf='$cf', piva='$piva', telefono='$telefono', fax='$fax', email='$mail', note='$note' WHERE id='$id'";
	
	$result = mysql_query($query);
	
	//echo $query;
	
	if($result!=FALSE) header('Location: seleziona_cliente.php'); 
 
}
if($_POST['id']==NULL && $_POST['indirizzo']!=NULL){
	//echo "Inserimento nuovo Cliente!<br>";
	$codice =$_POST['codice'];
	$ragione = $_POST['ragione_sociale'];
	$indirizzo = $_POST['indirizzo'];
	$stato = $_POST['stato'];
	$citta = $_POST['citta'];
	$pr = $_POST['pr'];
	$cap = $_POST['cap'];
	$cf = $_POST['cf'];
	$piva = $_POST['piva'];
	$telefono = $_POST['telefono'];
	$fax = $_POST['fax'];
	$mail = $_POST['mail'];
	$note = $_POST['note'];
	
	 $query="INSERT INTO clienti (codice, ragione_sociale, indirizzo, stato, citta, provincia, cap, cf, piva, telefono, fax, email, note) VALUES ('$codice', '$ragione', '$indirizzo', '$stato', '$citta', '$pr', '$cap', '$cf', '$piva', '$telefono', '$fax', '$mail', '$note')"; 
	$result=mysql_query($query);
	$id=mysql_insert_id();
	if($result!=FALSE){ header('Location: seleziona_cliente.php');};
	//echo $query."<br>";
}
mysql_close($con);
?>

	<input type="submit" value="Conferma Dati" name="B1"><p>&nbsp;</p>
<p>&nbsp;</p>
</p>
</form>
<table border="1" width="37%">
	<tr>
		<td width="11%">Ragione Sociale</td>
		
		<td>
		<input type="text" value="<?php echo $ragione?>" name="ragione_sociale0" id="ragione_sociale0" size="50"></td>
		
		<td>
		<input type="submit" value="Elimina Cliente" name="B2" style="color: #FF0000"></td>
	</tr>
</table>



<p>&nbsp;</p>
</body>

</html>