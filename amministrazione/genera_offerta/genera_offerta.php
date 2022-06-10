<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 

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
  unset($_SESSION['ragione_sociale']);
  unset($_SESSION['i']);
  unset($_SESSION['testo_libero']);
  
  $operatore = $_SESSION['utente'];
  mysql_query("DELETE FROM tmp_offerte WHERE operatore = '$operatore'");
 }

//ricavo la mail dell'operatore
if($operatore){
	
	$query="SELECT mail FROM login where login='$operatore'";
	$result=mysql_query($query);
	while($row = mysql_fetch_row($result)){
		$mail_operatore=$row[0];
		}
	
	$_SESSION['mail_operatore']=$mail_operatore;
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
		$query  = "SELECT ragione_sociale, indirizzo, citta, provincia, email FROM clienti WHERE id = '$id'";
		$result = mysql_query($query);
		if($result==FALSE){
			echo "Nessun Cliente";
		}else{
			while($row = mysql_fetch_row($result))
			{
  				$ragione_sociale = $row[0];
  				$indirizzo = $row[1];
  				$citta = $row[2];
  				$provincia = $row[3];
  				$email = $row[4];
  			}
		}
  }
  
  $_SESSION['ragione_sociale']=$ragione_sociale;
  $_SESSION['email']=$email;
  
 if($_GET['sconto']==NULL){
   $sconto = "0.00";
 }
?>






<fieldset align="center"> <legend class="titoli">Crea una Nuova Offerta</legend>


<form method="GET" action="genera_offerta.php">



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
			<input type="text" name="ragione_sociale" id="ragione_sociale" size="35" value="<?php echo $_SESSION['ragione_sociale'];?>"></td>
		</tr>
		<tr>
			<td>&nbsp;Indirizzo sede legale&nbsp;&nbsp; </td>
			<td>
			<input type="text" name="indirizzo" id="indirizzo" size="35" value="<?php echo $indirizzo;?>"></td>
		</tr>
		<tr>
			<td>&nbsp;Citta&#39;</td>
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
			<td>&nbsp;Email</td>
			<td>
			<input type="text" name="email" id="email" size="35" value="<?php echo $email;?>"></td>
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
							<td>Validita&#39;</td>
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
	    $dettagli = $_GET['dettagli'];
		$damt1=$_GET['exdamt1'];
		$damt31=$_GET['exdamt31'];
		$damt100=$_GET['exdamt100'];
		$damt200=$_GET['exdamt200'];
		$damt300=$_GET['exdamt300'];
		$damt400=$_GET['exdamt400'];
		$damt500=$_GET['exdamt500'];


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


if($_GET['sconto']>0.00){

  if($damt1>0.00){
	$mtsc1 = round(($damt1*$sconto)/100, 2);
	$da1 = $damt1-$mtsc1;
  }
  if($damt31>0.00){
	$mtsc31 = round(($damt31*$sconto)/100, 2);
	$da31 = $damt31-$mtsc31;
  }			
  if($damt100>0.00){
	$mtsc100 = round(($damt100*$sconto)/100, 2);
	$da100 = $damt100-$mtsc100;
  }
  if($damt200>0.00){
	$mtsc200 = round(($damt200*$sconto)/100, 2);
	$da200 = $damt200-$mtsc200;
  }
  if($damt300>0.00){
	$mtsc300 = round(($damt300*$sconto)/100, 2);
	$da300 = $damt300-$mtsc300;
  }
  if($damt400>0.00){
	$mtsc400 = round(($damt400*$sconto)/100, 2);
	$da400 = $damt400-$mtsc400;
  }
  if($damt500>0.00){
	$mtsc500 = round(($damt500*$sconto)/100, 2);
	$da500 = $damt500-$mtsc500;
  }

}


if($_GET['Note_ON']!="ON") $dettagli="-";

	    mysql_query("INSERT INTO tmp_offerte (operatore, articolo, sconto, da1, da31, da100, da200, da300, da400, da500, note)
	     VALUES ('$operatore', '$id_articolo', '$sconto', '$da1', '$da31', '$da100', '$da200', '$da300', '$da400', '$da500', '$dettagli')");
	   
	   $id_articolo = NULL;
	   $articolo = NULL;
	   $sconto = NULL;
	 }
	 


}
?>




