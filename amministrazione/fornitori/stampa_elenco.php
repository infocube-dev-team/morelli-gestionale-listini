<head>
<link rel="stylesheet" type="text/css" href="../../style.css">
</head>



<link rel="stylesheet" type="text/css" href="../ajax/jquery-ui.css">
<script src="../ajax/jquery.min.js"></script>
<script src="../ajax/jquery-ui.min.js"></script>


<script type="text/javascript">
function stopRKey(evt) {
  var evt = (evt) ? evt : ((event) ? event : null);
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
  }
document.onkeypress = stopRKey;
</script>




	<fieldset> <legend class="titoli">Stampa elenco Fornitori:</legend>
	
	<form method="POST" target="_blank" action="elenco.php">
		<div align="center">
			<table border="0" cellspacing="3" id="table1">
				<tr>
					<td colspan="2" class="info" align="center"> Genera Elenco Dettagli Fornitori</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>Tipo Elemento</td>
				<td>
							<select size="1" name="tipo_lavorazione">
							<option value="greggio">Greggio</option>
							<option value="tintura">Tintura</option>
							<option value="finissaggio">Finissaggio</option>
							<option value="accoppiatura">Accoppiatura</option>
							<option value="supporti">Supporti</option>
							</select></td>
				</tr>
				<tr>
					<td>Nome Fornitore</td>
				<td>
				 <input type="text" id="fornitore" name="fornitore" size="40">
				 <input type="hidden" id="id_fornitore" name="id_fornitore" size="40">
				</td>
				
				
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>Ordina per:</td>
					<td><select size="1" name="ordine">
					<option value="cod_art_fornitore" selected>Descrizione
					</option>
					<option value="descrizione">Codice Art Fornitore</option>
					</select></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2">
					<p align="center">
					<input type="submit" value="Genera Stampa" name="B1"></td>
				</tr>
			</table>
		</div>
		<p>&nbsp;</p>
	</form>
	
	
	</fieldset>
	
	


<script>
$(function() {
      $("#fornitore").autocomplete({
        source: "fornitore_suggest.php",
        minLength: 2,
        select: function(event, ui) {
         $('#id_fornitore').val(ui.item.id);
         $('#value').val(ui.item.fornitore);
        }
       });
});
</script>