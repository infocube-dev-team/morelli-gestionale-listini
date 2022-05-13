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
  $metratura_nulla=0;

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
			
			$metratura[0]=0;
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
//inserire qui la parte copiata da articoli_crea.php
//fino a fondo pagina								 
								 
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

								//serve ad eliminare la metratura 0 in caso di minimo maggiore di 0
								if($m1[0]>0){
									$metratura_nulla=1;
								}
								//caso articolo tekno race air
								if($m1[0]==0 && $m1[1]<51 && $m1[1]>0){
									echo "eccolo!";
									$metratura_nulla=0;
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
								for($i=1;$i<9;$i++){
									${"disegno_m$i"} = ${"m$i"}[0]."/".${"m$i"}[1];
								}

								?>

								<div align="left">
									<table border="0" cellspacing="3" id="table5" width="100%">
										<tr>
											<td> <b> <?php echo $disegno_m1;?> </b></td>

										 <?php


										//-------------trovo tutti i valori di metratura------------------
										 for($i=1;$i<9;$i++){
											if(${"m$i"}[0]!=0){

												if(count($metratura)<2){
													$metratura[]=${"m$i"}[0];
													//echo count($metratura)." ";
												}else{
													//valuto la differenza tra la metratura in esame e quelle già presenti
													for($j=0;$j<count($metratura);$j++){
														if($metratura[$j]>${"m$i"}[0]){
															$diff_ele[$j]=$metratura[$j]-${"m$i"}[0];
														}else{
															$diff_ele[$j]=${"m$i"}[0]-$metratura[$j];
														}
														//echo $diff_ele[$j];
													}
													$dist_min=min($diff_ele);
													//echo "dist_min: ".$dist_min." ";
													if($dist_min>5){
														//echo "valore inserito: ".${"m$i"}[0];
														$metratura[]=${"m$i"}[0];
													}
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

								if($metratura[0]==0 && $metratura_nulla==1) {array_shift($metratura);}

								//------caso Frigerio-----
								if($attiva_1==1){
									//echo "shift metratura  ";
									//array_shift($metratura);
								}


								for($i=0;$i<=count($metratura);$i++){
									$j=$i+1;
									${"am$j"."db"}[0]=$metratura[$i];
								}
								echo "<br>";
								//------------aggiusto gli intervalli--------------
								for($i=1;$i<count($metratura);$i++){
									$j=$i+1;
									${"am$i"."db"}[1]=${"am$j"."db"}[0]-1;
									if($i==count($metratura)-1){
										${"am$j"."db"}[1]="-->";
									}
								}
								
								for($i=1;$i<=count($metratura);$i++){
									${"ac$idb"} = 0;
								}
								
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

								for($i=1; $i<=count($metratura); $i++){
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
							<?php for($j=1;$j<=count($metratura);$j++){?>
								<td> <?php 
								if($j==1){ echo $am1db[0]."/".$am1db[1];}
								elseif(${"am$j"."db"}[0]!=0) echo ${"am$j"."db"}[0]."/".${"am$j"."db"}[1];?> </td>
							<?php
							}
							?>
						</tr>

						<tr>
							<td><b>Totali: </b></td>
							<?php for($j=1;$j<=count($metratura);$j++){?>
								<td> <?php 
								if($j==1){ echo $ac1db;}
								elseif(${"am$j"."db"}[0]!=0) echo ${"ac$j"."db"};?> </td>
							<?php
							}
							?>
						</tr>

						<?php for($i=50;$i<=100;$i=$i+5){?>
						<tr>
							<td><b>Ricarico <?php echo $i."%" ?></b></td>
							<?php for($j=1;$j<=count($metratura);$j++){?>
								<td> <?php 
								if($j==1){echo $ac1db+round(($ac1db*$i/100), 2);}
								elseif(${"am$j"."db"}[0]!=0) echo ${"ac$j"."db"}+round((${"ac$j"."db"}*$i/100), 2);?> </td>
							<?php
							}
							?>
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

				//echo $c1listf." ".$c2listf." ".$c3listf." ".$c4listf." ".$c5listf." ".$c6listf."   ";


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
					${"c$k"."listf"}=${"c$k"."listf"}+($g*0.15);
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

				for($n=0;$n<7;$n++){
					for($i=1;$i<6;$i++){
						$j=$i+1;
						if(${"dec$n"} > ${"arr$i"} && ${"dec$n"} <= ${"arr$j"}){
							${"dec$n"}=${"arr$j"};
						}elseif(${"dec$n"}<$arr1){
							${"dec$n"}=$arr1;
						}elseif(${"dec$n"}>$arr6){
							${"dec$n"}=1+$arr1;
						}
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
							<td align="center"><?php if($attiva_1==1) echo $c0listf;?></td>
							<td align="center"><?php echo $c1listf;?></td>
							<td align="center"><?php echo $c2listf;?></td>
							<td align="center"><?php echo $c3listf;?></td>
							<td align="center"><?php echo $c4listf;?></td>
							<td align="center"><?php echo $c5listf;?></td>
							<td align="center"><?php echo $c6listf;?></td>
						</tr>





			<?php
	//----fino a qui ****
//fino a qui!!!
			//-------------------Recupero i costi di listino------------
					$query  = "SELECT 500mt, 400mt, 300mt, 200mt, 100mt, 31mt, 1mt FROM listino WHERE id_articolo='$id'";
					$result = mysql_query($query);
					$differ=array();
					while($row = mysql_fetch_row($result))
						{
						  $differ[0] = $row[6];
						  $differ[1] = $row[5];
						  $differ[2] = $row[4];
						  $differ[3] = $row[3];
						  $differ[4] = $row[2];
						  $differ[5] = $row[1];
						  $differ[6] = $row[0];
						}

			for($i=0;$i<count($differ);$i++){

					if($differ[$i]==0){
						${"color$i"} = "66CCFF";
						$differ[$i] = "0";
					}else{
						if($differ[$i]<0){
							${"color$i"} = "FF0000";
						}
						if($differ[$i]>0){
							${"color$i"} = "00FF00";
						}
					}
				}
			?>



						<tr>
							<td>
							<p align="right">Diff.</td>
							<td align="center"> <font color="#<?php echo $color0;?>"> <?php if($attiva_1==1){echo $differ[0]-$c0listf;}else{echo "-";};?> </font> </td>
							<td align="center"> <font color="#<?php echo $color1;?>"> <?php echo round($differ[1]-$c1listf, 2);?> </font> </td>
							<td align="center"> <font color="#<?php echo $color2;?>"> <?php echo round($differ[2]-$c2listf, 2);?> </font> </td>
							<td align="center"> <font color="#<?php echo $color3;?>"> <?php echo round($differ[3]-$c3listf, 2);?> </font> </td>
							<td align="center"> <font color="#<?php echo $color4;?>"> <?php echo round($differ[4]-$c4listf, 2);?> </font> </td>
							<td align="center"> <font color="#<?php echo $color5;?>"> <?php echo round($differ[5]-$c5listf, 2);?> </font> </td>
							<td align="center"> <font color="#<?php echo $color6;?>"> <?php echo round($differ[6]-$c6listf, 2);?> </font> </td>
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
							<td align="center"><?php if($attiva_1==1){echo $differ[0];}?></td>
							<td align="center"><?php echo $differ[1];?></td>
							<td align="center"><?php echo $differ[2];?></td>
							<td align="center"><?php echo $differ[3];?></td>
							<td align="center"><?php echo $differ[4];?></td>
							<td align="center"><?php echo $differ[5];?></td>
							<td align="center"><?php echo $differ[6];?></td>
						</tr>
						</table>
				</div>



				</fieldset>

			</td>



			</tr>


			</table>
	</div>
	<p>&nbsp;</p>
<?php


  mysql_close($con);
?>