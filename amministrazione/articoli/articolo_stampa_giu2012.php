<?php
include("cat.php");
//--------------------Seleziona Articolo dal Database-------------------
$con = mysql_connect($localhost.":".$localporta,$locallogin,$localpass);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
   }
 mysql_select_db($localnome, $con);




  $id = $_GET['id'];
  $attiva_1 = 0;

		//------------Seleziona articolo------------
		$query  = "SELECT codice, nome, collezione, composizione, altezza, stampa, dettagli, seq_accoppiature FROM articoli WHERE id = '$id'";
		$result = mysql_query($query);
			while($row = mysql_fetch_row($result))
			{
				$codice = $row[0];
				$nome = $row[1];
				$collezione = $row[2];
				$composizione = $row[3];
				$altezza = $row[4];
				$stampa = $row[5];
				$note = $row[6];
				$seq_accoppiature = $row[7];

				//------------Sequenza Accoppiature------------
				$querys  = "SELECT nome FROM seq_accoppiature WHERE id='$seq_accoppiature'";
				$results = mysql_query($querys);
					while($rows = mysql_fetch_row($results))
					{
						$nome_seq_accoppiature = $rows[0];
					}
			}

?>


<head>
<meta http-equiv="Content-Language" content="it">
</head>




<link rel="stylesheet" type="text/css" href="../../stampe.css">




