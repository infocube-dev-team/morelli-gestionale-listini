<?php
require('fpdf/fpdf.php');
include("taglio.php");

define('EURO',chr(128));

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
    $this->Cell(130,18,utf8_decode('La Morelli srl si riserva, data la enorme instabilit√† del costo delle materie prime, di attuare eventuali anumenti.'),0,0,'C');
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
    $this->Cell(31,-13,'LISTINO ACCESSORI  P/E 2023 A PARTIRE DAL 01.02.2022',0,0,'C');


	// TITOLI PICCOLI
	$this->Cell(-41);
	// ----------------
	$this->SetFont('Arial','B',7);
	// Colonne

//	$this->Cell(0,4,'ARTICOLO                                           Acc.        Altezza      500 mt.   400/499mt.  300/399mt.  200/299mt.  100/199mt.   min/99mt.   sott.min  Composizione     GR.ML.',1,1);
    $this->Cell(0,4,'ARTICOLO                                           Acc.        Altezza      300 mt.  200/299mt.  100/199mt.   min/99mt.   sott.min        Composizione     GR.ML.',1,1);
}






	// Page footer
	function Footer()
	{
	    // Position at 1.5 cm from bottom
	    $this->SetY(-15);

		// Scritta
	    $this->Cell(10,0,utf8_decode('Per i sottominimi √® previsto un supplemento del 20% rispetto al valore del minimo nelle opzioni.'),0,0,'');
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
		$query  = "SELECT larghezza, righe, ordine, mostra_altezza, misura, contorni, moneta, separatore, font, font_dim, rsmin FROM opzioni_listino";
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
				$rsmin = $row[10];
			}

    //---------------------Seleziona Articolo----------------
	//$query  = "SELECT nome, altezza, composizione, grmq, id, dettagli, seq_accoppiature FROM articoli WHERE stampa='ON' ORDER BY $ordine ";
	$query  = "SELECT nome, altezza, composizione, grmq, id, dettagli, seq_accoppiature, minimo, smin FROM (SELECT nome, altezza, composizione, grmq, id, dettagli, seq_accoppiature, minimo, smin FROM articoli WHERE stampa='ON' ORDER BY seq_accoppiature) as tbl ORDER BY tbl.nome";
	$result = mysql_query($query);
	 while($row = mysql_fetch_row($result))
		{
		  $nome = strtoupper($row[0]);
		  $altezza = $row[1];
		  $composizione = $row[2];
		  $grmq = $row[3];
		  $id = $row[4];
		  $dettagli = $row[5];
		  $seq_accoppiature = $row[6];
		  $minimo = $row[7];
          $smin = $row[8];

			 $scrivi = NULL;
			 $acc = NULL;
			 $grmq_print = NULL;


			//------------------Seleziona Prezzi---------------
			$queryf  = "SELECT 500mt, 400mt, 300mt, 200mt, 100mt, 31mt, 1mt, sminmt FROM listino WHERE id_articolo='$id'";
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
				  $sminmt = str_replace(".", $separatore, $rowf[7]);
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




  			$new_tipo = explode(" ", $nome);
  			$new_tipo = $new_tipo[0]." ".$new_tipo[1];

			  //--------------------Distinzione per tipo/nome--------------------
			  if(trim($new_tipo)!=trim($old_tipo)){
			   $pdf->Ln(2);
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



		//----------------Controlla le altezze----------------
		 if($altezza=="0.00"){
          $altezza=NULL;
		 }
		 if($altezza!=NULL){
		  $altezza = round($altezza,1)." cm.";
		 }


	$pdf->SetX(10);
    $pdf->Write(5,$nome);

	$pdf->SetX(53);
    $pdf->Write(5,$acc);

	$pdf->SetX(64);
    $pdf->Write(5,$altezza);

    $pdf->SetX(76);
    $pdf->Write(5,EURO.' '.$mt300);

	$pdf->SetX(87);
    $pdf->Write(5,EURO.' '.$mt200);

	$pdf->SetX(101);
    $pdf->Write(5,EURO.' '.$mt100);

	$pdf->SetX(115);
	if ($minimo>0){
		$pdf->Write(5,'('.$minimo.')'.EURO.' '.$mt31);
	} else {
		$pdf->Write(5,EURO.' '.$mt31);
	}

	if($mt1>0){
		$euro = '('.$smin.')' . '<80> '.$mt1;
	}else{
        $euro = '- ';
    }

	//$pdf->SetX(154);
	//$pdf->Write(5,$euro);
	if($sminmt>0 && $rsmin>0){
		$_mt31 = str_replace(",", ".", $mt31);
		$euro = '('.$smin.')' . EURO.' '.sprintf('%0.2f', ($_mt31*$rsmin/100)+$_mt31);
	}else{
		$euro = '- ';
	}
	$pdf->SetX(129);
    $pdf->Write(5,$euro);


	$pdf->SetX(143);
    $pdf->Write(5,$composizione);

    $pdf->SetX(164);
    $pdf->Write(5,$grmq);

	$pdf->Cell(0,3,'',0,1);


	//----------------Inserisci le note se presenti---------------
/*     if($dettagli!=NULL){
     $dettagli = str_replace("\n", ", ", $dettagli);
	 $max_char=165;
	 $note_tag=array();
	 		if(strlen($dettagli)>$max_char){
				while(strlen($dettagli)>$max_char){
					//se ho commenti piÔŅĹ lunghi del rigo...taglio la stringa e stampo il primo pezzo
					$note_tag=TagliaStringa($dettagli, $max_char);
					$pdf->SetFont('Times','B',5);
					$pdf->Ln(1.7);
					$pdf->Write(0,strtoupper(" - $note_tag[0] "));
					
					//il secondo pezzo lo rielaboro
					$dettagli=$note_tag[1];
				}
				$pdf->Ln(1.7);
				$pdf->Write(0,strtoupper(" - $note_tag[1] "));
			}else{
				$pdf->SetFont('Times','B',5);
				$pdf->Ln(1.7);
				$pdf->SetX(10);
				$pdf->Write(0,strtoupper(" - $dettagli "));
			}
	} */


  			//----------Distinzione tipologie-----------------
  			$old_tipo = explode(" ", $nome);
  			$old_tipo = $old_tipo[0]." ".$old_tipo[1];
 }



    $pdf->Output();
 mysql_close($con);
?>
