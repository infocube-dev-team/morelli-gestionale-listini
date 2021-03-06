<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image('logo.jpg',10,6,22);

    // Titolo
    // Arial bold 15
    $this->SetFont('Arial','BU',10);
    // Move to the right
    $this->Cell(30);
    // Title
    $this->Cell(130,18,'La Morelli srl si riserva, data la enorme instabilit� del costo delle materie prime, di attuare eventuali anumenti.',0,0,'C');
    // Line break
    $this->Ln(20);

	// ALTEZZA(WIDTH)
	$this->Cell(-130);
	// Arial italic 8
	$this->SetFont('Arial','I',5);
	// Page number
    $this->Cell(620,-35,'ALTEZZA(WIDTH)+/- 3%',0,0,'C');

	// Listino Accessori
	$this->Cell(-480);
	// Arial italic 8
	$this->SetFont('Arial','I',6);
	// Page number
    $this->Cell(31,-13,'Listino Accessori A/I 22.23 A PARTIRE DAL 02/08/2021',0,0,'C');


	// TITOLI PICCOLI
	$this->Cell(-41);
	// ----------------
	$this->SetFont('Arial','B',7);
	// Colonne
    $this->Cell(0,4,'ARTICOLO                                                             Acc.        500 mt.   400/499mt.  300/399mt.  200/299mt.  199/199mt.   31/99mt.   1/30mt.  Composizione     GR.MQ.',1,1);
}






	// Page footer
	function Footer()
	{
	    // Position at 1.5 cm from bottom
	    $this->SetY(-15);
	    // Arial italic 8
	    $this->SetFont('Arial','I',7);
	    // Page number
	    $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
	}

}



// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',6);




 include("cat.php");
//--------------------Seleziona Articolo dal Database-------------------
$con = mysql_connect($localhost.":".$localporta,$locallogin,$localpass);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
   }
 mysql_select_db($localnome, $con);


