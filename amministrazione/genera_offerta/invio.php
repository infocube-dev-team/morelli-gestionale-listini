<head>
<meta http-equiv="Content-Language" content="it">
<link rel="stylesheet" type="text/css" href="../../style.css">
</head>

<?php
session_start();

$_SESSION['error'];
//include('sendmailclass.php');

$email1=$_POST['email1'];
$cc=$_POST['cc'];
$oggetto=$_POST['oggetto'];
$file=$_SESSION['allegato'];
$testo_libero = $_SESSION['testo_libero'];
$mail_operatore=$_POST['mail_operatore'];

//dati per l'offerta
$operatore = $_SESSION['utente'];
$id_cliente=$_SESSION['ragione_sociale_id'];
$testo=$_SESSION['testo_libero'];
$data=$_SESSION['data'];
$protocollo=str_replace('.pdf','',$_SESSION['allegato']);

$data_tmp = explode(" ", $data);
$data_tmp1 = $data_tmp[0];
$ora_tmp = $data_tmp[2];
$data_tmp2 = explode("/", $data_tmp1);
$data = $data_tmp2[2]."-".$data_tmp2[1]."-".$data_tmp2[0]." ".$ora_tmp.":00";

$esito=0;

$path="../Offerte/";

if($file){
	$allegato=$path.$file;
}else{
	$allegato="";
}
if(!$testo_libero) $testo_libero="-";

//-----spedisco la mail-----
require_once('class.phpmailer.php');

$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

$mail->IsSMTP(); // telling the class to use SMTP

try {
  $mail->Host       = "mail.cs.interbusiness.it"; // SMTP server
  $mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
  $mail->SMTPAuth   = false;                  // enable SMTP authentication
  $mail->Port       = 25;                    // set the SMTP port for the GMAIL server
  //$mail->Username   = "morelli"; // SMTP account username
  //$mail->Password   = "morelli";        // SMTP account password
  if($mail_operatore){
	$mail->ValidateAddress($mail_operatore);
	$mail->AddReplyTo($mail_operatore, $operatore);
	$mail->SetFrom($mail_operatore, $operatore);
  }else{
	throw new Exception('Manca mittente!');
  }
  if($email1){
	$mail->ValidateAddress($email1);
	$mail->AddAddress($email1,'');
  }else{
	throw new Exception('Manca destinatario!');
  }
  
  if($oggetto) $mail->Subject = $oggetto;
  if($cc) $mail->AddCC($cc);
  //$mail->AltBody = ''; // optional - MsgHTML will create an alternate automatically
  $mail->MsgHTML($testo_libero);
  $mail->AddAttachment($allegato);      // attachment
  $mail->Send();
  echo "Message Sent OK</p>\n";
  $esito=1;

include("cat.php");
//--------------------Seleziona Articolo dal Database-------------------
$con = mysql_connect($localhost.":".$localporta,$locallogin,$localpass);
if (!$con)
{
	die('Could not connect: ' . mysql_error());
}
mysql_select_db($localnome, $con);

//inserimento offerta
$query="INSERT INTO offerte (id_cliente, operatore, testo, data, protocollo) VALUES ('$id_cliente', '$operatore', '$testo', '$data', '$protocollo')";
$result=mysql_query($query);
$id_offerta=mysql_insert_id();
//if($result!=FALSE){ echo "offerta inserita...inserisco gli articoli";}

//inserimento articoli->offerta
//prima devo rivacare i dati dalla tabella tmp_offerte
$querya  = "SELECT articolo, sconto, da1, da31, da100, da200, da300, da400, da500, note FROM tmp_offerte WHERE operatore = '$operatore'";
$resulta = mysql_query($querya);
//echo $resulta."<br>";
	while($rowa = mysql_fetch_row($resulta))
	{
		$articolo = $rowa[0];
		$sconto = $rowa[1];
		$mt1 = $rowa[2];
		$mt31 = $rowa[3];
		$mt100 = $rowa[4];
		$mt200 = $rowa[5];
		$mt300 = $rowa[6];
		$mt400 = $rowa[7];
		$mt500 = $rowa[8];
		$note = $rowa[9];
//echo "articolo: ".$articolo."<br>";
		//inserisco ogni articolo nella tabella articoli_offerte
		$queryb="INSERT INTO articoli_offerte (id_offerte, articolo, sconto, da1, da31, da100, da200, da300, da400, da500, note) VALUES ('$id_offerta', '$articolo', '$sconto', '$mt1', '$mt31', '$mt100', '$mt200', '$mt300', '$mt400', '$mt500', '$note')";
		$resultb = mysql_query($queryb);
		unset($queryb);
		if($resultb!=FALSE) echo "articolo inserito!!!";
	}
//echo "finito!";
mysql_close($con);
} catch (phpmailerException $e) {
  $_SESSION['error'] = $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
  $_SESSION['error'] = $e->getMessage(); //Boring error messages from anything else!
}

if($esito==1){
	header('location: genera_offerta.php?reset=SI');
}else{
	header('location: spedisci_mail.php');
}
?>