<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<link rel="stylesheet" type="text/css" href="../../style.css">
<title>Ricerca offerte</title>


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
session_start();
if(!$_GET['nome'] || !$_GET['operatore'] || !$_GET['damese']){
	unset($_SESSION['id_cliente']);
	unset($_SESSION['operatore']);
	unset($_SESSION['damese']);
	unset($_SESSION['daanno']);
	unset($_SESSION['dagg']);
	unset($_SESSION['amese']);
	unset($_SESSION['aanno']);
	unset($_SESSION['agg']);
	if(!$_POST['nome']) unset($_POST['id']);
}

//--------------------Seleziona Articolo dal Database-------------------
$con = mysql_connect($localhost.":".$localporta,$locallogin,$localpass);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
   }
 mysql_select_db($localnome, $con);
 
?> 
 
<body>
<form method="POST" action="elenca_offerte.php" target="risultato">
<div align="center">
<tr></tr>
	<table border="0">
		<tr>
			<td>Ragione Sociale</td>
			<td>
			<p>
			<input type="text" name="nome" size="45" id="nome" value="<?php echo $ragione_sociale;?>">
			<input type="hidden" name="id" size="45" id="id" value="<?php echo $id;?>"></td>
		</tr>
		<tr>
			<td>Operatore</td>
			<td><select size="1" name="operatore">
			<option></option>
			<?php
				$query = "SELECT login FROM login";
 
 				$result = mysql_query($query);
 				while($row = mysql_fetch_array($result, MYSQL_ASSOC))
 				{
					$operatore=$row['login'];				
			?>
			<option><?php echo $operatore; ?></option>
			
			<?php
				}
			?></select></td>
		</tr>
		<tr>
			<td>Data inizio</td>
			<td><input type="text" name="dagg" id="dagg" size="2" maxlength="2">/<input type="text" name="damese" id="damese" size="2" maxlength="2">/<input type="text" name="daanno" id="daanno" size="4" maxlength="4"></td>
		</tr>
		<tr>
			<td>Data fine</td>
			<td><input type="text" name="agg" id="agg" size="2" maxlength="2">/<input type="text" name="amese" id="amese" size="2" maxlength="2">/<input type="text" name="aanno" id="aanno" size="4" maxlength="4"></td>
		</tr>
		<tr>
			<td colspan="2">
			<p align="center">
			<input type="hidden" name="reset" value="si">
			<input type="submit" name="ricerca" value="Ricerca"></td>
		</tr>
	</table></div>
</form>

</body>

</html>

<?php

if (isset($_GET['submit'])) {
echo "<p>";
    while (list($key,$value) = each($_POST)){
    echo "<strong>" . $key . "</strong> = ".$value."<br />";
    }
echo "</p>";
}

?>

<script>
$(function() {
	 
      $("#nome").autocomplete({
        source: "cliente_suggest.php",
        minLength: 2,
        select: function(event, ui) {
         $('#id').val(ui.item.id);
         $('#nome').val(ui.item.ragione_sociale);
         $('#codice').val(ui.item.codice);
        }
       });

});
</script>