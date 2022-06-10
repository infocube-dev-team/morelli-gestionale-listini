<?php

include("cat.php");

session_start();

if(isset($_POST['reset']) && $_POST['reset']=="si"){
	unset($_SESSION['id_cliente']);
	unset($_SESSION['operatore']);
	unset($_SESSION['damese']);
	unset($_SESSION['daanno']);
	unset($_SESSION['dagg']);
	unset($_SESSION['amese']);
	unset($_SESSION['aanno']);
	unset($_SESSION['agg']);
	if(!$_POST['nome']) unset($_POST['id']);
}


$con = mysql_connect($localhost.":".$localporta,$locallogin,$localpass);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
   }
 mysql_select_db($localnome, $con);

?>

<head>
<meta http-equiv="Content-Language" content="it">
<link rel="stylesheet" type="text/css" href="../../style.css">





<script type="text/javascript">
function stopRKey(evt) {
  var evt = (evt) ? evt : ((event) ? event : null);
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
  }
document.onkeypress = stopRKey;
</script>

<link rel="stylesheet" type="text/css" href="../ajax/jquery-ui.css">
<script src="../ajax/jquery.min.js"></script>
<script src="../ajax/jquery-ui.min.js"></script>
</head>



<?php
//echo $id.$data_inizio;

if(isset($_POST['id'])){
	$id_cliente = $_POST['id'];
	$_SESSION['id_cliente']= $_POST['id'];
	$query_cliente="id_cliente='$id_cliente'";
	$queryc="SELECT ragione_sociale FROM clienti where id='$id_cliente'";

	$resultc = mysql_query($queryc);
	while($rowc = mysql_fetch_array($resultc, MYSQL_ASSOC))
	{
		$ragione_sociale=$rowc['ragione_sociale'];
	}
}elseif(isset($_SESSION['id_cliente'])){
	$id_cliente = $_SESSION['id_cliente'];
	$query_cliente="id_cliente='$id_cliente'";
	/* $queryc="SELECT ragione_sociale FROM clienti where id='$id_cliente'";

	$resultc = mysql_query($queryc);
	while($rowc = mysql_fetch_array($resultc, MYSQL_ASSOC))
	{
		$ragione_sociale=$rowc['ragione_sociale'];
	} */
	$_SESSION['ragione_sociale']=$_POST['ragione_sociale'];
}else{
 $query_cliente = "";
 $ragione_sociale="";
}

	//ho l'id del Cliente e ricavo tutte le offerte relative

	
if(isset($_POST['operatore'])){
	$operatore=$_POST['operatore'];
	$_SESSION['operatore']=$_POST['operatore'];
} elseif(isset($_SESSION['operatore'])){
	$operatore=$_SESSION['operatore'];
} 

if(isset($_POST['damese'])){
	$damese=$_POST['damese'];
	$daanno=$_POST['daanno'];
	$dagg=$_POST['dagg'];
	$_SESSION['damese']=$_POST['damese'];
	$_SESSION['daanno']=$_POST['daanno'];
	$_SESSION['dagg']=$_POST['dagg'];
}
if(isset($_SESSION['damese'])){
	$damese=$_SESSION['damese'];
	$daanno=$_SESSION['daanno'];
	$dagg=$_SESSION['dagg'];
}
if(isset($_POST['amese'])){
	$amese=$_POST['amese'];
	$aanno=$_POST['aanno'];
	$agg=$_POST['agg'];
	$_SESSION['amese']=$_POST['amese'];
	$_SESSION['aanno']=$_POST['aanno'];
	$_SESSION['agg']=$_POST['agg'];
}
if(isset($_SESSION['amese'])){
	$amese=$_SESSION['amese'];
	$aanno=$_SESSION['aanno'];
	$agg=$_SESSION['agg'];
}

if(isset($operatore)){
		if($id_cliente!=NULL)
			$query_operatore="AND operatore='$operatore'";
		else 
			$query_operatore=" operatore='$operatore'";
}else{
	 $query_operatore = "";
}


