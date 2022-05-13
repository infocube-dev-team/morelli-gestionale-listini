<head>
<link rel="stylesheet" type="text/css" href="../../style.css">
</head>


<script type="text/javascript">
function stopRKey(evt) {
  var evt = (evt) ? evt : ((event) ? event : null);
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
  }
document.onkeypress = stopRKey;
</script>


<?php
if($_GET['crea']!=NULL){
 $nome = $_GET['nome'];
 $codice = $_GET['codice'];
 $collezione = $_GET['collezione'];
 $composizione = $_GET['composizione'];
 $altezza = $_GET['altezza'];
 $dettagli = $_GET['dettagli'];
 $grmq = $_GET['grmq'];
 $seq_accoppiature = $_GET['seq_accoppiature'];

 include("nuovo_articolo_add.php");
}


include("cat.php");
//--------------------Seleziona Articolo dal Database-------------------
$con = mysql_connect($localhost.":".$localporta,$locallogin,$localpass);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
   }
 mysql_select_db($localnome, $con);
?>



<link rel="stylesheet" type="text/css" href="../ajax/jquery-ui.css">
<script src="../ajax/jquery.min.js"></script>
<script src="../ajax/jquery-ui.min.js"></script>
</head>



				 <fieldset> <legend class="titoli">Crea Nuovo Articolo</legend>
				 
				<form method="GET" action="nuovo_articolo.php">
	
				  <div align="center">
					<table border="0" cellspacing="0" id="table4">
						<tr>
							<td>Nome Articolo:</td>
							<td colspan="2">
							
							<input type="text" name="nome" size="76" id="nome" value="<?php echo $nome;?>"></td>
						</tr>
						<tr>
							<td>Codice Articolo:</td>
							<td>
							<input type="text" name="codice" size="19" id="codice" value="<?php echo $codice;?>"></td>
							<td rowspan="6">
							<textarea rows="5" name="dettagli" cols="29"><?php echo $dettagli;?></textarea>Note</td>
						</tr>
						<tr>
							<td>Collezione:</td>
							<td>
							<input type="text" name="collezione" size="19" id="collezione" value="<?php echo $collezione;?>"></td>
						</tr>
						<tr>
							<td>Composizione:</td>
							<td>
							<input type="text" name="composizione" size="19" id="composizione" value="<?php echo $composizione;?>"></td>
						</tr>
						<tr>
							<td>Gr.Mq.:</td>
							<td>
							<input type="text" name="grmq" size="7" id="altezza0" value="<?php echo $grmq;?>"></td>
						</tr>
						<tr>
							<td>Altezza&nbsp; (cm):</td>
							<td>
							<input type="text" name="altezza" size="7" id="altezza" value="<?php echo $altezza;?>"></td>
						</tr>
						<tr>
							<td>Seq. Accoppiature</td>
							<td>
							<select size="1" name="seq_accoppiature">
							
							 <option selected><?php echo null;?></option>
							
							<?php
							//------------Seleziona sequenza accoppiatura------------
							$query  = "SELECT nome, ordine FROM seq_accoppiature ORDER BY ordine";
							$result = mysql_query($query);
								while($row = mysql_fetch_row($result))
								{
									$nome_seq = $row[0];
									$ordine_seq = $row[1];
									
								if($seq_accoppiature==$ordine_seq){
								 $selected = "Selected";
								}else{
								 $selected = NULL;
								}
							?>
							 <option <?php echo $selected;?> value="<?php echo $ordine_seq;?>"> <?php echo $nome_seq;?> </option>
							<?php
								}
							?>

							</select>
							</td>
							
						</tr>
						<tr>
							<td colspan="3">
							<p align="center">
							<input type="submit" value="Crea" name="crea"></td>
						</tr>
						</table>
				   </div>


				 </form>
				 </fieldset>



<script>
$(function() {
      $("#nome").autocomplete({
        source: "articoli_suggest.php",
        minLength: 2,
        select: function(event, ui) {
         $('#id').val(ui.item.id);
         $('#value').val(ui.item.nome);
        }
       });

});
</script>

<br>
<br>

<p><font color="<?php echo $color;?>"><?php echo $_SESSION['messaggio'];?></font></p>


<?php
 mysql_close($con);
 
 $_SESSION['messaggio'] = NULL;
?>