//--------------opzioni del listino------------------------
		$query  = "SELECT larghezza, righe, ordine, mostra_altezza, misura, contorni, moneta, separatore, font, font_dim FROM opzioni_listino";
		$result = mysql_query($query);
			while($row = mysql_fetch_row($result))
			{
				$larghezza = $row[0];
				$righe = $row[1];
				$ordine = $row[2];
				$mostra_altezza = $row[3];
				$misura = $row[4];
				$contorni = $row[5];
				$moneta = $row[6];
				$separatore = $row[7];
				$font = $row[8];
				$font_dim = $row[9];
			}

    //---------------------Seleziona Articolo----------------
    $inc = 0;
	$queryh  = "SELECT id, nome, seq_accoppiature FROM articoli WHERE stampa='ON' ORDER BY $ordine";
	$resulth = mysql_query($queryh);
	 while($rowh = mysql_fetch_row($resulth))
		{
		 $id_articolo = strtoupper($rowh[0]);
		 $nome = strtoupper($rowh[1]);
		 $seq_accoppiature = strtoupper($rowh[2]);

/*
			//------------------recupera ordine della sequenza accoppiature------------
		    $querysd  = "SELECT ordine FROM seq_accoppiature WHERE id='$seq_accoppiature'";
			$resultsd = mysql_query($querysd);
			 $rowsd = mysql_fetch_row($resultsd);
				{
				 $seq_accoppiature = strtoupper($rowsd[0]);
				}
*/

			$array[$inc]=$id_articolo;
			 $inc = $inc+1;

			$test = $array[0];




  			$new_tipo = explode(" ", $nome);
  			$new_tipo = $new_tipo[0]." ".$new_tipo[1];





			  //--------------------Distinzione per tipo/nome--------------------
			  if(trim($new_tipo)!=trim($old_tipo)){
			   $pdf->Ln(2);

			   $pdf->SetFont('Times','',6);
			   	$pdf->SetX(10);
    			//$pdf->Write(5,$nome);
    			$pdf->Write(5,$test);

				/*
				    //---------------------Seleziona Articolo----------------
					$queryd  = "SELECT nome, altezza, composizione, grmq, id, dettagli, seq_accoppiature FROM articoli WHERE stampa='ON' ORDER BY $ordine, seq_accoppiature";
					$resultd = mysql_query($queryd);
					 while($rowd = mysql_fetch_row($resultd))
						{
						  $nome = strtoupper($rowd[0]);
						  $altezza = $rowd[1];
						  $composizione = $rowd[2];
						  $grmq = $rowd[3];
						  $id = $rowd[4];
						  $dettagli = $rowd[5];
						  $seq_accoppiature = $rowd[6];

							 $scrivi = NULL;
							 $acc = NULL;
							 $grmq_print = NULL;


							//------------------Seleziona Prezzi---------------
							$queryf  = "SELECT 500mt, 400mt, 300mt, 200mt, 100mt, 31mt, 1mt FROM listino WHERE id_articolo='$id'";
							$resultf = mysql_query($queryf);
							 $rowf = mysql_fetch_row($resultf);
								{
								  $mt500 = str_replace(".", $separatore, $rowf[0]);
								  $mt400 = str_replace(".", $separatore, $rowf[1]);
								  $mt300 = str_replace(".", $separatore, $rowf[2]);
								  $mt200 = str_replace(".", $separatore, $rowf[3]);
								  $mt100 = str_replace(".", $separatore, $rowf[4]);
								  $mt31 = str_replace(".", $separatore, $rowf[5]);
								  $mt1 = str_replace(".", $separatore, $rowf[6]);
								}






							  //--------------Conversione dell' altezza--------------
								if($mostra_altezza=="ON" && $scrivi=="SI"){
								 if($misura == "cm"){
								  $alt = $altezza." ".$misura;
								 }
								 if($misura == "mm"){
								  $alt = ($altezza*10)." ".$misura;
								 }
								 if($misura == "mt"){
								  $alt = ($altezza/100)." ".$misura;
								 }
								}else{
								  $alt = NULL;
								}






				 $pdf->SetFont('Times','',6);


				if($mt500>0.00){
				 $mon500 = $moneta;
				}else{
				 $mon500 = NULL;
				}
				if($mt400>0.00){
				 $mon400 = $moneta;
				}else{
				 $mon400 = NULL;
				}
				if($mt300>0.00){
				 $mon300 = $moneta;
				}else{
				 $mon300 = NULL;
				}
				if($mt200>0.00){
				 $mon200 = $moneta;
				}else{
				 $mon200 = NULL;
				}
				if($mt100>0.00){
				 $mon100 = $moneta;
				}else{
				 $mon100 = NULL;
				}
				if($mt31>0.00){
				 $mon31 = $moneta;
				}else{
				 $mon31 = NULL;
				}
				if($mt1>0.00){
				 $mon1 = $moneta;
				}else{
				 $mon1 = NULL;
				}
								//-------------traduci nome accoppiatura--------
								$querya  = "SELECT nome FROM seq_accoppiature WHERE ordine='$seq_accoppiature'";
								$resulta = mysql_query($querya);
									while($rowa = mysql_fetch_row($resulta))
									{
									  $acc = ucwords(strtolower($rowa[0]));
									}


					$pdf->SetX(10);
				    $pdf->Write(5,$nome);

					$pdf->SetX(65);
				    $pdf->Write(5,$acc);

					$pdf->SetX(76);
				    $pdf->Write(5,'� '.$mt500);

					$pdf->SetX(87);
				    $pdf->Write(5,'� '.$mt400);

					$pdf->SetX(101);
				    $pdf->Write(5,'� '.$mt300);

					$pdf->SetX(115);
				    $pdf->Write(5,'� '.$mt200);

					$pdf->SetX(129);
				    $pdf->Write(5,'� '.$mt100);

					$pdf->SetX(143);
				    $pdf->Write(5,'� '.$mt31);


					if($mt1>0){
					 $euro = '� '.$mt1;
					}else{
					 $euro = '- ';
					}
					$pdf->SetX(156);
				    $pdf->Write(5,$euro);




					$pdf->SetX(165);
				    $pdf->Write(5,$composizione);

					$pdf->SetX(192);
				    $pdf->Write(5,$grmq);

					$pdf->Cell(0,3,'',0,1);




					//----------------Inserisci le note se presenti---------------
				    if($dettagli!=NULL){
				     $dettagli = str_replace("\n", ", ", $dettagli);
				     $pdf->SetFont('Times','B',5);
				     $pdf->Ln(1.7);
					  $pdf->SetX(10);
					  $pdf->Write(0,strtoupper(" -  $dettagli"));
					}

				*/


    			unset($array);
    			$inc=0;
			  }



  			//----------Distinzione tipologie-----------------
  			$old_tipo = explode(" ", $nome);
  			$old_tipo = $old_tipo[0]." ".$old_tipo[1];
 }



    $pdf->Output();
 mysql_close($con);
?>