<div align="center" id="header">
	<table border="0" cellpadding="3"  id="table2" width="800">
		<tr>
			<td>
			<div align="left">
				<table border="0" cellpadding="3" id="table3">

				 <?php
				  if($collezione==NULL){
				   $collezione="-";
				  }
				 ?>
					<tr>
						<td>Collezione:</td>
						<td> <b> <?php echo $collezione;?> </b> </td>
					</tr>

				 <?php
				  if($altezza==NULL){
				   $altezza="0.00";
				  }
				 ?>
					<tr>
						<td>Altezza:</td>
						<td> <b> <?php echo $altezza;?> </b> cm</td>
					</tr>

				 <?php
				  if($composizione==NULL){
				   $composizione="-";
				  }
				 ?>
					<tr>
						<td>Composizione:</td>
						<td> <b> <?php echo $composizione;?> </b> </td>
					</tr>

				 <?php
				  if($note==NULL){
				   $note="-";
				  }
				 ?>
					<tr>
						<td>Note:</td>
						<td width="250"> <b> <?php echo $note;?> </b> </td>
					</tr>
					</table>
			</div>
			</td>



			<td>




			<fieldset> <legend class="titolipiccoli"> Nome Articolo:</legend>
				<div align="center">
					<table border="0" cellspacing="2" cellpadding="2" id="table1">
						<tr>
							<td><b> <font size="3"><?php echo $nome." (".$nome_seq_accoppiature.")";?></font> </b></td>
						</tr>
					</table>
				</div>
			</fieldset>






			</td>



		</tr>
		<tr>
			<td colspan="2">
			<hr>
			</td>
		</tr>
		<tr>
			<td colspan="2">

	<?php
			$tipologia = array("greggio"=>"greggio", "tintura"=>"tintura", "finissaggio"=>"finissaggio", "accoppiatura"=>"accoppiatura", "supporti"=>"supporti");
			while(list($tipo,$valore)=each($tipologia)){

	?>


				<fieldset> <legend class="titolipiccoli"> <?php echo strtoupper($tipo)?>:</legend>

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
								<td class="titoli"> <?php echo strtoupper($nome)." - (".strtolower($forn).")";?> </td>


								<?php
								 if($stato=="OFF"){
								  $vocestato = "OFF";
								  $colorstato = "#FF0000";
								 }else{
								  $vocestato = "ON";
								  $colorstato = "#66FF33";
								 }
								?>



								</tr>

							<tr>
								<td colspan="2">

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
									<table border="0" cellspacing="3" id="table5">
										<tr>


											<?php
											if($metraggio_unico=="NO"){
											  echo "<td>";
											  echo $disegno_m1;
											  echo "&nbsp;&nbsp;&nbsp;&nbsp; </td>";
											}
											?>



										 <?php
										  if($metraggio_unico!="SI"){

											   if($m2[0]>0){
											    if(${$max."_".$tipo}<2){
											     ${$max."_".$tipo} = 2;
											     ${$id."_".$tipo} = $id_edb;
											    }
											  ?>
												<td> <?php echo $disegno_m2;?> &nbsp;&nbsp;&nbsp;&nbsp; </td>
											  <?php
											   }
											   if($m3[0]>0){
											    if(${$max."_".$tipo}<3){
											     ${$max."_".$tipo} = 3;
											     ${$id."_".$tipo} = $id_edb;
											    }
											  ?>
												<td> <?php echo $disegno_m3;?> &nbsp;&nbsp;&nbsp;&nbsp; </td>
											  <?php
											   }
											   if($m4[0]>0){
											    if(${$max."_".$tipo}<4){
											     ${$max."_".$tipo} = 4;
											     ${$id."_".$tipo} = $id_edb;
											    }
											  ?>
												<td> <?php echo strtoupper($disegno_m4);?> &nbsp;&nbsp;&nbsp;&nbsp; </td>
											  <?php
											   }
											   if($m5[0]>0){
											    if(${$max."_".$tipo}<5){
											     ${$max."_".$tipo} = 5;
											     ${$id."_".$tipo} = $id_edb;
											    }
											  ?>
												<td> <?php echo $disegno_m5;?> &nbsp;&nbsp;&nbsp;&nbsp; </td>
											  <?php
											   }
											   if($m6[0]>0){
											    if(${$max."_".$tipo}<6){
											     ${$max."_".$tipo} = 6;
											     ${$id."_".$tipo} = $id_edb;
											    }
											  ?>
												<td> <?php echo $disegno_m6;?> &nbsp;&nbsp;&nbsp;&nbsp; </td>
											  <?php
											   }
											   if($m7[0]>0){
											    if(${$max."_".$tipo}<7){
											     ${$max."_".$tipo} = 7;
											     ${$id."_".$tipo} = $id_edb;
											    }
											  ?>
												<td> <?php echo $disegno_m7;?> &nbsp;&nbsp;&nbsp;&nbsp; </td>
											  <?php
											   }
											   if($m8[0]>0){
											    if(${$max."_".$tipo}<8){
											     ${$max."_".$tipo} = 8;
											     ${$id."_".$tipo} = $id_edb;
											    }
											  ?>
												<td width="0"> <?php echo $disegno_m8;?> &nbsp;&nbsp;&nbsp;&nbsp; </td>
											 <?php
											  }

										 }
										 ?>

										<tr>
											<td> <b> <?php echo $c1;?> </b></td>
										 <?php
										  if($metraggio_unico=="NO"){

											  if($c2>0){
											 ?>
												<td> <b> <?php echo $c2;?> </b></td>
											 <?php
											  }
											   if($c3>0){
											 ?>
												<td> <b> <?php echo $c3;?> </b></td>
											 <?php
											  }
											   if($c4>0){
											 ?>
												<td> <b> <?php echo $c4;?> </b></td>
											 <?php
											  }
											   if($c5>0){
											 ?>
												<td> <b> <?php echo $c5;?> </b></td>
											 <?php
											  }
											   if($c6>0){
											 ?>
												<td> <b> <?php echo $c6;?> </b></td>
											 <?php
											  }
											   if($c7>0){
											 ?>
												<td> <b> <?php echo $c7;?> </b></td>
											 <?php
											  }
											   if($c8>0){
											 ?>
												<td> <b> <?php echo $c8;?> </b></td>
											 <?php
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
							 if($calo>0){
							  //$calo = 0;

							?>

								<td colspan="2" class="info">&nbsp; Calo: <?php echo $calo;?> %</td>


							<?php
							  }
							 }
							?>
							</tr>
					</table>
				</div>

				</fieldset>

	<?php
		}
	?>





































				<?php
				//-----------------Cerca indice massimo per le metrature--------------------------

			$mylist = array("greggio" => ${$max."_".greggio}, "tintura"=> ${$max."_".tintura}, "finissaggio"=> ${$max."_".finissaggio}, "accoppiatura"=> ${$max."_".accoppiatura}, "supporti"=> ${$max."_".supporti});
			$mylist_id = array("greggio" => ${$id."_".greggio}, "tintura"=> ${$id."_".tintura}, "finissaggio"=> ${$id."_".finissaggio}, "accoppiatura"=> ${$id."_".accoppiatura}, "supporti"=> ${$id."_".supporti});
	        $tabella =NULL;

				$maxvalue=max($mylist);
				  while(list($key,$value)=each($mylist)){
				    if($value==$maxvalue)$maxindex=$key;
				  }


				  //-----------------Cerca Id dell' indice massimo-------------------------------------
				  while(list($key1,$value1)=each($mylist_id)){
				    if($key1==$maxindex)$tabella=$value1;
				  }


						 //------------Seleziona Metrature elemento max ------------
						 $queryx  = "SELECT m1, m2, m3, m4, m5, m6, m7, m8 FROM $maxindex WHERE id='$tabella'";
						 $resultx = mysql_query($queryx);
						  $rowx = mysql_fetch_row($resultx);
							{
							 $am1db = $rowx[0];
							 $am2db = $rowx[1];
							 $am3db = $rowx[2];
							 $am4db = $rowx[3];
							 $am5db = $rowx[4];
							 $am6db = $rowx[5];
							 $am7db = $rowx[6];
							 $am8db = $rowx[7];
							}

								//-------metrature di riferimento--------------
								 $am1db = explode("/", $am1db);
								 $am2db = explode("/", $am2db);
								 $am3db = explode("/", $am3db);
								 $am4db = explode("/", $am4db);
								 $am5db = explode("/", $am5db);
								 $am6db = explode("/", $am6db);
								 $am7db = explode("/", $am7db);
								 $am8db = explode("/", $am8db);

								 //----------caso particolare Frigerio - tecnofinish-----------
								//if($am1db[1]>=300)
								if($attiva_1==1){
									$j=0;

									for($i=1;$i<9;$i++){
										if(${"am$i"."db"}[0]==0)
											$j=$i;
									}
									for($i=$j;$i>1;$i--){
										$g=$i-1;
										${"am$i"."db"}=${"am$g"."db"};
									}
									$am1db[0]=0.30;
									$am1db[1]=20;
									$am2db[0]=21;
								}


								$ac1db = 0;
								$ac2db = 0;
								$ac3db = 0;
								$ac4db = 0;
								$ac5db = 0;
								$ac6db = 0;
								$ac7db = 0;
								$ac8db = 0;

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

			</td>
		</tr>

		<tr>
			<td align="center">


<fieldset> <legend class="info"> Totali:</legend>

					<div align="center">
						<table border="2" cellspacing="2" cellpadding="2" id="table6">

						<tr>
							<td><b>Metratura:</b> </td>

							<td><?php echo $am1db[0]."/".$am1db[1];?></td>
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

						<tr>
							<td><b>Ricarico 50%</b></td>
							<td> <?php echo $ac1db+round(($ac1db*50/100), 2);?> </td>
							<td> <?php if($am2db[0]!=0) echo $ac2db+round(($ac2db*50/100), 2);?> </td>
							<td> <?php if($am3db[0]!=0) echo $ac3db+round(($ac3db*50/100), 2);?> </td>
							<td> <?php if($am4db[0]!=0) echo $ac4db+round(($ac4db*50/100), 2);?> </td>
							<td> <?php if($am5db[0]!=0) echo $ac5db+round(($ac5db*50/100), 2);?> </td>
							<td> <?php if($am6db[0]!=0) echo $ac6db+round(($ac6db*50/100), 2);?> </td>
							<td> <?php if($am7db[0]!=0) echo $ac7db+round(($ac7db*50/100), 2);?> </td>
							<td> <?php if($am8db[0]!=0) echo $ac8db+round(($ac8db*50/100), 2);?> </td>
						</tr>

						<tr>
							<td><b>Ricarico 55%</b></td>
							<td> <?php echo $ac1db+round(($ac1db*55/100), 2);?> </td>
							<td> <?php if($am2db[0]!=0) echo $ac2db+round(($ac2db*55/100), 2);?> </td>
							<td> <?php if($am3db[0]!=0) echo $ac3db+round(($ac3db*55/100), 2);?> </td>
							<td> <?php if($am4db[0]!=0) echo $ac4db+round(($ac4db*55/100), 2);?> </td>
							<td> <?php if($am5db[0]!=0) echo $ac5db+round(($ac5db*55/100), 2);?> </td>
							<td> <?php if($am6db[0]!=0) echo $ac6db+round(($ac6db*55/100), 2);?> </td>
							<td> <?php if($am7db[0]!=0) echo $ac7db+round(($ac7db*55/100), 2);?> </td>
							<td> <?php if($am8db[0]!=0) echo $ac8db+round(($ac8db*55/100), 2);?> </td>
						</tr>

						<tr>
							<td><b>Ricarico 60%</b></td>
							<td> <?php echo $ac1db+round(($ac1db*60/100), 2);?> </td>
							<td> <?php if($am2db[0]!=0) echo $ac2db+round(($ac2db*60/100), 2);?> </td>
							<td> <?php if($am3db[0]!=0) echo $ac3db+round(($ac3db*60/100), 2);?> </td>
							<td> <?php if($am4db[0]!=0) echo $ac4db+round(($ac4db*60/100), 2);?> </td>
							<td> <?php if($am5db[0]!=0) echo $ac5db+round(($ac5db*60/100), 2);?> </td>
							<td> <?php if($am6db[0]!=0) echo $ac6db+round(($ac6db*60/100), 2);?> </td>
							<td> <?php if($am7db[0]!=0) echo $ac7db+round(($ac7db*60/100), 2);?> </td>
							<td> <?php if($am8db[0]!=0) echo $ac8db+round(($ac8db*60/100), 2);?> </td>
						</tr>

						<tr>
							<td><b>Ricarico 65%</b></td>
							<td> <?php echo $ac1db+round(($ac1db*65/100), 2);?> </td>
							<td> <?php if($am2db[0]!=0) echo $ac2db+round(($ac2db*65/100), 2);?> </td>
							<td> <?php if($am3db[0]!=0) echo $ac3db+round(($ac3db*65/100), 2);?> </td>
							<td> <?php if($am4db[0]!=0) echo $ac4db+round(($ac4db*65/100), 2);?> </td>
							<td> <?php if($am5db[0]!=0) echo $ac5db+round(($ac5db*65/100), 2);?> </td>
							<td> <?php if($am6db[0]!=0) echo $ac6db+round(($ac6db*65/100), 2);?> </td>
							<td> <?php if($am7db[0]!=0) echo $ac7db+round(($ac7db*65/100), 2);?> </td>
							<td> <?php if($am8db[0]!=0) echo $ac8db+round(($ac8db*65/100), 2);?> </td>
						</tr>

						<tr>
							<td><b>Ricarico 70%</b></td>
							<td> <?php echo $ac1db+round(($ac1db*70/100), 2);?> </td>
							<td> <?php if($am2db[0]!=0) echo $ac2db+round(($ac2db*70/100), 2);?> </td>
							<td> <?php if($am3db[0]!=0) echo $ac3db+round(($ac3db*70/100), 2);?> </td>
							<td> <?php if($am4db[0]!=0) echo $ac4db+round(($ac4db*70/100), 2);?> </td>
							<td> <?php if($am5db[0]!=0) echo $ac5db+round(($ac5db*70/100), 2);?> </td>
							<td> <?php if($am6db[0]!=0) echo $ac6db+round(($ac6db*70/100), 2);?> </td>
							<td> <?php if($am7db[0]!=0) echo $ac7db+round(($ac7db*70/100), 2);?> </td>
							<td> <?php if($am8db[0]!=0) echo $ac8db+round(($ac8db*70/100), 2);?> </td>
						</tr>

						<tr>
							<td><b>Ricarico 75%</b></td>
							<td> <?php echo $ac1db+round(($ac1db*75/100), 2);?> </td>
							<td> <?php if($am2db[0]!=0) echo $ac2db+round(($ac2db*75/100), 2);?> </td>
							<td> <?php if($am3db[0]!=0) echo $ac3db+round(($ac3db*75/100), 2);?> </td>
							<td> <?php if($am4db[0]!=0) echo $ac4db+round(($ac4db*75/100), 2);?> </td>
							<td> <?php if($am5db[0]!=0) echo $ac5db+round(($ac5db*75/100), 2);?> </td>
							<td> <?php if($am6db[0]!=0) echo $ac6db+round(($ac6db*75/100), 2);?> </td>
							<td> <?php if($am7db[0]!=0) echo $ac7db+round(($ac7db*75/100), 2);?> </td>
							<td> <?php if($am8db[0]!=0) echo $ac8db+round(($ac8db*75/100), 2);?> </td>
						</tr>

						<tr>
							<td><b>Ricarico 80%</b></td>
							<td> <?php echo $ac1db+round(($ac1db*80/100), 2);?> </td>
							<td> <?php if($am2db[0]!=0) echo $ac2db+round(($ac2db*80/100), 2);?> </td>
							<td> <?php if($am3db[0]!=0) echo $ac3db+round(($ac3db*80/100), 2);?> </td>
							<td> <?php if($am4db[0]!=0) echo $ac4db+round(($ac4db*80/100), 2);?> </td>
							<td> <?php if($am5db[0]!=0) echo $ac5db+round(($ac5db*80/100), 2);?> </td>
							<td> <?php if($am6db[0]!=0) echo $ac6db+round(($ac6db*80/100), 2);?> </td>
							<td> <?php if($am7db[0]!=0) echo $ac7db+round(($ac7db*80/100), 2);?> </td>
							<td> <?php if($am8db[0]!=0) echo $ac8db+round(($ac8db*80/100), 2);?> </td>
						</tr>

						<tr>
							<td><b>Ricarico 85%</b></td>
							<td> <?php echo $ac1db+round(($ac1db*85/100), 2);?> </td>
							<td> <?php if($am2db[0]!=0) echo $ac2db+round(($ac2db*85/100), 2);?> </td>
							<td> <?php if($am3db[0]!=0) echo $ac3db+round(($ac3db*85/100), 2);?> </td>
							<td> <?php if($am4db[0]!=0) echo $ac4db+round(($ac4db*85/100), 2);?> </td>
							<td> <?php if($am5db[0]!=0) echo $ac5db+round(($ac5db*85/100), 2);?> </td>
							<td> <?php if($am6db[0]!=0) echo $ac6db+round(($ac6db*85/100), 2);?> </td>
							<td> <?php if($am7db[0]!=0) echo $ac7db+round(($ac7db*85/100), 2);?> </td>
							<td> <?php if($am8db[0]!=0) echo $ac8db+round(($ac8db*85/100), 2);?> </td>
						</tr>

						<tr>
							<td><b>Ricarico 90%</b></td>
							<td> <?php echo $ac1db+round(($ac1db*90/100), 2);?> </td>
							<td> <?php if($am2db[0]!=0) echo $ac2db+round(($ac2db*90/100), 2);?> </td>
							<td> <?php if($am3db[0]!=0) echo $ac3db+round(($ac3db*90/100), 2);?> </td>
							<td> <?php if($am4db[0]!=0) echo $ac4db+round(($ac4db*90/100), 2);?> </td>
							<td> <?php if($am5db[0]!=0) echo $ac5db+round(($ac5db*90/100), 2);?> </td>
							<td> <?php if($am6db[0]!=0) echo $ac6db+round(($ac6db*90/100), 2);?> </td>
							<td> <?php if($am7db[0]!=0) echo $ac7db+round(($ac7db*90/100), 2);?> </td>
							<td> <?php if($am8db[0]!=0) echo $ac8db+round(($ac8db*90/100), 2);?> </td>
						</tr>

						<tr>
							<td><b>Ricarico 95%</b></td>
							<td> <?php echo $ac1db+round(($ac1db*95/100), 2);?> </td>
							<td> <?php if($am2db[0]!=0) echo $ac2db+round(($ac2db*95/100), 2);?> </td>
							<td> <?php if($am3db[0]!=0) echo $ac3db+round(($ac3db*95/100), 2);?> </td>
							<td> <?php if($am4db[0]!=0) echo $ac4db+round(($ac4db*95/100), 2);?> </td>
							<td> <?php if($am5db[0]!=0) echo $ac5db+round(($ac5db*95/100), 2);?> </td>
							<td> <?php if($am6db[0]!=0) echo $ac6db+round(($ac6db*95/100), 2);?> </td>
							<td> <?php if($am7db[0]!=0) echo $ac7db+round(($ac7db*95/100), 2);?> </td>
							<td> <?php if($am8db[0]!=0) echo $ac8db+round(($ac8db*95/100), 2);?> </td>
						</tr>

						<tr>
							<td><b>Ricarico 100%</b></td>
							<td> <?php echo $ac1db+round(($ac1db*100/100), 2);?> </td>
							<td> <?php if($am2db[0]!=0) echo $ac2db*2;?> </td>
							<td> <?php if($am3db[0]!=0) echo $ac3db*2;?> </td>
							<td> <?php if($am4db[0]!=0) echo $ac4db*2;?> </td>
							<td> <?php if($am5db[0]!=0) echo $ac5db*2;?> </td>
							<td> <?php if($am6db[0]!=0) echo $ac6db*2;?> </td>
							<td> <?php if($am7db[0]!=0) echo $ac7db*2;?> </td>
							<td> <?php if($am8db[0]!=0) echo $ac8db*2;?> </td>
						</tr>


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
							$r1 = $row[0];
							$r31 = $row[1];
							$r100 = $row[2];
							$r200 = $row[3];
							$r300 = $row[4];
							$r400 = $row[5];
							$r500 = $row[6];
						}

				if($attiva_1==1){
						$c0listf = $c0list * (1 + ($r1/100));
				}else{$c0listf = "-";};

				$c1listf = $c1list * (1 + ($r31/100));
				$c2listf = $c2list * (1 + ($r100/100));
				$c3listf = $c3list * (1 + ($r200/100));
				$c4listf = $c4list * (1 + ($r300/100));
				$c5listf = $c5list * (1 + ($r400/100));
				$c6listf = $c6list * (1 + ($r500/100));


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


			//-------------------Definisco le differenze conti manuali------------
					$query  = "SELECT cm1, cm31, cm100, cm200, cm300, cm400, cm500 FROM articoli WHERE id='$id'";
					$result = mysql_query($query);
						$row = mysql_fetch_row($result);
						{
						  $diff0 = $row[0];
						  $diff1 = $row[1];
						  $diff2 = $row[2];
						  $diff3 = $row[3];
						  $diff4 = $row[4];
						  $diff5 = $row[5];
						  $diff6 = $row[6];
						}
						
						
						//------Controlla se esistono modifiche manuali-----
						if($diff0>0 or $diff1>0 or $diff2>0 or $diff3>0 or $diff4>0 or $diff5>0 or $diff6>0){
						 echo "Sono presenti modifiche manuali.";
						}
						//echo "attiva: ".$attiva_1;
				?>

				<div align="center">
					<table border="2" cellspacing="1" id="table7">
						<tr>
							<td>Metrature:</td>
							<td align="center"><b><?php if($attiva_1==1) echo $m0list."/".($m1list-1) ?></b></td>
							<td align="center"><b><?php echo $m1list."/".($m2list-1) ?></b></td>
							<td align="center"><b><?php echo $m2list."/".($m3list-1) ?></b></td>
							<td align="center"><b><?php echo $m3list."/".($m4list-1) ?></b></td>
							<td align="center"><b><?php echo $m4list."/".($m5list-1) ?></b></td>
							<td align="center"><b><?php echo $m5list."/".($m6list-1) ?></b></td>
							<td align="center"><b><?php echo $m6list."/"."--->" ?></b></td>
						</tr>

						<tr>
							<td>Totali:</td>
							<td align="center"><?php if($attiva_1==1) echo $c0list;?></td>
							<td align="center"><?php echo $c1list;?></td>
							<td align="center"><?php echo $c2list;?></td>
							<td align="center"><?php echo $c3list;?></td>
							<td align="center"><?php echo $c4list;?></td>
							<td align="center"><?php echo $c5list;?></td>
							<td align="center"><?php echo $c6list;?></td>
						</tr>

						<tr>
							<td>Ricarico Originale:</td>
							<td align="center"><?php if($attiva_1==1) echo $c0listf;?></td>
							<td align="center"><?php echo $c1listf;?></td>
							<td align="center"><?php echo $c2listf;?></td>
							<td align="center"><?php echo $c3listf;?></td>
							<td align="center"><?php echo $c4listf;?></td>
							<td align="center"><?php echo $c5listf;?></td>
							<td align="center"><?php echo $c6listf;?></td>
						</tr>

						<tr>
							<td>Ricarico Finale:</td>
							<td align="center"><?php if($attiva_1==1) echo $c0listf+$diff0;?></td>
							<td align="center"><?php echo $c1listf+$diff1;?></td>
							<td align="center"><?php echo $c2listf+$diff2;?></td>
							<td align="center"><?php echo $c3listf+$diff3;?></td>
							<td align="center"><?php echo $c4listf+$diff4;?></td>
							<td align="center"><?php echo $c5listf+$diff5;?></td>
							<td align="center"><?php echo $c6listf+$diff6;?></td>
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




						</table>
				</div>



				</fieldset>

			&nbsp;</td>
		</tr>
	</table>
</div>





<?php
  mysql_close($con);
?>