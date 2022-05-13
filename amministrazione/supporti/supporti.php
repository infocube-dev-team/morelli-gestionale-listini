<head>
<link rel="stylesheet" type="text/css" href="../../style.css">
</head>

<?php
session_start();
?>

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



<?php
if($_GET['crea']!=NULL){
 $nome = $_GET['nome'];
 $cod_art_fornitore = $_GET['cod_art_fornitore'];
 $fornitore= $_GET['fornitore'];
 $id_fornitore= $_GET['id_fornitore'];
 $m1 = $_GET['m1'];
 $m2 = $_GET['m2'];
 $m3 = $_GET['m3'];
 $m4 = $_GET['m4'];
 $m5 = $_GET['m5'];
 $m6 = $_GET['m6'];
 $m7 = $_GET['m7'];
 $m8 = $_GET['m8'];
 $c1 = $_GET['c1'];
 $c2 = $_GET['c2'];
 $c3 = $_GET['c3'];
 $c4 = $_GET['c4'];
 $c5 = $_GET['c5'];
 $c6 = $_GET['c6'];
 $c7 = $_GET['c7'];
 $c8 = $_GET['c8'];

 include("supporti_add.php");
}



if($m1==NULL){
 $m1 = "0/0";
}
if($m2==NULL){
 $m2 = "0/0";
}
if($m3==NULL){
 $m3 = "0/0";
}
if($m4==NULL){
 $m4 = "0/0";
}
if($m5==NULL){
 $m5 = "0/0";
}
if($m6==NULL){
 $m6 = "0/0";
}
if($m7==NULL){
 $m7 = "0/0";
}
if($m8==NULL){
 $m8 = "0/0";
}

if($c1==NULL){
 $c1 = "0.00";
}
if($c2==NULL){
 $c2 = "0.00";
}
if($c3==NULL){
 $c3 = "0.00";
}
if($c4==NULL){
 $c4 = "0.00";
}
if($c5==NULL){
 $c5 = "0.00";
}
if($c6==NULL){
 $c6 = "0.00";
}
if($c7==NULL){
 $c7 = "0.00";
}
if($c8==NULL){
 $c8 = "0.00";
}
?>


			   <fieldset align="center"> <legend class="titoli">Crea un Elemento Supporti:</legend>
			   
			   <form method="GET" action="supporti.php">
			   
				<div align="center">
					<table border="0" cellspacing="0" id="table5">
						
						<tr>
							<td colspan="9">&nbsp;</td>
						</tr>

						<tr>
							<td>&nbsp;Nome Supporti:</td>
							<td colspan="8">
							 <input type="text" name="nome" size="48" id="nome" value="<?php echo $nome;?>">
							</td>
						</tr>
						<tr>
							<td>&nbsp;Codice Art. Fornitore&nbsp;&nbsp; </td>
							<td colspan="8">
							 <input type="text" name="cod_art_fornitore" size="48" id="cod_art_fornitore" value="<?php echo $cod_art_fornitore;?>"></td>
						</tr>
						<tr>
							<td>&nbsp;Fornitore:</td>
							<td colspan="8">
							 <input type="text" name="fornitore" size="36" id="fornitore" value="<?php echo $fornitore;?>">
							 <input type="hidden" name="id_fornitore" size="36" id="id_fornitore" value="<?php echo $fornitore;?>">
							</td>
						</tr>
						<tr>
							<td>&nbsp;Metratura (mt.):</td>
							<td>
							 <input type="text" name="m1" size="7" id="m1" value="<?php echo $m1;?>">
							</td>
							<td>
							 <input type="text" name="m2" size="7" id="m2" value="<?php echo $m2;?>">
							</td>
							<td>
							 <input type="text" name="m3" size="7" id="m3" value="<?php echo $m3;?>">
							</td>
							<td>
							 <input type="text" name="m4" size="7" id="m4" value="<?php echo $m4;?>">
							</td>
							<td>
							 <input type="text" name="m5" size="7" id="m5" value="<?php echo $m5;?>">
							</td>
							<td>
							 <input type="text" name="m6" size="7" id="m6" value="<?php echo $m6;?>">
							 </td>
							<td>
							 <input type="text" name="m7" size="7" id="m7" value="<?php echo $m7;?>">
							 </td>
							<td>
							 <input type="text" name="m8" size="7" id="m8" value="<?php echo $m8;?>">
							</td>
						</tr>
						<tr>
							<td>&nbsp;Costo (Euro):</td>
							<td>
							 <input type="text" name="c1" size="7" id="c1" value="<?php echo $c1;?>">
							</td>
							<td>
							 <input type="text" name="c2" size="7" id="c2" value="<?php echo $c2;?>">
							</td>
							<td>
							 <input type="text" name="c3" size="7" id="c3" value="<?php echo $c3;?>">
							</td>
							<td>
							 <input type="text" name="c4" size="7" id="c4" value="<?php echo $c4;?>">
							</td>
							<td>
							 <input type="text" name="c5" size="7" id="c5" value="<?php echo $c5;?>">
							</td>
							<td>
							 <input type="text" name="c6" size="7" id="c6" value="<?php echo $c6;?>">
							</td>
							<td>
							 <input type="text" name="c7" size="7" id="c7" value="<?php echo $c7;?>">
							 </td>
							<td>
							 <input type="text" name="c8" size="7" id="c8" value="<?php echo $c8;?>">
							</td>
						</tr>
						<tr>
							<td colspan="9">
							<p align="center">

							 <input type="submit" value="Crea" name="crea"></td>
						</tr>
					</table>
				</div>
				
				
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
        source: "nome_suggest.php",
        minLength: 2,
        select: function(event, ui) {
         $('#id').val(ui.item.id);
         $('#value').val(ui.item.nome);
        }
       });

      $("#cod_art_fornitore").autocomplete({
        source: "cod_art_suggest.php",
        minLength: 2,
        select: function(event, ui) {
         $('#id').val(ui.item.id);
         $('#value').val(ui.item.cod_art_fornitore);
        }
       });
       
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


<br>
<br>

<p><font color="<?php echo $color;?>"><?php echo $_SESSION['messaggio'];?></font></p>





<?php
 $_SESSION['messaggio'] = NULL;
?>