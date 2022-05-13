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
session_start();

 unset($_SESSION['id_cliente']);
unset($_SESSION['operatore']);
unset($_SESSION['data_inizio']);
unset($_SESSION['data_fine']);
 

include("cat.php");
//--------------------Seleziona Articolo dal Database-------------------
$con = mysql_connect($localhost.":".$localporta,$locallogin,$localpass);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
   }
 mysql_select_db($localnome, $con);
 
	$_SESSION['id_cliente']=$_GET['id'];
echo "id_cleinte: ".$_SESSION['id_cliente'].$_GET['nome'];

?>

<form method="GET" action="elenca_offerte.php" target="risultato" >
<div align="center">

<table border="0" width="300">
	<tr>
		<td width="292" colspan="2">
		<p align="center"><b>RICERCA OFFERTA</b></td>
	</tr>
	<tr>
		<td width="97">Ragione Sociale</td>
		<td width="189">
			<p><input type="text" name="nome" id="nome" size="37"></p>
			<input type="hidden" name="id" id="id" size="5"></td>
		</td>
	</tr>
	<tr>
		<td height="23" width="97">Operatore</td>
		<td height="23" width="189">
			<select size="1" name="operatore">
			<option> </option>
			<?php
				$query = "SELECT login FROM login";
 
 				$result = mysql_query($query);
 				while($row = mysql_fetch_array($result, MYSQL_ASSOC))
 				{
					$operatore=$row['login'];				
			?>
			<option><?php echo $_SESSION['operatore'] ?> </option>
			
			<?php
				}
			?>
			</select></td>
	</tr>
	<tr>
		<td height="23" width="97">Da</td>
		<td height="23" width="189">
			
			<input type="text" name="dagg" size="2">/<input type="text" name="damese" size="2">/<input type="text" name="daanno" size="4"></td>
	</tr>
	<tr>
		<td width="97">a</td>
		<td width="189">	
		<input type="text" name="agg" size="2">/<input type="text" name="amese" size="2">/<input type="text" name="aanno" size="4"></td>
	</tr>
</table>

</div>

	<p><input type="submit" value="Ricerca" name="ricerca"></p>
</form>


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
