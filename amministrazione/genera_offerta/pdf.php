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
    $this->Cell(130,18,'Offerta n° ',0,0,'C');
    // Line break
    $this->Ln(20);

	// ALTEZZA(WIDTH)
	$this->Cell(-130);
	// Arial italic 8
	$this->SetFont('Arial','I',5);
	// Page number
    $this->Cell(620,-35,'----',0,0,'C');
}


	// Page footer
	function Footer()
	{
	    // Position at 1.5 cm from bottom
	    $this->SetY(-15);

		// Scritta
	    $this->Cell(10,0,'-',0,0,'');
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
		}









    $pdf->Output();
 mysql_close($con);
?>