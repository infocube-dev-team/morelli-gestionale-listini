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
$codice = $_GET['codice'];
$nome = $_GET['nome'];
$collezione = $_GET['collezione'];
$composizione = $_GET['composizione'];
$altezza = $_GET['altezza'];
?>




<fieldset> <legend class="titoli">Gestione Degli Articoli</legend>


<form method="GET" action="articoli_crea.php">

	<div align="center">
		<table border="0" id="table1">
		
						
			<tr>
				<td align="center">
				 <fieldset> <legend class="titoli">Seleziona articolo da cercare:</legend>
				  
				  <div align="center">
					<table border="0" cellspacing="0" id="table2">
						<tr>
							<td>Nome Articolo:</td>
							<td>
							<input type="text" name="nome" size="45" id="nome" value="<?php echo $nome;?>">
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
        source: "articoli_suggest.php",
        minLength: 2,
        select: function(event, ui) {
         $('#id').val(ui.item.id);
         $('#value').val(ui.item.nome);
         $('#codice').val(ui.item.codice);
         $('#collezione').val(ui.item.collezione);
         $('#composizione').val(ui.item.composizione);
         $('#altezza').val(ui.item.altezza);
         $('#calo').val(ui.item.calo);
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




<fieldset> <legend class="titoli">Ultimi 25 articoli Elaborati:</legend>



<div align="center">
	<table border="0" cellspacing="3"  id="table3">
	
		<tr>
			<td align="center"> Nome </td>
			<td align="center"> &nbsp; </td>
			<td align="center"> Operatore </td>
			<td align="center"> Data </td>
		</tr>

		<tr>
			<td>&nbsp;</td>
			<td> &nbsp;</td>
			<td> &nbsp;</td>
			<td> &nbsp;</td>
		</tr>
		
	
	<?php
		//------------Seleziona articolo------------
		$query  = "SELECT id, nome, operatore, data, seq_accoppiature FROM articoli ORDER BY data DESC limit 25";
		$result = mysql_query($query);
			while($row = mysql_fetch_row($result))
			{
				$id = $row[0];
				$nome = $row[1];
				$operatore = $row[2];
				$data = $row[3];
				$seq_accoppiature = $row[4];
				
				//------------Sequenza Accoppiature------------
				$querys  = "SELECT nome FROM seq_accoppiature WHERE ordine='$seq_accoppiature'";
				$results = mysql_query($querys);
					while($rows = mysql_fetch_row($results))
					{
						$seq_accoppiature = $rows[0];
					}
				
				
	?>
		
		<tr>
			<td> <a href="articoli_crea.php?id=<?php echo $id;?>"> <?php echo $nome;?> </a> 
			     <b><font color="#D8DC9C"> <?php echo $seq_accoppiature;?> </font></b> </td>
			<td> &nbsp; </td>
			<td> <?php echo $operatore;?> </td>
			<td> &nbsp;&nbsp; <?php echo $data;?> </td>
		</tr>
		
	<?php

			}

	?>
		
		
	</table>
</div>


</fieldset>




<?php
 mysql_close($con);
?>