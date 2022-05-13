
<head>
<meta http-equiv="Content-Language" content="it">
<link rel="stylesheet" type="text/css" href="../../style.css">
</head>

<?php
 include("cat.php");
//--------------------Seleziona Articolo dal Database-------------------
$con = mysql_connect($localhost.":".$localporta,$locallogin,$localpass);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
   }
 mysql_select_db($localnome, $con);





	//------------PULIZIA della tabella listino attuale---------
		mysql_query("DELETE FROM listino");
		mysql_query("ALTER TABLE listino AUTO_INCREMENT=1");



//------------Seleziona elemento ------------
$queryxs  = "SELECT id FROM articoli WHERE stampa='ON'";
 $resultxs = mysql_query($queryxs);
 	while($rowxs = mysql_fetch_row($resultxs))
 	{
 	  $id = $rowxs[0];

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

				$c0listf = $c0list * $r1;
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

				for($i=1;$i<7;$i++){
					${"intpart$i"} = floor(${"c$i"."listf"});
					${"dec$i"} = ${"c$i"."listf"}-${"intpart$i"};
				}

				$arr1=0.15;
				$arr2=0.35;
				$arr3=0.55;
				$arr4=0.75;
				$arr5=0.95;
				$arr6=0.99;

				for($n=1;$n<7;$n++){
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

				?>






			<?php
	if(isset($_GET['Ricalcola'])){
	   if($_GET['cm31']!=0){
		$diff31 = $_GET['cm31']-$c1listf;
	   }
	   if($_GET['cm100']!=0){
		$diff100 = $_GET['cm100']-$c2listf;
	   }
	   if($_GET['cm200']!=0){
		$diff200 = $_GET['cm200']-$c3listf;
	   }
	   if($_GET['cm300']!=0){
		$diff300 = $_GET['cm300']-$c4listf;
	   }
	   if($_GET['cm400']!=0){
		$diff400 = $_GET['cm400']-$c5listf;
	   }
	   if($_GET['cm500']!=0){
		$diff500 = $_GET['cm500']-$c6listf;
	   }

	   $query = "UPDATE articoli SET cm31='$diff31', cm100='$diff100', cm200='$diff200', cm300='$diff300', cm400='$diff400', cm500='$diff500' WHERE id='$id'";
	    $result = mysql_query($query);
	}


			//-------------------Definisco le differenze conti manuali------------
					$query  = "SELECT cm31, cm100, cm200, cm300, cm400, cm500 FROM articoli WHERE id='$id'";
					$result = mysql_query($query);
						$row = mysql_fetch_row($result);
						{
						  $diff31 = $row[0];
						  $diff100 = $row[1];
						  $diff200 = $row[2];
						  $diff300 = $row[3];
						  $diff400 = $row[4];
						  $diff500 = $row[5];
						}


				if($diff31==0){
				 $color1 = "66CCFF";
					$diff31 = "0";
				}else{
				  if($diff31<0){
				 	$color1 = "FF0000";
				  }
				  if($diff31>0){
				 	$color1 = "00FF00";
				  }
				}

				if($diff100==0){
				 $color2 = "66CCFF";
					$diff100 = "0";
				}else{
				  if($diff100<0){
				 	$color2 = "FF0000";
				  }
				  if($diff100>0){
				 	$color2 = "00FF00";
				  }
				}

				if($diff200==0){
				 $color3 = "66CCFF";
					$diff200 = "0";
				}else{
				  if($diff200<0){
				 	$color3 = "FF0000";
				  }
				  if($diff200>0){
				 	$color3 = "00FF00";
				  }
				}

				if($diff300==0){
				 $color4 = "66CCFF";
					$diff300 = "0";
				}else{
				  if($diff300<0){
				 	$color4 = "FF0000";
				  }
				  if($diff300>0){
				 	$color4 = "00FF00";
				  }
				}

				if($diff400==0){
				 $color5 = "66CCFF";
					$diff400 = "0";
				}else{
				  if($diff400<0){
				 	$color5 = "FF0000";
				  }
				  if($diff400>0){
				 	$color5 = "00FF00";
				  }
				}

				if($diff500==0){
				 $color6 = "66CCFF";
					$diff500 = "0";
				}else{
				  if($diff500<0){
				 	$color6 = "FF0000";
				  }
				  if($diff500>0){
				 	$color6 = "00FF00";
				  }
				}


							$ric31 =  $c1listf+$diff31;
							$ric100 = $c2listf+$diff100;
							$ric200 = $c3listf+$diff200;
							$ric300 = $c4listf+$diff300;
							$ric400 = $c5listf+$diff400;
							$ric500 = $c6listf+$diff500;


    	mysql_query("INSERT INTO listino (id_articolo, 500mt, 400mt, 300mt, 200mt, 100mt, 31mt, 1mt)
     	 VALUES ('$id', '$ric500', '$ric400', '$ric300', '$ric200', '$ric100', '$ric31', '$ric1')");



}


 mysql_close($con);
?>


<br>
<br>
<br>
<br>
<br>
<br>

<p><font color="#FFFFFF" size="3">Operazione Eseguita Correttamente</font></p>



