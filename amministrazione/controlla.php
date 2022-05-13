<?php
session_start();

$logina = trim($_POST["login"]);
$passworda = trim($_POST["password"]);

if($logina==NULL or $passworda==NULL){
      $_SESSION['messaggio']='Login e Password non possono essere vuoti.';
      header("location: ../index.htm");
}else{



$esito="KO";
include("cat.php");
//--------------------Controlla login dal Database-------------------
$con = mysql_connect($localhost.":".$localporta,$locallogin,$localpass);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
   }
 mysql_select_db($localnome, $con);
		//------------Seleziona auth------------
		$query  = "SELECT id, login, password FROM login WHERE login = '$logina' && password = '$passworda'";
		$result = mysql_query($query);
			while($row = mysql_fetch_row($result))
			{
			  $id = $row[0];
			  $login = $row[1];
			  $password = $row[2];

			  if(trim($login)==trim($logina) && trim($password)==trim($passworda) && $logina!=NULL && $passworda!=NULL){
			    $esito="OK";
			    $_SESSION['utente'] = $login;
				}
			}

}

if($esito=="OK"){
	$_SESSION['utente']=$login;
	header("location: frame.html");

	//--------------------------Scrive nel LOG------------------------------
	 $utente=$_SESSION['utente'];
	 $iprem=getenv(REMOTE_ADDR);
	 mysql_query("INSERT INTO log (descrizione, utente, ip)
	 VALUES ('Accesso Effettuato', '$utente', '$iprem')");

}else{

	//--------------------------Scrive nel LOG------------------------------
	 $utente=$_SESSION['utente'];
	 $iprem=getenv(REMOTE_ADDR);
	 mysql_query("INSERT INTO log (descrizione, utente, ip)
	 VALUES ('Accesso Negato', '$utente', '$iprem')");

	$_SESSION['messaggio']='Login o password non corrispondente.';
	header("location: ../index.htm");
}




mysql_close($con);
?>
