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





			   <fieldset align="center"> <legend class="titoli">Elimina un 
				Articolo:</legend>
			   
			   <form method="GET" action="elimina_articolo.php">
			   
				<div align="center">
					<table border="0" cellspacing="0" id="table5">
						
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>

						<tr>
							<td>&nbsp;Nome Articolo:</td>
							<td>
							 <input type="hidden" name="id" size="36" id="id" value="<?php echo $id;?>">
							 <input type="text" name="nome" size="48" id="nome" value="<?php echo $nome;?>">
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


 include("articolo_erase.php");
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
 $_SESSION['messaggio'] = NULL;
?>