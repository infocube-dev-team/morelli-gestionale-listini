<?php
session_start();
date_default_timezone_set('Europe/Rome');
$operatore = $_SESSION['utente'];
$ragione_sociale=$_SESSION['ragione_sociale'];
$_SESSION['testo_libero'] = $_POST['elm1'];
$path="../Offerte/";

//---------------Genera html------------------------------
ob_start(); // start trapping output
$myFile = include("stampa.php");
$staticpage = file_get_contents($myFile);

echo $staticpage;

    $output = ob_get_contents(); // get contents of output
    //write to file, e.g.
    $newfile="stampa.html"; 
    $file = fopen ($newfile, "w"); 
    fwrite($file, $output); 
    fclose ($file);  
    ob_end_clean(); // discard output

//----imposto il nome del file pdf con un prtocollo data-cliente-operatore
//costruisco il nome del file composto da data-cliente-operatore
$data = date("dmyhis");
$nome_file=$path.$data."_".$ragione_sociale."_".$operatore.".pdf";
	
//---------------Genera PDF------------------------------
require('html2fpdf/html2fpdf.php');
$pdf=new HTML2FPDF();
$pdf->AddPage();
$fp = fopen("stampa.html","r");
$strContent = fread($fp, filesize("stampa.html"));
fclose($fp);
$strContent = iconv('UTF-8', 'windows-1252', $strContent);
$pdf->WriteHTML($strContent);
$pdf->Output($nome_file, "");
//$pdf->Output("sample.pdf", "I");
$_SESSION['allegato']=$nome_file;
?>

<html>
<frameset rows="150,*">
<frame src="spedisci_mail.php" border="0" marginwidth="0" marginheight="0" scrolling="auto" name="stampa_e_spedizione" />
<frame src="stampa.php" />
</frameset>

</frameset>

</html>