<html>

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
$ragione_sociale= $_GET['ragione_sociale'];
$codice = $_GET['codice'];
?>




<fieldset> <legend class="titoli">Gestione Clienti</legend>


<form method="GET" action="gestione_clienti.php">

	<div align="center">
		<table border="0" id="table1">
		
						
			<tr>
				<td align="center">
				 <fieldset> <legend class="titoli">Seleziona Cliente da cercare:</legend>
				  
				  <div align="center">
					<table border="0" cellspacing="0" id="table2">
						<tr>
							<td>Cliente:</td>
							<td>
							<input type="text" name="nome" size="45" id="nome" value="<?php echo $ragione_sociale;?>">
							<input type="hidden" name="id" size="45" id="id" value="<?php echo $id;?>"></td>
						</tr>
						<tr>
							<td colspan="2">
							<p align="center">
							<input type="submit" value="Seleziona" name="fine"></td>
						</tr>
					</table>
				   </div>
				  
				 </fieldset>		
				</td>
			</tr>
			
			
			</table>
	</div>
	<p>&nbsp;</p>
</form>



</fieldset>



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

<?php


include("cat.php");
//--------------------Seleziona Articolo dal Database-------------------
$con = mysql_connect($localhost.":".$localporta,$locallogin,$localpass);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
   }
 mysql_select_db($localnome, $con);
?>

<body>

</body>

</html>