<fieldset align="center"> <legend class="titoli">Dettagli Offerta:</legend>

	<div align="center">

     <form method="GET" action="genera_offerta.php">
		<table align="center" border="0" cellspacing="1"  id="table5">
			<tr>
				<td>
				<p align="right">&nbsp;Aggiungi Articolo</td>
				<td colspan="7">
				 <input type="text" name="articolo" id="articolo" size="69" value="<?php echo $articolo;?>">
				 <input type="hidden" name="id_articolo" id="nome_id" size="6" value="<?php echo $id_articolo;?>">
				</td>
			</tr>
			<tr>
				<td>
				<p align="right">Listino mt.</td>
                <?php
                /*
                <td>
				 <b><input type="checkbox" name="da500" value="ON" checked>500/--&gt;</b></td>
				<td>
				 <b> 
					<input type="checkbox" name="da400" value="ON" checked>400/499</b></td>
				<td>
					<b> 
					<input type="checkbox" name="da300" value="ON" checked>300/399</b></td>
				*/
                ?>
				<td>
					<b>
					<input type="checkbox" name="da300" value="ON" checked>300/--></b></td>
				<td>
					<b> 
					<input type="checkbox" name="da200" value="ON" checked>200/299</b></td>
				<td>
				 <b>
					<input type="checkbox" name="da100" value="ON" checked>100/199</b></td>
				<td>
					<b> 
					<input type="checkbox" name="da31" value="ON" checked>31/99</b></td>
				<td>
				 <b>
					<input type="checkbox" name="da1" value="ON" checked>1/30</b></td>
			</tr>
			<tr>
				<td>
				<p align="right">Costo Listino</td>
                <?php
                /*
                <td><input type="text" name="exdamt500" id="exdamt500" size="10" value=""></td>
				<td><input type="text" name="exdamt400" id="exdamt400" size="10" value=""></td>
				*/
                ?>
				<td><input type="text" name="exdamt300" id="exdamt300" size="10" value=""></td>
				<td><input type="text" name="exdamt200" id="exdamt200" size="10" value=""></td>
				<td><input type="text" name="exdamt100" id="exdamt100" size="10" value=""></td>
				<td><input type="text" name="exdamt31" id="exdamt31" size="10" value=""></td>
				<td><input type="text" name="exdamt1" id="exdamt1" size="10" value=""></td>	
			</tr>
			<tr>
				<td>
				<p align="right">Sconto</td>
				<td colspan="7">
				 <input type="text" name="sconto" size="6" value="<?php echo $sconto;?>">%
				</td>
			</tr>
			<tr>
				<td>
				<p align="right">
				<input type="checkbox" name="Note_ON" value="ON" checked>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
				Note</td>
				<td colspan="7">
				 <input type="text" name="dettagli" id="dettagli" size="100" value=""></td>
			</tr>
			<tr>
				<td colspan="8">
				<p align="center">
				 <input type="submit" value="Aggiungi Articolo" name="aggiungi"></td>
			</tr>
		</table>

</form>
		
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


	$queryt  = "SELECT testo_libero FROM tmp_offerte WHERE operatore = '$operatore'";
	$resultt = mysql_query($queryt);
		while($rowt = mysql_fetch_row($resultt))
		{
		 $testo = $rowt[0];
		}




			$querya  = "SELECT nome, seq_accoppiature FROM articoli WHERE id = '$id_articolo'";
			$resulta = mysql_query($querya);
				while($rowa = mysql_fetch_row($resulta))
				{
				 $articolo = $rowa[0];
				 $seq_accoppiature = $rowa[1];
				}
				
			$queryah  = "SELECT nome FROM seq_accoppiature WHERE id = '$seq_accoppiature'";
			$resultah = mysql_query($queryah);
				while($rowah = mysql_fetch_row($resultah))
				{
				 $seq_accoppiature = $rowah[0];
				}	
				
				
		
	          $num_articoli = $num_articoli+1;
	          
