
<head>
<link rel="stylesheet" type="text/css" href="../../style.css">
</head>


<link rel="stylesheet" type="text/css" href="../ajax/jquery-ui.css">
<script src="../ajax/jquery.min.js"></script>
<script src="../ajax/jquery-ui.min.js"></script>


<fieldset> <legend class="titoli">Inserimento Nuovi Fornitori</legend>

<form method="POST" action="fornitori_add.php">

<div align="center">
	<table id="table1">
		<tr>
			<td>&nbsp;Codice Fornitore</td>
			<td><input type="text" name="codice" size="35"></td>
		</tr>
		<tr>
			<td>&nbsp;Ragione Sociale</td>
			<td><input type="text" name="ragione_sociale" size="35"></td>
		</tr>
		<tr>
			<td>&nbsp;Indirizzo sede legale&nbsp;&nbsp; </td>
			<td><input type="text" name="indirizzo" size="35"></td>
		</tr>
		<tr>
			<td>&nbsp;Stato </td>
			<td>
			
    
		    <input type="text" name="stato" id="state" size="13"></td>
		</tr>
		<tr>
			<td>&nbsp;Citta'</td>
			<td><input type="text" name="citta" id="citta" size="13"></td>
		</tr>
		<tr>
			<td>&nbsp;Provincia</td>
			<td><input type="text" name="provincia" size="13"></td>
		</tr>
		<tr>
			<td>&nbsp;C.a.p. </td>
			<td><input type="text" name="cap" size="13"></td>
		</tr>
		<tr>
			<td>&nbsp;C.F. Ditta</td>
			<td><input type="text" name="cf" size="23"></td>
		</tr>
		<tr>
			<td>&nbsp;P.IVA</td>
			<td><input type="text" name="piva" size="23"></td>
		</tr>
		<tr>
			<td>&nbsp;Telefono </td>
			<td><input type="text" name="telefono" size="23"></td>
		</tr>
		<tr>
			<td>&nbsp;Fax</td>
			<td><input type="text" name="fax" size="23"></td>
		</tr>
		<tr>
			<td>&nbsp;E-mail </td>
			<td><input type="text" name="email" size="29"></td>
		</tr>
		<tr>
			<td>
			<div>
				&nbsp;Note</div>
			</td>
			<td><textarea rows="4" name="note" cols="26"></textarea></td>
		</tr>
		<tr>
			<td colspan="2">
			<p align="center"><input type="submit" value="Aggiungi" name="B1"></td>
		</tr>
	</table>
</div>




	<p>&nbsp;</p>
</form>

</fieldset>



<?php
if (isset($_POST['submit'])) {
echo "<p>";
    while (list($key,$value) = each($_POST)){
    echo "<strong>" . $key . "</strong> = ".$value."<br />";
    }
echo "</p>";
}
?>


<script>
$(function() {
	 
	            $('#abbrev').val("");
	 
	            $("#state").autocomplete({
	                source: "state_suggest.php",
	                minLength: 2,
	                select: function(event, ui) {
	                    $('#state_id').val(ui.item.id);
	                    $('#abbrev').val(ui.item.abbrev);
	                }
	                });

	            $("#citta").autocomplete({
	                source: "citta_suggest.php",
	                minLength: 2,
	                select: function(event, ui) {
	                    $('#state_id').val(ui.item.id);
	                    $('#abbrev').val(ui.item.abbrev);
	                }


	            });
	          });
	            



        
</script>