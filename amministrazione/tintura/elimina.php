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





			   <fieldset align="center"> <legend class="titoli">Elimina un Elemento Tintura:</legend>
			   
			   <form method="GET" action="elimina.php">
			   
				<div align="center">
					<table border="0" cellspacing="0" id="table5">
						
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>

						<tr>
							<td>&nbsp;Nome Tintura:</td>
							<td>
							 <input type="hidden" name="id" size="36" id="id" value="<?php echo $id;?>">
							 <input type="text" name="nome" size="48" id="nome" value="<?php echo $nome;?>">
							</td>
						</tr>
						<tr>
							<td>&nbsp;Codice Art. Fornitore&nbsp;&nbsp; </td>
							<td>
							 <input disabled type="text" name="cod_art_fornitore" size="48" id="cod_art_fornitore" value="<?php echo $cod_art_fornitore;?>"></td>
						</tr>
						<tr>
							<td>&nbsp;Fornitore:</td>
							<td>
							 <input disabled type="text" name="fornitore" size="36" id="fornitore" value="<?php echo $fornitore;?>">
							</td>
						</tr>
						<tr>
							<td colspan="2">
							<p align="center">

							 <input type="submit" value="Elimina" name="elimina"></td>
						</tr>
					</table>
				</div>
				
				
				</form>





<?php
if($_GET['elimina']!=NULL AND $_GET['id']!=NULL){
 $id = $_GET['id'];


 include("tintura_erase.php");
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
 $c1 = "0/0";
}
if($c2==NULL){
 $c2 = "0/0";
}
if($c3==NULL){
 $c3 = "0/0";
}
if($c4==NULL){
 $c4 = "0/0";
}
if($c5==NULL){
 $c5 = "0/0";
}
if($c6==NULL){
 $c6 = "0/0";
}
if($c7==NULL){
 $c7 = "0/0";
}
if($c8==NULL){
 $c8 = "0/0";
}
?>



				
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
        source: "nome_suggest_modifica.php",
        minLength: 2,
        select: function(event, ui) {
         $('#id').val(ui.item.id);
         $('#value').val(ui.item.nome);
         $('#cod_art_fornitore').val(ui.item.cod_art_fornitore);
         $('#id_fornitore').val(ui.item.id_fornitore);
         $('#fornitore').val(ui.item.fornitore);
         $('#m1').val(ui.item.m1);
         $('#m2').val(ui.item.m2);
         $('#m3').val(ui.item.m3);
         $('#m4').val(ui.item.m4);
         $('#m5').val(ui.item.m5);
         $('#m6').val(ui.item.m6);
         $('#m7').val(ui.item.m7);
         $('#m8').val(ui.item.m8);
         $('#c1').val(ui.item.c1);
         $('#c2').val(ui.item.c2);
         $('#c3').val(ui.item.c3);
         $('#c4').val(ui.item.c4);
         $('#c5').val(ui.item.c5);
         $('#c6').val(ui.item.c6);
         $('#c7').val(ui.item.c7);
         $('#c8').val(ui.item.c8);
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