if(isset($damese) && $daanno!=NULL && $dagg!=NULL){
		$data_inizio="$daanno-$damese-$dagg 00:00:00";
		if($amese!=NULL && $aanno!=NULL && $agg!=NULL){
			/* $amese=$_POST['amese'];
			$aanno=$_POST['aanno'];
			$agg=$_POST['agg']; */
			$data_fine="$aanno-$amese-$agg 00:00:00";
			if($operatore!=NULL || $id_cliente!=NULL)
				$query_data=" AND data BETWEEN '$data_inizio' AND '$data_fine'";
			else 
				$query_data=" data BETWEEN '$data_inizio' AND '$data_fine'";
		}elseif(($damese!=NULL && $daanno!=NULL && $dagg!=NULL) && ($amese==NULL && $aanno==NULL && $agg==NULL)){
			$data_fine=date('Y-m-d')." 00:00:00";
			if($operatore!=NULL || $id_cliente!=NULL)
				$query_data=" AND data BETWEEN '$data_inizio' AND '$data_fine'";
			else 
				$query_data=" data BETWEEN '$data_inizio' AND '$data_fine'";
		}
	}else{
	 $query_data = "";
	}

	//echo $data_inizio." ".$data_fine."<br>";
	
if($query_cliente || $query_operatore || $query_data){
	//recupero la ragione sociale del Cliente
	//echo $id_cliente."<br>"."<br>"."<br>";
		
	$query="SELECT id, id_cliente, operatore, testo, data, protocollo FROM offerte where $query_cliente $query_operatore $query_data";
	
	//echo "<font color=#ffffff>".$query."<br></font>";
?>
	
				
				

<?php
	$i=0;
	$result = mysql_query($query);
	
	if($result){
?>
<form method="GET" action="elenca_offerte.php">
		<div align="center">
			<table border="0" width="600" height="26">
			<input type='hidden' name='id' value='<?php echo $id;?>'>
			<input type='hidden' name='operatore' value='<?php if($_POST['operatore']) echo $operatore;?>'>
			<input type="hidden" name="dagg" size="45" id="dagg" value="<?php if($_POST['dagg']) echo $dagg;?>">
			<input type="hidden" name="damese" size="45" id="damese" value="<?php if($_POST['damese']) echo $damese;?>">
			<input type="hidden" name="daanno" size="45" id="daanno" value="<?php if($_POST['daanno']) echo $daanno;?>">
			<input type="hidden" name="agg" size="45" id="agg" value="<?php if($_POST['agg']) echo $agg;?>">
			<input type="hidden" name="amese" size="45" id="amese" value="<?php if($_POST['amese']) echo $amese;?>">
			<input type="hidden" name="aanno" size="45" id="aanno" value="<?php if($_POST['aanno']) echo $aanno;?>">
			
				<tr> 
					<td>NUM</td>
					<td>DATA</td>
					<td>CLIENTE</td>
					<td>OPERATORE</td>
				</tr>
<?php
		while($row = mysql_fetch_array($result))
		{
			
			$id_offerta=$row['id'];
			$id_cliente=$row['id_cliente'];
			$operatore=$row['operatore'];
			$testo = $row['testo'];
			$data = $row['data'];
			$protocollo= $row['protocollo'];
			
			$id=$row['id_cliente'];

			$ragione_soc="";

			if(!$ragione_sociale || $ragione_sociale!=$ragione_soc){
				
				//$id_cliente=$_GET['id'];
				//echo "ragione sociale";
				//ricavo i dati del Cliente
				$querycc="SELECT ragione_sociale FROM clienti where id='$id_cliente'";
				
				$resultcc = mysql_query($querycc);
				while($rowcc = mysql_fetch_array($resultcc, MYSQL_ASSOC))
				{
					$ragione_soc=$rowcc['ragione_sociale'];
					$ragione_sociale=$ragione_soc;
				}
				// echo "ragione".$ragione_soc."<br>";
			}
			
			//echo "sono nella query";
			
			//stampo tutti gli elementi trovati
			?>
				<tr>
					<td><?php echo $id_offerta; ?></td>
					<td><?php echo $data; ?></td>
					<td><?php echo $ragione_sociale; ?></td>
					<td><?php echo $operatore; ?></td>
					<td>
						<p>
						<input type="submit" value="+" name="vis_offerta<?php echo $i;?>"></p>

					<p>
					</td>
				</tr>
			

			<?php
			$offerta="vis_offerta$i";
			//mi servono i dati della singola offerta
			// if($_GET[$offerta]=="+") echo $offerta." ".$_GET[$offerta];
			$second=1;
			
			
			if($_GET[$offerta]=="+"){
			
				$queryb="SELECT articolo, sconto, da1, da31, da100, da200, da300, da400, da500, note FROM articoli_offerte where id_offerte='$id_offerta'";
				
				//echo $queryb."<br>";

			 	$resultb = mysql_query($queryb);
				
				if($resultb!=NULL){
					?>
					<tr>
					<td colspan="7">
				<div align="center">
					<table>
					<?php
					
					while($rowb = mysql_fetch_array($resultb)){
						$id_articolo=$rowb['articolo'];
						$sconto=$rowb['sconto'];
						$mt1=$rowb['da1'];
						$mt31=$rowb['da31'];
						$mt100=$rowb['da100'];
						$mt200=$rowb['da200'];
						$mt300=$rowb['da300'];
						$mt400=$rowb['da400'];
						$mt500=$rowb['da500'];
						$note=$rowb['note'];

						//recupero l'articolo
						$queryd="SELECT nome, seq_accoppiature FROM articoli where id='$id_articolo'";
						$resultd = mysql_query($queryd);
						while($rowd = mysql_fetch_array($resultd, MYSQL_ASSOC))
						{
							$articolo=$rowd['nome'];
							$id_accopp=$rowd['seq_accoppiature'];
						}

						$querye="SELECT nome FROM seq_accoppiature WHERE id = '$id_accopp'";
						$resulte = mysql_query($querye);
						while($rowe = mysql_fetch_array($resulte, MYSQL_ASSOC))
						{
							$seq_accoppiature=$rowe['nome'];
						}


						?>
						<tr>
						<td align="right">Articolo:</td>
							<td colspan="7" class="articolo"><b> <?php echo $articolo."  (".$seq_accoppiature.")";?> </b></td>
							<td rowspan="5">
							</td>
						</tr>
						<tr>
							<td align="right">Metratura:</td>
							<?php
							/*
                            if($mt500>0){
							?>
							<td>500/--&gt;</td>
							<?php
							}
							if($mt400>0){
							?>
							<td>400/499</td>
							<?php
							}
							if($mt300>0){
							?>
							<td>300/399</td>
							<?php
							}
							*/

							if($mt300>0){
							?>
							<td>300/--></td>
							<?php
							}
							if($mt200>0){
							?>
							<td>200/299</td>
							<?php
							}
							if($mt100>0){
							?>
							<td>100/199</td>
							<?php
							}
							if($mt31>0){
							?>
							<td>31/99</td>
							<?php
							 }
							if($mt1>0){
							?>
							<td>1/30</td>
							<?php
							 }
							?>


						</tr>


						<tr>
							<td align="right">Costo:</td>
							<?php
                            /*
							 if($mt500>0){
							?>
							<td bgcolor="#414751"> <b> <?php echo $mt500;?> </b> </td>
							<?php
							}
							if($mt400>0){
							?>
							<td bgcolor="#414751"> <b> <?php echo $mt400;?> </b> </td>
							<?php
							}
                            */
							if($mt300>0){
							?>
							<td bgcolor="#414751"> <b> <?php echo $mt300;?> </b> </td>
							<?php
							}
							if($mt200>0){
							?>
							<td bgcolor="#414751"> <b> <?php echo $mt200;?> </b> </td>
							<?php
							}
							 if($mt100>0){
							?>
							<td bgcolor="#414751"> <b> <?php echo $mt100;?> </b> </td>
							<?php
							}
							 if($mt31>0){
							?>
							<td bgcolor="#414751"> <b> <?php echo $mt31;?> </b> </td>
							<?php
							 }
							if($mt1>0){
							?>
							<td bgcolor="#414751"> <b> <?php echo $mt1;?> </b> </td>
							<?php
							 }
							?>
						</tr>



						<tr>
							<td align="right">Sconto %:</td>
							<td colspan="7"><b> <?php echo $sconto;?>  </b></td>
						</tr>


						<tr>
							<td align="right">Note:</td>
							<td colspan="7" align="justify" width="700" class="info"> <?php echo $note;?> </td>
						</tr>


					<?php
					} 
					?>
					</table>
					</div>
					
											<tr>
							<td colspan="7" align="justify" width="700" class="info"> <hr> </td>
						</tr>
					
					</tr>
					</td>
				<?php
			 	}else echo "<font color=#ffffff>L'offerta non � disponibile!</font>"; 
			
			} 
			$i++;
		}
		if(!$row && $i<1){ 
			echo "<font color=#ffffff> Nessun risultato trovato!!! </font>";
		} 
		?>
	</table>
	</div>
	<?php
			}else{
		echo "<font color=#ffffff> Nessun risultato trovato!!! </font>";
	}
}

?>
 </form>
<body>
</body>

</html>
