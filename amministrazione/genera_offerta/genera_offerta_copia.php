<head>
<link rel="stylesheet" type="text/css" href="../../style.css">
<link rel="stylesheet" type="text/css" href="../ajax/jquery-ui.css">
<script src="../ajax/jquery.min.js"></script>
<script src="../ajax/jquery-ui.min.js"></script>
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
session_start();
date_default_timezone_set('Europe/Rome');


include("cat.php");
//--------------------Seleziona Articolo dal Database-------------------
$con = mysql_connect($localhost.":".$localporta,$locallogin,$localpass);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
   }
 mysql_select_db($localnome, $con);



//-----Resetta tutto all accesso di una nuova offerta---------
 if($_GET['reset']=="SI"){
  unset($_SESSION['ragione_sociale_id']);
  unset($_SESSION['data']);
  unset($_SESSION['validita']);
  unset($_SESSION['tipo_validita']);
  unset($_SESSION['note']);
  
  $operatore = $_SESSION['utente'];
  mysql_query("DELETE FROM tmp_offerte WHERE operatore = '$operatore'");
 }



 if($_GET['ragione_sociale_id']!=NULL){
  $_SESSION['ragione_sociale_id'] = $_GET['ragione_sociale_id'];
  $_SESSION['data'] = $_GET['data'];
  $_SESSION['validita'] = $_GET['validita'];
  $_SESSION['tipo_validita'] = $_GET['tipo_validita'];
 }


 if(!isset($_SESSION['data'])){
  $_SESSION['data'] = date('d/m/Y  H:i');
  $_SESSION['validita'] = 30;
  $_SESSION['tipo_validita'] = 'giorni';
 }



 //-------------Delista un articolo------------
 if($_GET['delist']>0){
  $id_tmp = $_GET['delist'];
  mysql_query("DELETE FROM tmp_offerte WHERE id = '$id_tmp'"); 
 }
 
 
 
 if(isset($_SESSION['ragione_sociale_id'])){
		//------------Seleziona cliente------------
	$id = $_SESSION['ragione_sociale_id'];
		$query  = "SELECT ragione_sociale, indirizzo, citta, provincia FROM clienti WHERE id = '$id'";
		$result = mysql_query($query);
			while($row = mysql_fetch_row($result))
			{
  				$ragione_sociale = $row[0];
  				$indirizzo = $row[1];
  				$citta = $row[2];
  				$provincia = $row[3];
  			}
  }

 if($_GET['sconto']==NULL){
   $sconto = "0.00";
 }
?>






<fieldset align="center"> <legend class="titoli">Crea una Nuova Offerta</legend>


<form method="GET" action="genera_offerta_copia.php">



<div align="center">
	&nbsp;<div align="center">
		<table border="1" cellspacing="10" id="table2">
			<tr>
				<td>
	<table border="0" cellspacing="1" cellpadding="2" id="table3">
		<tr>
			<td colspan="2">
			<p align="center"><b>Cliente</b></td>
		</tr>
		<tr>
			<td>&nbsp;Ragione Sociale</td>
			<td>
			<input type="text" name="ragione_sociale" id="ragione_sociale" size="35" value="<?php echo $ragione_sociale;?>"></td>
		</tr>
		<tr>
			<td>&nbsp;Indirizzo sede legale&nbsp;&nbsp; </td>
			<td>
			<input type="text" name="indirizzo" id="indirizzo" size="35" value="<?php echo $indirizzo;?>"></td>
		</tr>
		<tr>
			<td>&nbsp;Citta'</td>
			<td>
			<input type="text" name="citta" id="citta" size="13" value="<?php echo $citta;?>"></td>
		</tr>
		<tr>
			<td>&nbsp;Provincia</td>
			<td>
			<input type="text" name="provincia" id="provincia" size="13" value="<?php echo $provincia;?>">
			  <input type="hidden" name="ragione_sociale_id" id="ragione_sociale_id" size="5"></td>
		</tr>
		<tr>
			<td colspan="2">
			<p align="center">&nbsp;</td>
		</tr>
	</table>
				</td>
				<td>
				<div align="center">
					<table border="0" cellspacing="1" cellpadding="2" id="table4">

						<tr>
							<td>Data/Ora</td>
							<td>
							<input type="text" name="data" size="17" value="<?php echo $_SESSION['data'];?>"></td>
						</tr>
						<tr>
							<td>Validita'</td>
							<td>
							<input type="text" name="validita" size="6" value="<?php echo $_SESSION['validita'];?>"><select size="1" name="tipo_validita">
							<option selected value="giorni">Giorni</option>
							<option value="Mesi">Mesi</option>
							<option value="anni">Anni</option>
							</select></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>Operatore</td>
							<td> 
							  <b> <font color="#00FF00"> <?php echo strtoupper($_SESSION['utente']);?></font> </b> 
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						</table>
				</div>
				</td>
			</tr>
			<tr>
				<td colspan="2">
				<p align="center">
				<input type="submit" value="Conferma" name="B1"></td>
			</tr>
		</table>
	</div>
