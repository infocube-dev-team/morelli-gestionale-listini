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
session_start();
$operatore = $_SESSION['utente'];
$data = date('Y-m-d H:i:s');


$id = $_GET['id'];


unset($_SESSION['check_fornitore']);


if($id==NULL){
 header("location: seleziona_articolo.php");
}


include("cat.php");
//--------------------Seleziona Articolo dal Database-------------------
$con = mysql_connect($localhost.":".$localporta,$locallogin,$localpass);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
   }
 mysql_select_db($localnome, $con);



//---------------Modifica Articolo-----------------
$modifica_articolo = $_GET['Modifica_Articolo'];
 if(isset($modifica_articolo)){

  $nome = $_GET['nome'];
  $codice = $_GET['codice'];
  $collezione = $_GET['collezione'];
  $composizione = $_GET['composizione'];
  $altezza = $_GET['altezza'];
  $altezza = str_replace(",", ".", $altezza);
  $stampa = $_GET['stampa'];
  $dettagli = $_GET['dettagli'];
  $grmq = $_GET['grmq'];


if($grmq==NULL){
 $grmq = "0";
}

if($altezza==NULL){
 $altezza = "0";
}

   $query = "UPDATE articoli SET codice='$codice', collezione='$collezione', composizione='$composizione', altezza='$altezza', stampa='$stampa', operatore='$operatore', data='$data', dettagli='$dettagli', grmq='$grmq' WHERE id='$id'";
 	$result = mysql_query($query);

  if($nome!=NULL){
   $query = "UPDATE articoli SET nome='$nome' WHERE id='$id'";
 	$result = mysql_query($query);
  }
 }



		//------------Seleziona articolo------------
		$query  = "SELECT codice, nome, collezione, composizione, altezza, stampa, dettagli, grmq FROM articoli WHERE id = '$id'";
		$result = mysql_query($query);
			while($row = mysql_fetch_row($result))
			{
				$codice = $row[0];
				$nome = $row[1];
				$collezione = $row[2];
				$composizione = $row[3];
				$altezza = $row[4];
				$stampa = $row[5];
				$dettagli = $row[6];
				$grmq = $row[7];
			}

$seleziona = $_GET['Seleziona'];
$aggiungi_elemento = $_GET['Aggiungi_elemento'];
$modifica_elemento = $_GET['Modifica_elemento'];
$modifica = $_GET['Modifica'];
$tipo_lavorazione = $_GET['tipo_lavorazione'];
$id_modifica = $_GET['id_modifica'];
$vocestato = $_GET['vocestato'];
$delist = $_GET['delist'];


//-----------------Seleziona tipo di elemento-----------------
if($tipo_lavorazione=="greggio"){
 $suggest = "oggetto_greggio_suggest.php";
}
if($tipo_lavorazione=="accoppiatura"){
 $suggest = "oggetto_accoppiatura_suggest.php";
}
if($tipo_lavorazione=="tintura"){
 $suggest = "oggetto_tintura_suggest.php";
}
if($tipo_lavorazione=="supporti"){
 $suggest = "oggetto_supporti_suggest.php";
}
if($tipo_lavorazione=="finissaggio"){
 $suggest = "oggetto_finissaggio_suggest.php";
}



//---------------------Apri elenco oggetti---------------
if(isset($_GET['elenco'])){
 $_SESSION['fornitore'] = $_GET['fornitore'];
 $seleziona = "Seleziona";

	if($_GET['tipo_lavorazione']==NULL){
	 $tipo_lavorazione = $_SESSION['tipo_lavorazione'];
	}

?>

<script>
	window.open('pop.php?tipo_lavorazione=<?php echo $tipo_lavorazione;?>','popup','width=500,height=500,scrollbars=yes,resizable=no,toolbar=no,directories=no,location=no,menubar=no,status=no,left=200,top=200');
</script>

<?php
}




//-----------------Inserisci nuovi elementi---------------------
if(isset($_GET['id_elemento'])){
 $id_elemento = $_GET['id_elemento'];
 $tipo_lav = $_GET['tipo_lav'];
 $calo = $_GET['calo'];
}

