<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="IT" lang="IT">

<?php 
session_start();
?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 
	 <meta name="keywords" content="" />
	 <meta name="description" content="" />
	 <meta name="author" content=" - - - Street Lamp Interference - - - " />
	 <meta name="MSSmartTagsPreventParsing" content="true" />	
	 
	 <title> Genera Offerta </title>
	 
</head>

<body>

<br />


<div>
	<table align="center" border="0" cellspacing="3" cellpadding="2" id="table3" width="700">
		<tr>
			<td rowspan="4">
			<img border="0" src="../logo.jpg" width="105" height="47" align="left" alt="logo" /></td>
			<td> </td>
			<td>Spett.le <?php echo $_SESSION['ragione_sociale'] ?></td>
		</tr>
		<tr>
			<td> </td>
			<td> </td>
		</tr>
		<tr>
			<td> </td>
			<td> </td>
		</tr>
		<tr>
			<td> </td>
			<td> </td>
		</tr>
	</table>
</div>


<div>
	<table align="center" border="0" cellspacing="3"  id="table2" width="700">
		<tr>
			<td> Data: <?php echo $_SESSION['data'];?> </td>
		</tr>
		<tr>
			<td><hr /> </td>
		</tr>
		<tr>
			<td>  <?php echo $_SESSION['testo_libero'];?> </td>
		</tr>
	</table>
</div>



<br />

<div >
	<table align="center" border="0" cellspacing="3" id="table1" width="700">
	
	
	
<?php
date_default_timezone_set('Europe/Rome');

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

if($mt1==0){
 $mt1 = "-";
}
if($mt31==0){
 $mt31 = "-";
}
if($mt100==0){
 $mt100 = "-";
}
if($mt200==0){
 $mt200 = "-";
}
if($mt300==0){
 $mt300 = "-";
}
if($mt400==0){
 $mt400 = "-";
}
if($mt500==0){
 $mt500 = "-";
}

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
				

			$queryahj  = "SELECT altezza, grmq FROM articoli WHERE id = '$id_articolo'";
			$resultahj = mysql_query($queryahj);
				while($rowahj = mysql_fetch_row($resultahj))
				{
				 $altezza = $rowahj[0];
				 $grmq = $rowahj[1];
				}	
		
		
	          $num_articoli = $num_articoli+1;

if($seq_accoppiature!=NULL){
 $seq_accoppiature = "(".$seq_accoppiature.")";
}else{
 $seq_accoppiature = NULL;
}

if($grmq==0){
 $grmq = "-";
}else{
 $grmq = "<b>Peso:</b> ".$grmq." gr.mq.";
}

if($altezza==0){
 $altezza = "-";
}else{
 $altezza= "<b>Altezza:</b> ".$altezza." cm.";
}
?>
	
	
	
		<tr>
			<td colspan="8"><b> <?php echo $articolo."  ".$seq_accoppiature;?> </b> </td>
		</tr>
		<tr>
            <?php
            /*
            ?>
            <td>500mt./--&gt;</td>
			<td>400/499mt.</td>
			<td>300/399mt.</td>
			*/
			?>
            <td>300mt./--></td>
			<td colspan="2">200/299mt.</td>
			<td>100/199mt.</td>
			<td>31/99mt. </td>
			<td>1/30mt. </td>
		</tr>
		<tr>
            <?php
            /*
			<td> <?php echo $mt500;?> </td>
			<td> <?php echo $mt400;?> </td>
			*/
			?>
			<td> <?php echo $mt300;?> </td>
			<td colspan="2"> <?php echo $mt200;?> </td>
			<td> <?php echo $mt100;?> </td>
			<td> <?php echo $mt31;?> </td>
			<td> <?php echo $mt1;?> </td>
		</tr>


<?php
 if($altezza!="-"){
?>
		<tr>
			<td colspan="8"> <?php echo $altezza;?> </td>
		</tr>
<?php
 }
?>

<?php
 if($grmq!="-"){
?>
		<tr>
			<td colspan="8"> <?php echo $grmq;?> </td>
		</tr>
<?php
 }
?>

<?php
 if($note!=NULL){
?>
		<tr>
			<td colspan="8" align="justify"  class="info"> <?php echo $note;?> </td>
		</tr>
<?php
 }
?>


		<tr>
			<td colspan="8"> <hr /> </td>
		</tr>
		
<?php
  }
    
 mysql_close($con);
?>
		
		
	</table>
</div>



<br />
<br />






 </body>
</html>