?>			

				<tr>
					<td bgcolor="#414751" rowspan="5"> <?php echo $num_articoli;?> </td>
					
					<td align="right">Articolo:</td>
					<td colspan="7" class="articolo"><b> <?php echo $articolo."  (".$seq_accoppiature.")";?> </b></td>
					<td rowspan="5">
					 <a href="genera_offerta.php?delist=<?php echo $id_tmp;?>"><font color="#FFFF00"> 
						Delist </font></a>
					</td>
				</tr>
				<tr>
					<td align="right">Metratura:</td>
					<?php
                    /*
					if($mt500>0){
					?>
					<td>500/--&gt;</td>
					<?php
					}
					if($mt400>0){
					?>
					<td>400/499</td>
					<?php
					}
					 if($mt300>0){
					?>
					<td>300/399</td>
					<?php
					}
                    */
                    if($mt300>0){
					?>
					<td>300/--></td>
					<?php
					}
					if($mt200>0){
					?>
					<td>200/299</td>
					<?php
					}
					if($mt100>0){
					?>
					<td>100/199</td>
					<?php
					}
					if($mt31>0){
					?>
					<td>31/99</td>
					<?php
					 }
					if($mt1>0){
					?>
					<td>1/30</td>
					<?php
					 }
					?>
					 
					
					
					

				</tr>


				<tr>
					<td align="right">Costo:</td>
					<?php
                    /*
					 if($mt500>0){
					?>
					<td bgcolor="#414751"> <b> <?php echo $mt500;?> </b> </td>
					<?php
					}
					if($mt400>0){
					?>
					<td bgcolor="#414751"> <b> <?php echo $mt400;?> </b> </td>
					<?php
					}
					*/
					if($mt300>0){
					?>
					<td bgcolor="#414751"> <b> <?php echo $mt300;?> </b> </td>
					<?php
					}
					if($mt200>0){
					?>
					<td bgcolor="#414751"> <b> <?php echo $mt200;?> </b> </td>
					<?php
					}
					 if($mt100>0){
					?>
					<td bgcolor="#414751"> <b> <?php echo $mt100;?> </b> </td>
					<?php
					}
					 if($mt31>0){
					?>
					<td bgcolor="#414751"> <b> <?php echo $mt31;?> </b> </td>
					<?php
					 }
					if($mt1>0){
					?>
					<td bgcolor="#414751"> <b> <?php echo $mt1;?> </b> </td>
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
					<td colspan="7" align="justify" class="info"> <?php echo $note;?> </td>
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


		</p>

		<form method="POST" action="frame_stampa.php">
		
			<div align="center" id="sample" class="divtext">
			
				<!-- TinyMCE -->
				<script type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js"></script>
				<script type="text/javascript">
					tinyMCE.init({
						// General options
						mode : "textareas",
						theme : "advanced",
						skin : "o2k7",
						plugins : "autolink,lists,pagebreak,style,layer,table,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",
				
						// Theme options
						theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect,forecolor,backcolor,bullist,numlist,fullscreen",
						theme_advanced_buttons2 : "tablecontrols,hr,removeformat,visualaid,iespell,advhr,ltr,rtl",
						theme_advanced_toolbar_location : "top",
						theme_advanced_toolbar_align : "left",
						theme_advanced_statusbar_location : "bottom",
						theme_advanced_resizing : true,
				
						// Example word content CSS (should be your site CSS) this one removes paragraph margins
						content_css : "css/word.css",
				
						// Drop lists for link/image/media/template dialogs
						template_external_list_url : "lists/template_list.js",
						external_link_list_url : "lists/link_list.js",
						external_image_list_url : "lists/image_list.js",
						media_external_list_url : "lists/media_list.js",
				
						// Replace values for the template plugin
						template_replace_values : {
							username : "<?php echo $_SESSION['utente'];?>",
							staffid : "<?php echo $_SESSION['utente'];?>"
						}
					});
				</script>
				<!-- /TinyMCE -->
				
				
				<?php
				 $testo_libero = $_SESSION['testo_libero'];
				?>
				<table border="0" id="table7" class="tabletext">
					<tr>
						<td align="center"> <span> <font size="2" color="#FFFFFF">Testo Libero</font> </span>  </td>
					</tr>
					<tr>
						<td><textarea value="<?php echo $_SESSION['testo_libero'];?>" rows="9" id="elm1" name="elm1" cols="117"></textarea></td>
					</tr>
					<tr>
						<td>
						<?php if($_GET['articolo']){?><p align="center"><input type="submit" value="Genera PDF" name="Genera_PDF"> <?php }?></td>
					</tr>
				</table>
			</div>
		</form>
		





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
         $('#exdamt1').val(ui.item.exdamt1);
         $('#exdamt31').val(ui.item.exdamt31);
         $('#exdamt100').val(ui.item.exdamt100);
         $('#exdamt200').val(ui.item.exdamt200);
         $('#exdamt300').val(ui.item.exdamt300);
         $('#exdamt400').val(ui.item.exdamt400);
         $('#exdamt500').val(ui.item.exdamt500);
		 $('#dettagli').val(ui.item.dettagli);
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
         $('#email').val(ui.item.email);

        }
       });

});
</script>
