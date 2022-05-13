<?php
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
?>





<?php
require('html2fpdf/html2fpdf.php');
$pdf=new HTML2FPDF();
$pdf->AddPage();
$fp = fopen("stampa.html","r");
$strContent = fread($fp, filesize("stampa.html"));
fclose($fp);
$strContent = iconv('UTF-8', 'windows-1252', $strContent);
$pdf->WriteHTML($strContent);
$pdf->Output("sample.pdf", "");
//$pdf->Output("sample.pdf", "I");
echo "PDF file is generated successfully!";
?>
