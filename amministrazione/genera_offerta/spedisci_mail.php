<head>
<meta http-equiv="Content-Language" content="it">
<link rel="stylesheet" type="text/css" href="../../style.css">
</head>

<br><b><a target="_parent" href="genera_offerta.php"><font color="#00FF00">Indietro</font></a></b><br><br>

<?php
session_start();
$email1=$_SESSION['email'];
$mail_operatore=$_SESSION['mail_operatore'];
//echo $mail_operatore;
if(!(isset($_SESSION['i']))) $_SESSION['i']=0;
$_SESSION['i'];

?>

<form method="POST" action="invio.php" target="<?php if($_SESSION['i']<1) echo "_parent" ?>">
	<div align="center">
		<table border="0" cellspacing="2"  id="table1">
			<tr>
				<td colspan="2">
				<p align="center"><b>Spedisci mail al cliente</b></td>
			</tr>
			<tr>
				<td>Da:</td>
				<td>
				<input type="text" name="mail_operatore" size="40" value="<?php echo $mail_operatore; ?>">
				<input type="hidden" name="cont" id="cont" value="<?php echo $_SESSION['i']; ?>"></td>
			</tr>
			<tr>
				<td colspan="2"><hr></td>
			</tr>
			<tr>
				<td>A: </td>
				<td><input type="text" name="email1" size="40" value="<?php echo $email1; ?>"></td>
			</tr>
			<tr>
				<td>CC: </td>
				<td><input type="text" name="cc" size="40" value="<?php echo $_SESSION['cc']; ?>"></td>
			</tr>
			<tr>
				<td>Oggetto: </td>
				<td><input type="text" name="oggetto" size="40" value="<?php echo $_SESSION['oggetto']; ?>"></td>
			</tr>
		</table>
	</div>
	<p><input type="submit" value="Spedisci Mail" name="B1"></p>
</form>

<?php
$_SESSION['i']++;

//echo $_SESSION['i'];
if($_SESSION['i']>1){ 
		echo "<br><font color=#ffffff>".$_SESSION['error']."<br></font>";
}
?>