</div>




	<p>&nbsp;</p>
</form>

</fieldset>








<?php
  //-----Controllo se fatto un submit di un articolo-------------
if($_SESSION['ragione_sociale_id']){

	if($_GET['aggiungi']){
	  if($_GET['id_articolo']!=NULL){
	    $id_articolo = $_GET['id_articolo'];
	  }
	  if($_GET['articolo']!=NULL){
	    $articolo = $_GET['articolo'];
	  }
	  if($_GET['sconto']!=NULL){
	    $sconto = $_GET['sconto'];
	  }
	  
	 //--------------Se tutti i dati sono compilati, inserisci in temp---------------
	 if($id_articolo!=NULL && $articolo!=NULL){
	  $operatore = $_SESSION['utente'];
	  $note = $_GET['note'];


	          //-----rileva il prezzo--------
			$queryah  = "SELECT 1mt, 31mt, 100mt, 200mt, 300mt, 400mt, 500mt FROM listino WHERE id_articolo = '$id_articolo'";
			$resultah = mysql_query($queryah);
				while($rowah = mysql_fetch_row($resultah))
				{
				 $damt1 = $rowah[0];
				 $damt31 = $rowah[1];
				 $damt100 = $rowah[2];
				 $damt200 = $rowah[3];
				 $damt300 = $rowah[4];
				 $damt400 = $rowah[5];
				 $damt500 = $rowah[6];
				}


		  if($_GET['da1']!="ON"){
		    $da1 = "0.00";
		  }else{
		    $da1 = $damt1;
		  }
		  
		  if($_GET['da31']!="ON"){
		    $da31 = "0.00";
		  }else{
		    $da31 = $damt31;
		  }

		  if($_GET['da100']!="ON"){
		    $da100 = "0.00";
		  }else{
		    $da100 = $damt100;
		  }

		  if($_GET['da200']!="ON"){
		    $da200 = "0.00";
		  }else{
		    $da200 = $damt200;
		  }

		  if($_GET['da300']!="ON"){
		    $da300 = "0.00";
		  }else{
		    $da300 = $damt300;
		  }

		  if($_GET['da400']!="ON"){
		    $da400 = "0.00";
		  }else{
		    $da400 = $damt400;
		  }

		  if($_GET['da500']!="ON"){
		    $da500 = "0.00";
		  }else{
		    $da500 = $damt500;
		  }

	    mysql_query("INSERT INTO tmp_offerte (operatore, articolo, sconto, da1, da31, da100, da200, da300, da400, da500, note)
	     VALUES ('$operatore', '$id_articolo', '$sconto', '$da1', '$da31', '$da100', '$da200', '$da300', '$da400', '$da500', '$note')");
	   
	   $id_articolo = NULL;
	   $articolo = NULL;
	   $sconto = NULL;
	 }
}
?>




<fieldset align="center"> <legend class="titoli">Dettagli Offerta:</legend>
<form method="GET" action="genera_offerta_copia.php">
	<div align="center">
		<table border="0" cellspacing="1"  id="table5">
			<tr>
				<td>
				<p align="right">&nbsp;Aggiungi Articolo</td>
				<td>
				 <input type="text" name="articolo" id="articolo" size="69" value="<?php echo $articolo;?>">
				 <input type="hidden" name="id_articolo" id="nome_id" size="6" value="<?php echo $id_articolo;?>">
				</td>
				<td>
				</td>
			</tr>
			<tr>
				<td>
				<p align="right">Listino mt.</td>
				<td>
				 <b><input type="checkbox" name="da1"   value="ON" checked>1/30 &nbsp;&nbsp; 
					<input type="checkbox" name="da31"  value="ON" checked>31/99</b> <b>&nbsp; 
					<input type="checkbox" name="da100" value="ON" checked>100/199</b> <b>&nbsp; 
					<input type="checkbox" name="da200" value="ON" checked>200/299 </b>&nbsp;<b>
					<input type="checkbox" name="da300" value="ON" checked>300/399</b> <b>&nbsp; 
					<input type="checkbox" name="da400" value="ON" checked>400/499 </b>&nbsp;<b>
					<input type="checkbox" name="da500" value="ON" checked>500/--&gt;</b></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>
				<p align="right">Sconto</td>
				<td>
				 <input type="text" name="sconto" size="6" value="<?php echo $sconto;?>">%
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>
				<p align="right">Note</td>
				<td>
				 <textarea rows="4" name="note" cols="83"></textarea></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td colspan="3">
				<p align="center">
				 <input type="submit" value="Aggiungi Articolo" name="aggiungi"></td>
			</tr>
		</table>
		
		
		<br>
		<br>

		
		

		<div align="center">
			<table border="0" cellspacing="2" cellpadding="2" id="table6" width="600">
<?php
 //----Seleziona articoli in elaborazione------------
  $operatore = $_SESSION['utente'];
  $num_articoli = 0;
	$query  = "SELECT id, articolo, sconto, da1, da31, da100, da200, da300, da400, da500, note FROM tmp_offerte WHERE operatore = '$operatore'";
	$result = mysql_query($query);
		while($row = mysql_fetch_row($result))
		{
		 $id_tmp = $row[0];
		 $id_articolo = $row[1];
		 $sconto = $row[2];
		 $mt1 = $row[3];
		 $mt31 = $row[4];
		 $mt100 = $row[5];
		 $mt200 = $row[6];
		 $mt300 = $row[7];
		 $mt400 = $row[8];
		 $mt500 = $row[9];
		 $note = $row[10];

			$querya  = "SELECT nome FROM articoli WHERE id = '$id_articolo'";
			$resulta = mysql_query($querya);
				while($rowa = mysql_fetch_row($resulta))
				{
				 $articolo = $rowa[0];
				}
		
	          $num_articoli = $num_articoli+1;
?>			

				<tr>
					<td bgcolor="#414751" rowspan="6"> <?php echo $num_articoli;?> </td>
					
					<td align="right">Articolo:</td>
					<td colspan="7"><b> <?php echo $articolo;?> </b></td>
					<td rowspan="6">
					 <a href="genera_offerta_copia.php?delist=<?php echo $id_tmp;?>"><font color="#FFFF00"> Delist </font></a>
					</td>
				</tr>
				<tr>
					<td align="right">Metratura:</td>
					<?php
					 if($mt1>0){
					?>
					<td>1/30</td>
					<?php
					 }
					 if($mt31>0){
					?>
					<td>31/99</td>
					<?php
					 }
					 if($mt100>0){
					?>
					<td>100/199</td>
					<?php
					}
					if($mt200>0){
					?>
					<td>200/299</td>
					<?php
					}
					if($mt300>0){
					?>
					<td>300/399</td>
					<?php
					}
					if($mt400>0){
					?>
					<td>400/499</td>
					<?php
					}
					if($mt500>0){
					?>
					<td>500/--&gt;</td>
					<?php
					}
					?>
				</tr>
				<tr>
					<td align="right">Costo_Listino:</td>
					<?php
					 if($mt1>0){
					?>
					<td bgcolor="#414751"> <b> <?php echo $mt1;?> </b> </td>
					<?php
					 }
					 if($mt31>0){
					?>
					<td bgcolor="#414751"> <b> <?php echo $mt31;?> </b> </td>
					<?php
					 }
					 if($mt100>0){
					?>
					<td bgcolor="#414751"> <b> <?php echo $mt100;?> </b> </td>
					<?php
					}
					if($mt200>0){
					?>
					<td bgcolor="#414751"> <b> <?php echo $mt200;?> </b> </td>
					<?php
					}
					if($mt300>0){
					?>
					<td bgcolor="#414751"> <b> <?php echo $mt300;?> </b> </td>
					<?php
					}
					if($mt400>0){
					?>
					<td bgcolor="#414751"> <b> <?php echo $mt400;?> </b> </td>
					<?php
					}
					if($mt500>0){
					?>
					<td bgcolor="#414751"> <b> <?php echo $mt500;?> </b> </td>
					<?php
					}
					?>
				</tr>


<?php
				//---------arrotondamento----------
				// ricavo la parte decimale
//				$intpart = floor($c1list);
//				$dec = $c1list-$intpart;

				for($i=0;$i<7;$i++){
					${"intpart$i"} = floor(${"c$i"."listf"});
					${"dec$i"} = ${"c$i"."listf"}-${"intpart$i"};
				}

				$arr1=0.15;
				$arr2=0.35;
				$arr3=0.55;
				$arr4=0.75;
				$arr5=0.95;
				$arr6=0.99;

				$n=1;				
				if($attiva_1==1){ $n=0;};
				
				for($n;$n<7;$n++){
					for($i=1;$i<7;$i++){
						$j=$i+1;
						if(${"dec$n"} > ${"arr$i"} && ${"dec$n"} <= ${"arr$j"}){
							${"dec$n"}=${"arr$j"};
						}elseif(${"dec$n"}<$arr1)
							${"dec$n"}=$arr1;

						${"c$n"."listf"} = ${"intpart$n"} + ${"dec$n"};
					}
				}

?>

				<tr>
					<td align="right">Costo_Scontato:</td>
					<?php
					 if($mt1>0){
					  $mtsc1 = round(($mt1*$sconto)/100, 2);
					?>
					<td bgcolor="#414751"> <b> <?php echo $mt1-$mtsc1;?> </b> </td>
					<?php
					 }
					 if($mt31>0){
					  $mtsc31 = round(($mt31*$sconto)/100, 2);
					?>
					<td bgcolor="#414751"> <b> <?php echo $mt31-$mtsc31;?> </b> </td>
					<?php
					 }
					 if($mt100>0){
					  $mtsc100 = round(($mt100*$sconto)/100, 2);
					?>
					<td bgcolor="#414751"> <b> <?php echo $mt100-$mtsc100;?> </b> </td>
					<?php
					}
					if($mt200>0){
					 $mtsc200 = round(($mt200*$sconto)/100, 2);
					?>
					<td bgcolor="#414751"> <b> <?php echo $mt200-$mtsc200;?> </b> </td>
					<?php
					}
					if($mt300>0){
					 $mtsc300 = round(($mt300*$sconto)/100, 2);
					?>
					<td bgcolor="#414751"> <b> <?php echo $mt300-$mtsc300;?> </b> </td>
					<?php
					}
					if($mt400>0){
					 $mtsc400 = round(($mt400*$sconto)/100, 2);
					?>
					<td bgcolor="#414751"> <b> <?php echo $mt400-$mtsc400;?> </b> </td>
					<?php
					}
					if($mt500>0){
					 $mtsc500 = round(($mt500*$sconto)/100, 2);
					?>
					<td bgcolor="#414751"> <b> <?php echo $mt500-$mtsc500;?> </b> </td>
					<?php
					}
					?>
				</tr>

				<tr>
					<td align="right">Sconto %:</td>
					<td colspan="7"><b> <?php echo $sconto;?>  </b></td>
				</tr>
				<tr>
					<td align="right">Note:</td>
					<td colspan="7" align="justify"> <?php echo $note;?> </td>
				</tr>
				<tr>
					<td colspan="10"><hr></td>
				</tr>
<?php
		}
?>
			</table>
		</div>


		
		
		
		
		<br>
		<br>
		
	  </div>
	<input type="submit" value="Genera PDF" name="B2" style="float: left">
</form>
<p>&nbsp;</p>


</fieldset>

<?php
 }
?>


<?php
 mysql_close($con);



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

      $("#articolo").autocomplete({
        source: "articoli_suggest.php",
        minLength: 2,
        select: function(event, ui) {
         $('#nome_id').val(ui.item.id);
         $('#value').val(ui.item.nome);
        }
       });

      $("#ragione_sociale").autocomplete({
        source: "cliente_suggest.php",
        minLength: 2,
        select: function(event, ui) {
         $('#ragione_sociale_id').val(ui.item.id);
         $('#value').val(ui.item.ragione_sociale);
         $('#indirizzo').val(ui.item.indirizzo);
         $('#citta').val(ui.item.citta);
         $('#provincia').val(ui.item.provincia);
        }
       });

});
</script>