if($aggiungi_elemento!=NULL AND $id_elemento!=NULL){

 if($tipo_lav=="greggio"){
  mysql_query("INSERT INTO combinazioni (id_articolo, id_greggio, stato, calo_greggio)
   VALUES ('$id', '$id_elemento', 'ON', '$calo')");

    $query = "UPDATE articoli SET data='$data', operatore='$operatore' WHERE id='$id'";
   $result = mysql_query($query);
 }

 if($tipo_lav=="tintura"){
  mysql_query("INSERT INTO combinazioni (id_articolo, id_tintura, stato, calo_tintura)
   VALUES ('$id', '$id_elemento', 'ON', '$calo')");

    $query = "UPDATE articoli SET data='$data', operatore='$operatore' WHERE id='$id'";
   $result = mysql_query($query);
 }

 if($tipo_lav=="finissaggio"){
  mysql_query("INSERT INTO combinazioni (id_articolo, id_finissaggio, stato, calo_finissaggio)
   VALUES ('$id', '$id_elemento', 'ON', '$calo')");

    $query = "UPDATE articoli SET data='$data', operatore='$operatore' WHERE id='$id'";
   $result = mysql_query($query);
 }

 if($tipo_lav=="accoppiatura"){
  mysql_query("INSERT INTO combinazioni (id_articolo, id_accoppiatura, stato, calo_accoppiatura)
   VALUES ('$id', '$id_elemento', 'ON', '$calo')");

    $query = "UPDATE articoli SET data='$data', operatore='$operatore' WHERE id='$id'";
   $result = mysql_query($query);
 }

 if($tipo_lav=="supporti"){
  mysql_query("INSERT INTO combinazioni (id_articolo, id_supporti, stato, calo_supporti)
   VALUES ('$id', '$id_elemento', 'ON', '$calo')");

    $query = "UPDATE articoli SET data='$data', operatore='$operatore' WHERE id='$id'";
   $result = mysql_query($query);
 }

}



//--------------------------Modifica Elementi--------------------
  if(isset($_GET['id_mod_elemento'])){
   $id_mod_elemento = $_GET['id_mod_elemento'];
  }else{
   $id_mod_elemento = $_GET['id_modifica'];
  }

if(isset($modifica_elemento)){
 $tipo_lav = $_GET['tipo_lav'];

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
 $calo = $_GET['calo'];

 if($tipo_lav=="greggio"){
   $query = "UPDATE greggio SET m1='$m1', m2='$m2', m3='$m3', m4='$m4', m5='$m5', m6='$m6', m7='$m7', m8='$m8', c1='$c1', c2='$c2', c3='$c3', c4='$c4', c5='$c5', c6='$c6', c7='$c7', c8='$c8' WHERE id='$id_mod_elemento'";
	$result = mysql_query($query);
   $query = "UPDATE combinazioni SET calo_greggio='$calo' WHERE id_greggio='$id_mod_elemento' AND id_articolo='$id'";
 	$result = mysql_query($query);

    $query = "UPDATE articoli SET data='$data', operatore='$operatore' WHERE id='$id'";
   $result = mysql_query($query);
 }
 if($tipo_lav=="tintura"){
   $query = "UPDATE tintura SET m1='$m1', m2='$m2', m3='$m3', m4='$m4', m5='$m5', m6='$m6', m7='$m7', m8='$m8', c1='$c1', c2='$c2', c3='$c3', c4='$c4', c5='$c5', c6='$c6', c7='$c7', c8='$c8' WHERE id='$id_mod_elemento'";
	$result = mysql_query($query);
   $query = "UPDATE combinazioni SET calo_tintura='$calo' WHERE id_tintura='$id_mod_elemento' AND id_articolo='$id'";
 	$result = mysql_query($query);

    $query = "UPDATE articoli SET data='$data', operatore='$operatore' WHERE id='$id'";
   $result = mysql_query($query);
 }
 if($tipo_lav=="finissaggio"){
   $query = "UPDATE finissaggio SET m1='$m1', m2='$m2', m3='$m3', m4='$m4', m5='$m5', m6='$m6', m7='$m7', m8='$m8', c1='$c1', c2='$c2', c3='$c3', c4='$c4', c5='$c5', c6='$c6', c7='$c7', c8='$c8' WHERE id='$id_mod_elemento'";
	$result = mysql_query($query);
   $query = "UPDATE combinazioni SET calo_finissaggio='$calo' WHERE id_finissaggio='$id_mod_elemento' AND id_articolo='$id'";
 	$result = mysql_query($query);

    $query = "UPDATE articoli SET data='$data', operatore='$operatore' WHERE id='$id'";
   $result = mysql_query($query);
 }
 if($tipo_lav=="accoppiatura"){
   $query = "UPDATE accoppiatura SET m1='$m1', m2='$m2', m3='$m3', m4='$m4', m5='$m5', m6='$m6', m7='$m7', m8='$m8', c1='$c1', c2='$c2', c3='$c3', c4='$c4', c5='$c5', c6='$c6', c7='$c7', c8='$c8' WHERE id='$id_mod_elemento'";
	$result = mysql_query($query);
   $query = "UPDATE combinazioni SET calo_accoppiatura='$calo' WHERE id_accoppiatura='$id_mod_elemento' AND id_articolo='$id'";
 	$result = mysql_query($query);

    $query = "UPDATE articoli SET data='$data', operatore='$operatore' WHERE id='$id'";
   $result = mysql_query($query);
 }
 if($tipo_lav=="supporti"){
   $query = "UPDATE supporti SET m1='$m1', m2='$m2', m3='$m3', m4='$m4', m5='$m5', m6='$m6', m7='$m7', m8='$m8', c1='$c1', c2='$c2', c3='$c3', c4='$c4', c5='$c5', c6='$c6', c7='$c7', c8='$c8' WHERE id='$id_mod_elemento'";
	$result = mysql_query($query);
   $query = "UPDATE combinazioni SET calo_supporti='$calo' WHERE id_supporti='$id_mod_elemento' AND id_articolo='$id'";
 	$result = mysql_query($query);

    $query = "UPDATE articoli SET data='$data', operatore='$operatore' WHERE id='$id'";
   $result = mysql_query($query);
 }
}




//------------------------MODIFICA STATO Elemento------------------
if($vocestato=="ON"){
 $cstate = "OFF";
}
if($vocestato=="OFF"){
 $cstate = "ON";
}
 if(isset($vocestato) AND $tipo_lavorazione!=NULL){
 $query = "UPDATE combinazioni SET stato='$cstate' WHERE id='$id_modifica'";
 $result = mysql_query($query);

    $query = "UPDATE articoli SET data='$data', operatore='$operatore' WHERE id='$id'";
   $result = mysql_query($query);
 }


//------------------------Delista Elemento------------------
 if(isset($delist)){
   mysql_query("DELETE FROM combinazioni WHERE id = '$delist'");

    $query = "UPDATE articoli SET data='$data', operatore='$operatore' WHERE id='$id'";
   $result = mysql_query($query);
 }
?>

<fieldset> <legend class="titoli">Gestione Degli Articoli</legend>


<form method="GET" action="articoli_crea.php">

	<div align="center">
		<table border="0" id="table1">

			<tr>
				<td align="center">
				 &nbsp;</td>
			</tr>


			<tr>
				<td align="center">
				 <fieldset> <legend class="titoli">Articolo:&nbsp;&nbsp;&nbsp; (<?php echo $nome;?>)&nbsp;&nbsp;
					<a target="_blank" href="articolo_stampa.php?id=<?php echo $id;?>">
					<img border="0" src="../icone/stampa.gif"></a>&nbsp;&nbsp; </legend>

					&nbsp;<div align="center">
					<table border="0" cellspacing="0" id="table2">
						<tr>
							<td>
				 			  <?php
				 			   if($stampa=="ON"){
				 			    $checked = "checked";
				 			   }else{
				 			    $checked = NULL;
				 			   }
				 			  ?>
								<input type="checkbox" name="stampa" value="ON" style="float: right" <?php echo $checked;?>></td>

							<td colspan="2">Seleziona articolo per la stampa nel listino.</td>

						</tr>
						<tr>
							<td>&nbsp;</td>
							<td colspan="2">
							&nbsp;</td>
						</tr>
						<tr>
							<td>Nome Articolo:</td>
							<td colspan="2">
							<input type="hidden" name="id" size="45" id="id" value="<?php echo $id;?>">

							<input type="text" name="nome" size="76" id="nome" value="<?php echo $nome;?>"></td>
						</tr>
						<tr>
							<td>Codice Articolo:</td>
							<td>
							<input type="text" name="codice" size="19" id="codice" value="<?php echo $codice;?>"></td>
							<td rowspan="5">
							<textarea rows="4" name="dettagli" cols="28"><?php echo $dettagli;?></textarea>Note</td>
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
							<td>&nbsp;</td>
							<td>
							&nbsp;</td>
							<td>
							&nbsp;</td>
						</tr>

						<tr>
							<td colspan="3">
							<p align="center">
				<input type="submit" value="Modifica" name="Modifica_Articolo"></td>
						</tr>
						</table>
				   </div>

				 </fieldset>
				</td>
			</tr>


			<tr>
			 <td align="center" class="info">
			   &nbsp;</td>
			</tr>


			<tr>
			 <td align="center" class="info">
			   <hr>
				<p align="left">Aggiungi Elemento:&nbsp;
							<select size="1" name="tipo_lavorazione">
							<option selected><?php ?></option>
							<option value="greggio">Greggio</option>
							<option value="tintura">Tintura</option>
							<option value="finissaggio">Finissaggio</option>
							<option value="accoppiatura">Accoppiatura</option>
							<option value="supporti">Supporti</option>
							</select>&nbsp;
				<input type="submit" value="Seleziona" name="Seleziona"></td>
			</tr>


			<tr>
			 <td align="center">

			   <?php
			    if($seleziona!=NULL AND $tipo_lavorazione!=NULL){

			    if(isset($id_modifica)){
			     $pulsante = "Modifica";
			     $disable = NULL;
			    }else{
			     $pulsante = "Aggiungi";
			     $disable = "disabled";
			    }


				//------------Seleziona elemento per modifica------------
				if(isset($id_modifica) AND $tipo_lavorazione!=NULL){

					$query  = "SELECT descrizione, id_fornitore, m1, m2, m3, m4, m5, m6, m7, m8, c1, c2, c3, c4, c5, c6, c7, c8, cod_art_fornitore FROM $tipo_lavorazione WHERE id='$id_modifica'";
					$result = mysql_query($query);
						$row = mysql_fetch_row($result);
						{
						  $tipo = $row[0];
						  $id_fornitore = $row[1];
						  $m1 = $row[2];
						  $m2 = $row[3];
						  $m3 = $row[4];
						  $m4 = $row[5];
						  $m5 = $row[6];
						  $m6 = $row[7];
						  $m7 = $row[8];
						  $m8 = $row[9];
						  $c1 = $row[10];
						  $c2 = $row[11];
						  $c3 = $row[12];
						  $c4 = $row[13];
						  $c5 = $row[14];
						  $c6 = $row[15];
						  $c7 = $row[16];
						  $c8 = $row[17];
						  $cod_art_fornitore = $row[18];
						}

					$query  = "SELECT calo_$tipo_lavorazione FROM combinazioni WHERE id_articolo='$id' AND id_$tipo_lavorazione='$id_mod_elemento'";
					$result = mysql_query($query);
						$row = mysql_fetch_row($result);
						{
						  $calo = $row[0];
						}


					//------------Descrizione fornitore------------
					$queryf  = "SELECT ragione_sociale FROM fornitori WHERE id = '$id_fornitore'";
					$resultf = mysql_query($queryf);
						$rowf = mysql_fetch_row($resultf);
						{
							$fornitore = $rowf[0];
						}

				}


			   ?>

			   <fieldset> <legend class="titoli">Elemento da selezionare:</legend>
				<div align="center">
					<table border="0" cellspacing="0" id="table3">
						<tr>
							<td><b>Elemento:</b></td>
							<td colspan="8" class="warn">
							 <b> <?php echo strtoupper($tipo_lavorazione);?> </b>
							 &nbsp;</td>
						</tr>

						<tr>
							<td colspan="9">&nbsp;</td>
						</tr>

						<tr>
							<td>Nome:</td>
							<td colspan="8">
							 <input type="hidden" name="id_elemento" size="3" id="id_elemento" value="<?php echo $id_elemento;?>">
							 <input type="hidden" name="id_mod_elemento" size="3" id="id_mod_elemento" value="<?php echo $id_mod_elemento;?>">
							 <input type="hidden" name="tipo_lav" size="3" value="<?php echo $tipo_lavorazione;?>">
							 <input type="text" name="tipo" size="48" id="tipo" value="<?php echo $tipo;?>">


							<?php
							 if($pulsante=="Aggiungi"){

							  if($_GET[tipo_lavorazione]!=NULL){
							   $_SESSION['tipo_lavorazione'] = $tipo_lavorazione;
							  }
							?>

							<input type="hidden" name="Seleziona" size="3" value="Seleziona">
							 <input type="submit" value="+" name="elenco"> </td>

							<?php
							 }
							?>

							</td>


							</td>

						</tr>
						<tr>
							<td>Codice Art. Fornitore</td>
							<td colspan="8">
							 <input <?php echo $disable;?> type="text" name="cod_art_fornitore" size="48" id="cod_art_fornitore" value="<?php echo $cod_art_fornitore;?>"></td>
						</tr>
						<tr>
							<td>Fornitore:</td>
							<td colspan="8">

							<?php
							 if(isset($_GET['fornitore'])){
							  $fornitore = $_GET['fornitore'];
							 }
							?>
							 <input type="text" name="fornitore" size="36" id="fornitore" value="<?php echo $fornitore;?>">

						  <?php
						   if(!isset($id_modifica)){
						  ?>
							<a href="articoli_crea.php?id=<?php echo $id;?>&tipo_lavorazione=<?php echo $tipo_lavorazione;?>&Seleziona=<?php echo $seleziona;?>">Reset</a></td>
						  <?php
						   }
						  ?>

						</tr>
						<tr>
							<td>Calo lavorazione</td>
							<td colspan="8">
							 <input type="text" name="calo" size="7" id="m9" value="<?php if($calo!=0) echo $calo;?>">%</td>
						</tr>
						<tr>
							<td>Metratura (mt.):</td>
							<td>
							 <input <?php echo $disable;?> type="text" name="m1" size="7" id="m1" value="<?php echo $m1;?>">
							</td>
							<td>
							 <input <?php echo $disable;?> type="text" name="m2" size="7" id="m2" value="<?php echo $m2;?>">
							</td>
							<td>
							 <input <?php echo $disable;?> type="text" name="m3" size="7" id="m3" value="<?php echo $m3;?>">
							</td>
							<td>
							 <input <?php echo $disable;?> type="text" name="m4" size="7" id="m4" value="<?php echo $m4;?>">
							</td>
							<td>
							 <input <?php echo $disable;?> type="text" name="m5" size="7" id="m5" value="<?php echo $m5;?>">
							</td>
							<td>
							 <input <?php echo $disable;?> type="text" name="m6" size="7" id="m6" value="<?php echo $m6;?>">
							 </td>
							<td>
							 <input <?php echo $disable;?> type="text" name="m7" size="7" id="m7" value="<?php echo $m7;?>">
							 </td>
							<td>
							 <input <?php echo $disable;?> type="text" name="m8" size="7" id="m8" value="<?php echo $m8;?>">
							</td>
						</tr>
						<tr>
							<td>Costo (Euro):</td>
							<td>
							 <input <?php echo $disable;?> type="text" name="c1" size="7" id="c1" value="<?php echo $c1;?>">
							</td>
							<td>
							 <input <?php echo $disable;?> type="text" name="c2" size="7" id="c2" value="<?php echo $c2;?>">
							</td>
							<td>
							 <input <?php echo $disable;?> type="text" name="c3" size="7" id="c3" value="<?php echo $c3;?>">
							</td>
							<td>
							 <input <?php echo $disable;?> type="text" name="c4" size="7" id="c4" value="<?php echo $c4;?>">
							</td>
							<td>
							 <input <?php echo $disable;?> type="text" name="c5" size="7" id="c5" value="<?php echo $c5;?>">
							</td>
							<td>
							 <input <?php echo $disable;?> type="text" name="c6" size="7" id="c6" value="<?php echo $c6;?>">
							</td>
							<td>
							 <input <?php echo $disable;?> type="text" name="c7" size="7" id="c7" value="<?php echo $c7;?>">
							 </td>
							<td>
							 <input <?php echo $disable;?> type="text" name="c8" size="7" id="c8" value="<?php echo $c8;?>">
							</td>
						</tr>
						<tr>
							<td colspan="9">
							<p align="center">

							 <input type="submit" value="<?php echo $pulsante;?>" name="<?php echo $pulsante;?>_elemento"></td>

						</tr>
					</table>
				</div>
			   </fieldset>

			   <?php
			    }
			   ?>



			 </td>
			</tr>


			<tr>
			 <td align="center">


				<hr>


			 </td>
			</tr>


			<tr>
			 <td align="center">


				<fieldset> <legend class="articolo"> (<?php echo strtoupper($nome);?>) </legend>






	<?php
	$attiva_1 = 0;
			$tipologia = array("greggio"=>"greggio", "tintura"=>"tintura", "finissaggio"=>"finissaggio", "accoppiatura"=>"accoppiatura", "supporti"=>"supporti");
			$metratura[]=0;
			while(list($tipo,$valore)=each($tipologia)){
	?>

				<fieldset> <legend class="titoli"> <?php echo strtoupper($tipo)?>:</legend>

				<div align="left">
					<table border="0" cellspacing="3" cellpadding="3" id="table4">

						<?php
						 //------------Seleziona combinazioni------------
						 ${$max."_".$tipo} = NULL;
						 
						 $metraggio_unico = NULL;
						 ${$id."_".$tipo} = NULL;
						 $query  = "SELECT id_$tipo, stato, id, calo_$tipo FROM combinazioni WHERE id_articolo='$id' AND id_$tipo!='0'";
						 $result = mysql_query($query);
							while($row = mysql_fetch_row($result))
							{
								$id_edb = $row[0];
								$stato = $row[1];
								$idcomb = $row[2];
								$calo = $row[3];

								$metraggio_unico = NULL;

								 //------------Seleziona elemento ------------
								 $queryx  = "SELECT descrizione, m1, m2, m3, m4, m5, m6, m7, m8, c1, c2, c3, c4, c5, c6, c7, c8, id_fornitore FROM $tipo WHERE id='$id_edb'";
								 $resultx = mysql_query($queryx);
								  $rowx = mysql_fetch_row($resultx);
									{
										$nome = $rowx[0];
										$m1 = $rowx[1];
										$m2 = $rowx[2];
										$m3 = $rowx[3];
										$m4 = $rowx[4];
										$m5 = $rowx[5];
										$m6 = $rowx[6];
										$m7 = $rowx[7];
										$m8 = $rowx[8];
										$c1 = $rowx[9];
										$c2 = $rowx[10];
										$c3 = $rowx[11];
										$c4 = $rowx[12];
										$c5 = $rowx[13];
										$c6 = $rowx[14];
										$c7 = $rowx[15];
										$c8 = $rowx[16];
										$idforn = $rowx[17];

									 //------------Seleziona elemento ------------
									 $queryxg  = "SELECT ragione_sociale FROM fornitori WHERE id='$idforn'";
									 $resultxg = mysql_query($queryxg);
									  $rowxg = mysql_fetch_row($resultxg);
										{
										 $forn = $rowxg[0];
										}


									}

						?>

							<tr>
								<td class="warn">  <?php echo strtoupper($nome)." - (".strtolower($forn).")";?> </td>
								<td> &nbsp; </td>
								<td>
								<a href="articoli_crea.php?id=<?php echo $id;?>&id_modifica=<?php echo $id_edb;?>&Seleziona=Seleziona&tipo_lavorazione=<?php echo $tipo;?>">Modifica</a></td>


								<?php
								 if($stato=="OFF"){
								  $vocestato = "OFF";
								  $colorstato = "#FF0000";
								 }else{
								  $vocestato = "ON";
								  $colorstato = "#66FF33";
								 }
								?>
								<td>
								 <a href="articoli_crea.php?id=<?php echo $id;?>&vocestato=<?php echo $vocestato;?>&tipo_lavorazione=<?php echo $tipo;?>&id_modifica=<?php echo $idcomb;?>">
								  <b> <font color="<?php echo $colorstato;?>"> <?php echo $vocestato;?> </font> </b> </a>
								</td>


								<td>
								<a href="articoli_crea.php?id=<?php echo $id;?>&delist=<?php echo $idcomb;?>">
								<font color="#FFFF00"> Delist </font> </a></td>
							</tr>

							<tr>
								<td colspan="5">

								<?php
								 //------------------------------elaborazione-----------------------
								 $m1 = explode("/", $m1);								  
								 $m2 = explode("/", $m2);
								 $m3 = explode("/", $m3);
								 $m4 = explode("/", $m4);
								 $m5 = explode("/", $m5);
								 $m6 = explode("/", $m6);
								 $m7 = explode("/", $m7);
								 $m8 = explode("/", $m8);

								//-------attiva o disattiva il campo 1/31-----
								  if($m2[0]<31 && $m1[0]>0){
								   $attiva_1 = 1;
								  }

							   //----------Prezzi Unici------------------
								 if($m2[0]==0){
								  echo "Costo Unico";

								  $metraggio_unico = "SI";
								   for($i=1;$i<9;$i++)
								      ${"c$i"} = $c1;

								   $disegno_m1 = "No Metratura";

									if(${$max."_".$tipo}==NULL){
									    ${$id."_".$tipo} = $id_edb;
								    }
								 }else{
								   $metraggio_unico = "NO";
								 }



								 //-------------------Prezzi con metraggi diversi cerca max------------------
								 if($metraggio_unico=="NO"){

								  //-----------aggiusto i metraggi--------------

									for($i=1;$i<9;$i++){
									    $j=$i+1;

										if(${"m$j"}[0]==0){
											${"m$i"}[1]="-->";
										}else{
											${"m$i"}[1]=${"m$j"}[0]-1;
										}
									}

								  echo "Costo Differenziato sulla metratura";
								 }


								//--------------creamo i disegni-------------------
								$disegno_m1 = $m1[0]."/".$m1[1];
								$disegno_m2 = $m2[0]."/".$m2[1];
								$disegno_m3 = $m3[0]."/".$m3[1];
								$disegno_m4 = $m4[0]."/".$m4[1];
								$disegno_m5 = $m5[0]."/".$m5[1];
								$disegno_m6 = $m6[0]."/".$m6[1];
								$disegno_m7 = $m7[0]."/".$m7[1];
								$disegno_m8 = $m8[0]."/".$m8[1];

								?>

								<div align="left">
									<table border="0" cellspacing="3" id="table5" width="100%">
										<tr>
											<td> <b> <?php echo $disegno_m1;?> </b></td>

										 <?php
										 
										
										//------------valuto la distanza tra le metrature---------
										for($i=1;$i<9;$i++){
											for($j=1;$j<count($metratura);$j++){										
												${"diff_ele$i"}[$j]=abs($metratura[$j]-${"m$i"}[0]);
											}
										}
										
										
										//-------------trovo tutti i valori di metratura------------------
										 for($i=1;$i<9;$i++){
											if(${"m$i"}[0]!=0){
												$dist_min=min(${"diff_ele$i"});
												if($dist_min==0 || $dist_min>15){
														$metratura[]=${"m$i"}[0];
												}
											}
										 }

										  if($metraggio_unico=="NO"){
											   for($i=2;$i<9;$i++){
											   	   if(${"m$i"}[0]>0){
														?>
														<td> <b> <?php echo ${"disegno_m$i"};?> </b></td>
														<?php
													}
										       }
										   }
										 ?>

										<tr>
											<td> <?php echo $c1;?> </td>
										 <?php
										  if($metraggio_unico=="NO"){
												for($i=2;$i<9;$i++){
													if(${"c$i"}>0){
														?>
														<td> <?php echo ${"c$i"};?> </td>
														<?php
													}
												}
											}
										 ?>

										</tr>
									</table>
								</div>

								</td>
							</tr>

							<tr>
							<?php
							 if($calo==NULL){
							  $calo = 0;
							 }
							?>

								<td colspan="5" class="info"><?php if($calo!=0) echo "Calo: ".$calo."%";?></td>
							</tr>

						<?php
						 }
						?>

					</table>
				</div>

				</fieldset>

	<?php
		}
	?>



				</fieldset>


			 </td>
			</tr>


			<tr>
			 <td align="center">


				<fieldset> <legend class="info"> Totali:</legend>

				<?php

								//-------ordino l'array delle metrature--------
								sort($metratura);
								
								if($metratura[0]==0 && $metratura[1]==1) {array_shift($metratura);}
								
								
								//------caso Frigerio-----
								if($attiva_1==1){
									//echo "shift metratura  ";
									array_shift($metratura);
								}

								
								for($i=0;$i<count($metratura);$i++){
									$j=$i+1;
									${"am$j"."db"}[0]=$metratura[$i];
								}
								//------------aggiusto gli intervalli--------------
								for($i=1;$i<count($metratura);$i++){
									$j=$i+1;
									${"am$i"."db"}[1]=${"am$j"."db"}[0]-1;
									if($i==count($metratura)-1){
										${"am$j"."db"}[1]="-->";
									}
								}


								$ac1db = 0;
								$ac2db = 0;
								$ac3db = 0;
								$ac4db = 0;
								$ac5db = 0;
								$ac6db = 0;
								$ac7db = 0;
								$ac8db = 0;

								//inizializzo i costi del listino per metratura
								for($i=1; $i<7; $i++)
									${"c$i"."list"}=0;


//---------------------------------------------Elabora i totali-------------------------------------

			$tipologia = array("greggio"=>"greggio", "tintura"=>"tintura", "finissaggio"=>"finissaggio", "accoppiatura"=>"accoppiatura", "supporti"=>"supporti");
			while(list($tipo,$valore)=each($tipologia)){

						 $query  = "SELECT id_$tipo, stato, id FROM combinazioni WHERE id_articolo='$id' AND id_$tipo>'0'";
						 $result = mysql_query($query);
							while($row = mysql_fetch_row($result))
							{
								$id_edb = $row[0];
								$stato = $row[1];
								$idcomb = $row[2];

								 //------------Seleziona elemento ------------
								 $queryx  = "SELECT descrizione, m1, m2, m3, m4, m5, m6, m7, m8, c1, c2, c3, c4, c5, c6, c7, c8 FROM $tipo WHERE id='$id_edb'";
								 $resultx = mysql_query($queryx);
								  $rowx = mysql_fetch_row($resultx);
									{
										$nome = $rowx[0];
										$m1 = $rowx[1];
										$m2 = $rowx[2];
										$m3 = $rowx[3];
										$m4 = $rowx[4];
										$m5 = $rowx[5];
										$m6 = $rowx[6];
										$m7 = $rowx[7];
										$m8 = $rowx[8];
										$c1 = $rowx[9];
										$c2 = $rowx[10];
										$c3 = $rowx[11];
										$c4 = $rowx[12];
										$c5 = $rowx[13];
										$c6 = $rowx[14];
										$c7 = $rowx[15];
										$c8 = $rowx[16];
									}

									$queryc  = "SELECT calo_$tipo FROM combinazioni WHERE id_articolo='$id' AND id_$tipo='$id_edb'";
									$resultc = mysql_query($queryc);
										$rowc = mysql_fetch_row($resultc);
										{
										  $calo = $rowc[0];
										}


								 $m1tmp = explode("/", $m1);
								 $m2tmp = explode("/", $m2);
								 $m3tmp = explode("/", $m3);
								 $m4tmp = explode("/", $m4);
								 $m5tmp = explode("/", $m5);
								 $m6tmp = explode("/", $m6);
								 $m7tmp = explode("/", $m7);
								 $m8tmp = explode("/", $m8);


							//--------------Calcolo prezzo metrature----------------

								for($i=1; $i<9; $i++){
								  for($j=1; $j<9; $j++){

								  $perc = 0;

								   //--Costo unico--------
								   if( $m1tmp[1] == 0){
									    ${"ac$i"."db"} = ${"ac$i"."db"} + ${"c$j"};

								   }elseif($m1tmp[0] >= ${"am$i"."db"}[0]){
											//verifico se ho un valore più piccolo del range più basso
											${"ac$i"."db"} = ${"ac$i"."db"} + $c1;
											break;
									}elseif(${"m$j"."tmp"}[0] <= ${"am$i"."db"}[0] && ${"am$i"."db"}[0] <= ${"m$j"."tmp"}[1]){
										 // ho individuato il range di metratura
										 // devo verificare se il range successivo è di poco più grande

										 $k=$j+1;
										 $diff = ${"m$k"."tmp"}[0] - ${"am$i"."db"}[0];
										 $soglia =(${"m$k"."tmp"}[0]*5)/100;
										 if( $diff >0 && $diff < $soglia){
											${"ac$i"."db"} = ${"ac$i"."db"} + ${"c$k"};
										 }else ${"ac$i"."db"} = ${"ac$i"."db"} + ${"c$j"};									
										
								   	}

								  }
								  $perc = round((${"ac$i"."db"}*$calo)/100, 2);
									      ${"ac$i"."db"} = ${"ac$i"."db"} + $perc;
								  }

								  //------------individuo il prezzo di listino-------------

								  //----------------------------Generazione listino-------------------

								$m0list=1;
								$m1list=31;
								$m2list=100;
								$m3list=200;
								$m4list=300;
								$m5list=400;
								$m6list=500;

								//--------inizializzo le variabili dei prezzi listino------------

								//verifico se l'articolo prevede una metratura 1/30
								if($attiva_1==1){
									$c0list = $c0list + $c1;
									$perc=round(($c0list*$calo)/100, 2);
									$c0list = $c0list + $perc;
								}else{
								    $c0list = "-";
								}
									

								for($i=1; $i<7; $i++){
									for($j=1; $j<9; $j++){

										if($m2tmp[0]==0){
											//se il costo è unico
									     ${"c$i"."list"} = ${"c$i"."list"} + ${"c$j"};
										 break;
										}
										elseif($m1tmp[0] >= ${"m$i"."list"}){
											//verifico se ho un valore più piccolo del range più basso
											${"c$i"."list"} = ${"c$i"."list"} + $c1;
											break;
										}elseif(${"m$j"."tmp"}[0] <= ${"m$i"."list"} && ${"m$i"."list"} <= ${"m$j"."tmp"}[1]){
											// ho individuato il range di metratura
											// devo verificare se il range successivo è di poco più grande
											$k=$j+1;
											$diff = ${"m$k"."tmp"}[0] - ${"m$i"."list"};
											$soglia =(${"m$k"."tmp"}[0]*5)/100;
											if( $diff >0 && $diff < $soglia){
												${"c$i"."list"} = ${"c$i"."list"} + ${"c$k"};
												break;
											}else{
												${"c$i"."list"} = ${"c$i"."list"} + ${"c$j"};
											}
										}
									}
									$perc = round((${"c$i"."list"}*$calo)/100, 2);
									${"c$i"."list"} = ${"c$i"."list"} + $perc;
								}
								
							}
				}

				?>


					<div align="center">
						<table border="1" cellspacing="1" cellpadding="1" id="table6">

						<tr>
							<td><b>Metratura:</b> </td>

							<td><?php  echo $am1db[0]."/".$am1db[1];?></td>
							<td><?php if($am2db[0]!=0) echo $am2db[0]."/".$am2db[1];?></td>
							<td><?php if($am3db[0]!=0) echo $am3db[0]."/".$am3db[1];?></td>
							<td><?php if($am4db[0]!=0) echo $am4db[0]."/".$am4db[1];?></td>
							<td><?php if($am5db[0]!=0) echo $am5db[0]."/".$am5db[1];?></td>
							<td><?php if($am6db[0]!=0) echo $am6db[0]."/".$am6db[1];?></td>
							<td><?php if($am7db[0]!=0) echo $am7db[0]."/".$am7db[1];?></td>
							<td><?php if($am8db[0]!=0) echo $am8db[0]."/".$am8db[1];?></td>
						</tr>

						<tr>
							<td><b>Totali: </b></td>
							<td><?php echo $ac1db;?></td>
							<td><?php if($am2db[0]!=0) echo $ac2db;?></td>
							<td><?php if($am3db[0]!=0) echo $ac3db;?></td>
							<td><?php if($am4db[0]!=0) echo $ac4db;?></td>
							<td><?php if($am5db[0]!=0) echo $ac5db;?></td>
							<td><?php if($am6db[0]!=0) echo $ac6db;?></td>
							<td><?php if($am7db[0]!=0) echo $ac7db;?></td>
							<td><?php if($am8db[0]!=0) echo $ac8db;?></td>
						</tr>

						<?php for($i=50;$i<=100;$i=$i+5){?>
						<tr>
							<td><b>Ricarico <?php echo $i."%" ?></b></td>
							<td> <?php echo $ac1db+round(($ac1db*$i/100), 2);?> </td>
							<td> <?php if($am2db[0]!=0) echo $ac2db+round(($ac2db*$i/100), 2);?> </td>
							<td> <?php if($am3db[0]!=0) echo $ac3db+round(($ac3db*$i/100), 2);?> </td>
							<td> <?php if($am4db[0]!=0) echo $ac4db+round(($ac4db*$i/100), 2);?> </td>
							<td> <?php if($am5db[0]!=0) echo $ac5db+round(($ac5db*$i/100), 2);?> </td>
							<td> <?php if($am6db[0]!=0) echo $ac6db+round(($ac6db*$i/100), 2);?> </td>
							<td> <?php if($am7db[0]!=0) echo $ac7db+round(($ac7db*$i/100), 2);?> </td>
							<td> <?php if($am8db[0]!=0) echo $ac8db+round(($ac8db*$i/100), 2);?> </td>
						</tr>
						<?php
						}
						?>
						

					</table>
				</div>

				</fieldset>

			 </td>
			</tr>


			<tr>
			 <td align="center">





				<fieldset> <legend class="info"> Listino:</legend>

				<?php


//---------------metto il ricarico----------
					//------------Seleziona ricarichi------------
					$query  = "SELECT r1, r31, r100, r200, r300, r400, r500 FROM opzioni_listino";
					$result = mysql_query($query);
						$row = mysql_fetch_row($result);
						{
							$r1 = "1.$row[0]";
							$r31 = "1.$row[1]";
							$r100 = "1.$row[2]";
							$r200 = "1.$row[3]";
							$r300 = "1.$row[4]";
							$r400 = "1.$row[5]";
							$r500 = "1.$row[6]";
						}

				if($attiva_1==1){ $c0listf = $c0list * $r1;}else{$c0listf = "-";};
				$c1listf = $c1list * $r31;
				$c2listf = $c2list * $r100;
				$c3listf = $c3list * $r200;
				$c4listf = $c4list * $r300;
				$c5listf = $c5list * $r400;
				$c6listf = $c6list * $r500;


				//verifico se ci sono prezzi uguali ed applico una differenza di € 0,20

				$elem = array();

				//verifico se ci sono prezzi uguali ed applico una differenza di € 0,20
				for($i=6;$i>0;$i--){
					$k=$i-1;
					if(${"c$i"."listf"}==${"c$k"."listf"}){
						array_push($elem, $k);

					}
				}

				for($f=0;$f<count($elem);$f++){
					$g=$f+1;
					$k=$elem[$f];
					${"c$k"."listf"}=${"c$k"."listf"}+($g*0.18);
				}





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

				//ripasso di tutti i costi per verificare eventuali costi uguali
				for($i=6;$i>0;$i--){
					$k=$i-1;
						if(${"c$i"."listf"}==${"c$k"."listf"}){
							$g=1;
							${"c$k"."listf"}=${"c$k"."listf"}+($g*0.20);
						}
				}

				//verifico se le variazioni hanno comportato un disallineamento dei costi
				for($i=3;$i<7; $i++){
					if($c2listf < ${"c$i"."listf"})
						$c2listf=$c3listf+0.20;
				}
//echo "attiva= ".$attiva_1."  ";
				?>

				<div align="center">
					<table border="2" cellspacing="1" id="table7">
						<tr>
							<td>Metrature:</td>
							<td align="center"><b><?php if($attiva_1==1) {echo $m0list."/".($m1list-1);} ?></b></td>
							<td align="center"><b><?php echo $m1list."/".($m2list-1) ?></b></td>
							<td align="center"><b><?php echo $m2list."/".($m3list-1) ?></b></td>
							<td align="center"><b><?php echo $m3list."/".($m4list-1) ?></b></td>
							<td align="center"><b><?php echo $m4list."/".($m5list-1) ?></b></td>
							<td align="center"><b><?php echo $m5list."/".($m6list-1) ?></b></td>
							<td align="center"><b><?php echo $m6list."/"."-->" ?></b></td>
						</tr>
						<tr>
							<td>Totali:</td>
							<td align="center"><?php if($attiva_1==1) {echo $c0list;}?></td>
							<td align="center"><?php echo $c1list;?></td>
							<td align="center"><?php echo $c2list;?></td>
							<td align="center"><?php echo $c3list;?></td>
							<td align="center"><?php echo $c4list;?></td>
							<td align="center"><?php echo $c5list;?></td>
							<td align="center"><?php echo $c6list;?></td>
						</tr>
						<tr>
							<td>Ricarico:</td>
							<td align="center"><?php echo $c0listf;?></td>
							<td align="center"><?php echo $c1listf;?></td>
							<td align="center"><?php echo $c2listf;?></td>
							<td align="center"><?php echo $c3listf;?></td>
							<td align="center"><?php echo $c4listf;?></td>
							<td align="center"><?php echo $c5listf;?></td>
							<td align="center"><?php echo $c6listf;?></td>
						</tr>





			<?php
	$diffc =array('cm1'=> 0, 'cm31'=> 0 , 'cm100'=> 0, 'cm200'=> 0, 'cm300'=> 0, 'cm400'=> 0, 'cm500'=> 0);
	$diff=array();
	$diff[0]=0;
	if(isset($_GET['Ricalcola'])){	
		$i=0;
		foreach($diffc as $key=>$valore){

			if($_GET[$key]!=0){				
				$valore = str_replace(",", ".", $_GET[$key])-${"c$i"."listf"};		
				$diff[$i]=$valore;
			}	
			//echo $valore;
			//echo $i." ";
			$i++;
		}
		//echo "   /".$diff[0]."/    ";
		
	   $query = "UPDATE articoli SET cm1='$diff[0]', cm31='$diff[1]', cm100='$diff[2]', cm200='$diff[3]', cm300='$diff[4]', cm400='$diff[5]', cm500='$diff[6]' WHERE id='$id'";
	    $result = mysql_query($query);
	}

			//-------------------Definisco le differenze conti manuali------------
					$query  = "SELECT cm1, cm31, cm100, cm200, cm300, cm400, cm500 FROM articoli WHERE id='$id'";
					$result = mysql_query($query);
						$row = mysql_fetch_row($result);
						{
						  $diff[0] = $row[0];
						  $diff[1] = $row[1];
						  $diff[2] = $row[2];
						  $diff[3] = $row[3];
						  $diff[4] = $row[4];
						  $diff[5] = $row[5];
						  $diff[6] = $row[6];
						}

			for($i=0;$i<count($diff);$i++){
				
					if($diff[$i]==0){
						${"color$i"} = "66CCFF";
						$diff[$i] = "0";
					}else{
						if($diff[$i]<0){
							${"color$i"} = "FF0000";
						}
						if($diff[$i]>0){
							${"color$i"} = "00FF00";
						}
					}
				}
			?>



						<tr>
							<td>
							<p align="right">Diff.</td>
							<td align="center"> <font color="#<?php echo $color0;?>"> <?php if($attiva_1==1){echo $diff[0];}else{echo "-";};?> </font> </td>
							<td align="center"> <font color="#<?php echo $color1;?>"> <?php echo $diff[1];?> </font> </td>
							<td align="center"> <font color="#<?php echo $color2;?>"> <?php echo $diff[2];?> </font> </td>
							<td align="center"> <font color="#<?php echo $color3;?>"> <?php echo $diff[3];?> </font> </td>
							<td align="center"> <font color="#<?php echo $color4;?>"> <?php echo $diff[4];?> </font> </td>
							<td align="center"> <font color="#<?php echo $color5;?>"> <?php echo $diff[5];?> </font> </td>
							<td align="center"> <font color="#<?php echo $color6;?>"> <?php echo $diff[6];?> </font> </td>
						</tr>


						<?php
						 if($attiva_1==0){
						  $disabil = "Disabled";
						 }else{
						  $disabil = NULL;
						 }
						?>

						<tr>
							<td>Modifiche Manuali:</td>
							<td align="center"><input type="text" name="cm1" size="5" value="<?php echo $c0listf+$diff[0];?>" <?php echo $disabil;?>></td>
							<td align="center"><input type="text" name="cm31" size="5" value="<?php echo $c1listf+$diff[1];?>"></td>
							<td align="center"><input type="text" name="cm100" size="5" value="<?php echo $c2listf+$diff[2];?>"></td>
							<td align="center"><input type="text" name="cm200" size="5" value="<?php echo $c3listf+$diff[3];?>"></td>
							<td align="center"><input type="text" name="cm300" size="5" value="<?php echo $c4listf+$diff[4];?>"></td>
							<td align="center"><input type="text" name="cm400" size="5" value="<?php echo $c5listf+$diff[5];?>"></td>
							<td align="center"><input type="text" name="cm500" size="5" value="<?php echo $c6listf+$diff[6];?>"></td>
						</tr>
						</table>
				</div>



				</fieldset>

			</td>



			</tr>


			</table>
	</div>
	<p>&nbsp;</p>
	<p><input type="submit" value="Ricalcola" name="Ricalcola"></p>
</form>



</fieldset>


<br>
<br>


<?php
//----------------------------------------Aggiorno l' articolo e il listino per differenze manuali prezzi------------
 mysql_query("DELETE FROM listino WHERE id_articolo = '$id'");

 $c0listf = $c0listf+$diff[0];
 $c1listf = $c1listf+$diff[1];
 $c2listf = $c2listf+$diff[2];
 $c3listf = $c3listf+$diff[3];
 $c4listf = $c4listf+$diff[4];
 $c5listf = $c5listf+$diff[5];
 $c6listf = $c6listf+$diff[6];


  mysql_query("INSERT INTO listino (id_articolo, 500mt, 400mt, 300mt, 200mt, 100mt, 31mt, 1mt)
   VALUES ('$id', '$c6listf', '$c5listf', '$c4listf', '$c3listf', '$c2listf', '$c1listf', '$c0listf')");





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

      $("#nome").autocomplete({
        source: "articoli_suggest.php",
        minLength: 2,
        select: function(event, ui) {
         $('#nome_id').val(ui.item.id);
         $('#value').val(ui.item.nome);
         $('#codice').val(ui.item.codice);
         $('#collezione').val(ui.item.collezione);
         $('#composizione').val(ui.item.composizione);
         $('#altezza').val(ui.item.altezza);
        }
       });

      $("#tipo").autocomplete({
        source: "<?php echo $suggest;?>",
        minLength: 2,
        select: function(event, ui) {
         $('#id_elemento').val(ui.item.id);
         $('#value').val(ui.item.descrizione);
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
         $('#fornitore').val(ui.item.fornitore);
         $('#cod_art_fornitore').val(ui.item.cod_art_fornitore);
        }
       });

      $("#fornitore").autocomplete({
        source: "fornitore_suggest.php",
        minLength: 2,
        select: function(event, ui) {
         $('#fornitore_id').val(ui.item.id);
         $('#value').val(ui.item.ragione_sociale);
         
        }
       });

});
</script>
